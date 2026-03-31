<?php
require_once __DIR__ . '/../../configs/conexao.php';

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
        $unidade_nome = trim($row[1] ?? '');

        if (empty($nome) || empty($unidade_nome))
            continue;

        // 1. Buscar ID da Unidade
        $stmt_unidade = $conn->prepare("SELECT idunidade FROM unidade WHERE unidade_nome = ? AND unidade_status = 'Ativo' LIMIT 1");
        $stmt_unidade->bind_param("s", $unidade_nome);
        $stmt_unidade->execute();
        $res_unidade = $stmt_unidade->get_result()->fetch_assoc();
        $stmt_unidade->close();

        if (!$res_unidade) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Unidade '$unidade_nome' não encontrada.";
            continue;
        }
        $unidade_id = $res_unidade['idunidade'];

        // 2. Verificar duplicata
        $stmt_check = $conn->prepare("SELECT idsetor FROM setor WHERE setor_nome = ? AND unidade_id = ? LIMIT 1");
        $stmt_check->bind_param("si", $nome, $unidade_id);
        $stmt_check->execute();
        $exists = $stmt_check->get_result()->fetch_assoc();
        $stmt_check->close();

        if ($exists) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 1) . ": Setor '$nome' nesta unidade já existe.";
            continue;
        }

        // 3. Inserir
        $stmt_insert = $conn->prepare("INSERT INTO setor (setor_nome, unidade_id, setor_status) VALUES (?, ?, 'Ativo')");
        $stmt_insert->bind_param("si", $nome, $unidade_id);

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


