<?php
require_once '../../configs/conexao.php';

if (file_exists('../../../vendor/autoload.php')) {
    require_once '../../../vendor/autoload.php';
}

use PhpOffice\PhpSpreadsheet\IOFactory;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

$arquivo = $_FILES['arquivo']['tmp_name'];

try {
    $spreadsheet = IOFactory::load($arquivo);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Remove o cabeçalho
    array_shift($rows);

    $sucessoCount = 0;
    $erroCount = 0;
    $mensagensErro = [];

    foreach ($rows as $index => $row) {
        $nome = trim($row[0] ?? '');
        $unidade_nome = trim($row[1] ?? '');

        if (empty($nome) || empty($unidade_nome)) {
            continue;
        }

        // 1. Buscar ID da Unidade
        $stmt_unidade = $conn->prepare("SELECT idunidade FROM unidade WHERE unidade_nome = ? AND unidade_status = 'Ativo' LIMIT 1");
        $stmt_unidade->bind_param("s", $unidade_nome);
        $stmt_unidade->execute();
        $res_unidade = $stmt_unidade->get_result()->fetch_assoc();
        $stmt_unidade->close();

        if (!$res_unidade) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": Unidade '$unidade_nome' não encontrada.";
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
            $mensagensErro[] = "Linha " . ($index + 2) . ": Setor '$nome' nesta unidade já existe.";
            continue;
        }

        // 3. Inserir
        $stmt_insert = $conn->prepare("INSERT INTO setor (setor_nome, unidade_id, setor_status) VALUES (?, ?, 'Ativo')");
        $stmt_insert->bind_param("si", $nome, $unidade_id);

        if ($stmt_insert->execute()) {
            $sucessoCount++;
        } else {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": Erro ao inserir - " . $conn->error;
        }
        $stmt_insert->close();
    }

    echo json_encode([
        "mensagem" => "Processamento concluído.",
        "sucesso" => $sucessoCount,
        "erros_count" => $erroCount,
        "detalhes_erro" => $mensagensErro
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro ao processar arquivo: " . $e->getMessage()]);
}

$conn->close();
