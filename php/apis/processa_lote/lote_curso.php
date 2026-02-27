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
$extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

if (!in_array(strtolower($extensao), ['csv', 'xlsx', 'xls'])) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Formato de arquivo inválido. Use .csv, .xlsx ou .xls."]);
    exit;
}

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

        if (empty($nome)) {
            continue; // Pula linhas vazias
        }

        // Verificar se curso já existe
        $stmt_check = $conn->prepare("SELECT idcurso FROM curso WHERE curso_nome = ? LIMIT 1");
        $stmt_check->bind_param("s", $nome);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        $exists = $res_check->fetch_assoc();
        $stmt_check->close();

        if ($exists) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": Curso '$nome' já existe.";
            continue;
        }

        // Inserir curso
        $stmt_insert = $conn->prepare("INSERT INTO curso (curso_nome, curso_status) VALUES (?, 'Ativo')");
        $stmt_insert->bind_param("s", $nome);

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
