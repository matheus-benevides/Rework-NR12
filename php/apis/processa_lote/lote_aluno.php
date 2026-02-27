<?php
require_once '../../configs/conexao.php';

// Importante: A biblioteca PhpSpreadsheet deve estar instalada via composer.
// Se não estiver, haverá um erro de classe não encontrada.
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

    // Mapeamento: 0 => Matricula, 1 => Nome, 2 => Turma, 3 => Email
    foreach ($rows as $index => $row) {
        $matricula = trim($row[0] ?? '');
        $nome = trim($row[1] ?? '');
        $turma_nome = trim($row[2] ?? '');
        $email = trim($row[3] ?? '');

        if (empty($matricula) || empty($nome) || empty($turma_nome)) {
            $erroCount++;
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
            $mensagensErro[] = "Linha " . ($index + 2) . ": Turma '$turma_nome' não encontrada ou inativa.";
            continue;
        }

        $turma_id = $turma['idturmas'];

        // 2. Verificar se matrícula já existe
        $stmt_check = $conn->prepare("SELECT idaluno FROM aluno WHERE aluno_matricula = ? LIMIT 1");
        $stmt_check->bind_param("s", $matricula);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        $exists = $res_check->fetch_assoc();
        $stmt_check->close();

        if ($exists) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": Matrícula '$matricula' já cadastrada.";
            continue;
        }

        // 3. Inserir aluno
        $stmt_insert = $conn->prepare("INSERT INTO aluno (aluno_nome, aluno_matricula, aluno_email, turmas_id, aluno_status) VALUES (?, ?, ?, ?, 'Ativo')");
        $stmt_insert->bind_param("sssi", $nome, $matricula, $email, $turma_id);

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
