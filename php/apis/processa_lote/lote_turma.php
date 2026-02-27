<?php
require_once '../../configs/conexao.php';

// Definir headers para JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// --- TRATAMENTO DE ERROS GLOBAL ---
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno))
        return false;
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro interno no servidor.", "detalhes" => $errstr]);
    exit;
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== NULL && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        echo json_encode(["mensagem" => "Erro fatal no processamento.", "detalhes" => $error['message']]);
    }
});

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
    echo json_encode(["mensagem" => "Formato inválido. Atualmente apenas .csv é suportado."]);
    exit;
}

try {
    $handle = fopen($arquivoPath, "r");
    if (!$handle)
        throw new Exception("Não foi possível abrir o arquivo.");

    $primeiraLinha = fgets($handle);
    $delimitador = (strpos($primeiraLinha, ';') !== false) ? ';' : ',';
    rewind($handle);

    // Pular cabeçalho
    fgetcsv($handle, 1000, $delimitador);

    $sucessoCount = 0;
    $erroCount = 0;
    $mensagensErro = [];
    $index = 0;

    while (($row = fgetcsv($handle, 1000, $delimitador)) !== FALSE) {
        $index++;
        $nome = trim($row[0] ?? '');
        $curso_nome = trim($row[1] ?? '');
        $colaborador_nome = trim($row[2] ?? '');

        if (empty($nome) || empty($curso_nome) || empty($colaborador_nome)) {
            // Se a linha estiver vazia ou com dados insuficientes, pula para a próxima
            // Mas se for uma linha com dados parciais, pode ser um erro de formatação
            // ou dados ausentes que o usuário precisa saber.
            // Por enquanto, apenas ignora linhas vazias.
            continue;
        }

        // 1. Buscar ID do curso
        $stmt_curso = $conn->prepare("SELECT idcurso FROM curso WHERE curso_nome = ? AND curso_status = 'Ativo' LIMIT 1");
        $stmt_curso->bind_param("s", $curso_nome);
        $stmt_curso->execute();
        $res_curso = $stmt_curso->get_result()->fetch_assoc();
        $stmt_curso->close();

        if (!$res_curso) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Curso '$curso_nome' não encontrado.";
            continue;
        }
        $curso_id = $res_curso['idcurso'];

        // 2. Buscar ID do Colaborador (Instrutor/Responsável)
        $stmt_colab = $conn->prepare("SELECT idcolaboradores FROM colaboradores WHERE colaboradores_nome = ? AND colaboradores_status = 'Ativo' LIMIT 1");
        $stmt_colab->bind_param("s", $colaborador_nome);
        $stmt_colab->execute();
        $res_colab = $stmt_colab->get_result()->fetch_assoc();
        $stmt_colab->close();

        if (!$res_colab) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Colaborador '$colaborador_nome' não encontrado.";
            continue;
        }
        $colaborador_id = $res_colab['idcolaboradores'];

        // 3. Verificar duplicata
        $stmt_check = $conn->prepare("SELECT idturmas FROM turmas WHERE turma_nome = ? AND curso_id = ? LIMIT 1");
        $stmt_check->bind_param("si", $nome, $curso_id);
        $stmt_check->execute();
        $exists = $stmt_check->get_result()->fetch_assoc();
        $stmt_check->close();

        if ($exists) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Turma '$nome' para este curso já existe.";
            continue;
        }

        // 4. Inserir
        $stmt_insert = $conn->prepare("INSERT INTO turmas (turma_nome, curso_id, colaborador_id, turmas_status) VALUES (?, ?, ?, 'Ativo')");
        $stmt_insert->bind_param("sii", $nome, $curso_id, $colaborador_id);

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
    echo json_encode(["mensagem" => "Erro: " . $e->getMessage()]);
}

$conn->close();
