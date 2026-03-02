<?php
require_once '../../configs/conexao.php';

// Definir headers para JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// --- TRATAMENTO DE ERROS GLOBAL PARA RETORNAR SEMPRE JSON ---
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno))
        return false;
    http_response_code(500);
    echo json_encode([
        "mensagem" => "Erro interno no servidor (PHP Error).",
        "detalhes" => "$errstr em $errfile na linha $errline"
    ]);
    exit;
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== NULL && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        echo json_encode([
            "mensagem" => "Erro fatal no processamento.",
            "detalhes" => $error['message'] . " em " . $error['file'] . " na linha " . $error['line']
        ]);
    }
});
// ---------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["mensagem" => "Método não permitido."]);
    exit;
}

if (!isset($_FILES['arquivo'])) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Nenhum arquivo enviado."]);
    exit;
}

$arquivoPath = $_FILES['arquivo']['tmp_name'];
$extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

if (strtolower($extensao) !== 'csv') {
    http_response_code(400);
    echo json_encode(["mensagem" => "Formato inválido. Atualmente apenas .csv é suportado nativamente."]);
    exit;
}

try {
    // Abrir o arquivo
    $handle = fopen($arquivoPath, "r");
    if (!$handle) {
        throw new Exception("Não foi possível abrir o arquivo.");
    }

    // Detectar Delimitador (, ou ;)
    $primeiraLinha = fgets($handle);
    $delimitador = (strpos($primeiraLinha, ';') !== false) ? ';' : ',';
    rewind($handle); // Voltar ao início

    // Pular cabeçalho
    fgetcsv($handle, 1000, $delimitador);

    $sucessoCount = 0;
    $erroCount = 0;
    $mensagensErro = [];
    $index = 0;

    // Processar linhas
    while (($row = fgetcsv($handle, 1000, $delimitador)) !== FALSE) {
        $index++;

        // Mapeamento esperado: [0]Matricula, [1]Nome, [2]Turma, [3]Email
        $matricula = trim($row[2] ?? '');
        $nome = trim($row[0] ?? '');
        $turma_nome = trim($row[3] ?? '');
        $email = trim($row[1] ?? '');

        if (empty($matricula) || empty($nome) || empty($turma_nome)) {
            if (!empty($matricula) || !empty($nome)) { // Só conta erro se não for linha vazia
                $erroCount++;
                $mensagensErro[] = "Linha " . ($index + 1) . ": Dados incompletos (Matrícula, Nome e Turma são obrigatórios).";
            }
            continue;
        }

        // 1. Buscar ID da turma
        $stmt_turma = $conn->prepare("SELECT idturmas FROM turmas WHERE turma_nome = ? AND turmas_status = 'Ativo' LIMIT 1");
        $stmt_turma->bind_param("s", $turma_nome);
        $stmt_turma->execute();
        $res_turma = $stmt_turma->get_result();
        $turma = $res_turma->fetch_assoc();
        $stmt_turma->close();

        if (!$turma) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Turma '$turma_nome' não encontrada.";
            continue;
        }

        $turma_id = $turma['idturmas'];

        // 2. Verificar duplicata
        $stmt_check = $conn->prepare("SELECT idaluno FROM aluno WHERE aluno_matricula = ? LIMIT 1");
        $stmt_check->bind_param("s", $matricula);
        $stmt_check->execute();
        $exists = $stmt_check->get_result()->fetch_assoc();
        $stmt_check->close();

        if ($exists) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Matrícula '$matricula' já cadastrada.";
            continue;
        }

        // 3. Inserir
        $stmt_insert = $conn->prepare("INSERT INTO aluno (aluno_nome, aluno_matricula, aluno_email, turmas_id, aluno_status) VALUES (?, ?, ?, ?, 'Ativo')");
        $stmt_insert->bind_param("sssi", $nome, $matricula, $email, $turma_id);

        if ($stmt_insert->execute()) {
            $sucessoCount++;
        } else {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Erro no banco - " . $conn->error;
        }
        $stmt_insert->close();
    }

    fclose($handle);

    echo json_encode([
        "mensagem" => "Processamento concluído.",
        "sucesso" => $sucessoCount,
        "erros_count" => $erroCount,
        "detalhes_erro" => $mensagensErro
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro no processamento: " . $e->getMessage()]);
}

$conn->close();

