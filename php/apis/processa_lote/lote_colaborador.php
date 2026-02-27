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
    $senha_padrao = password_hash('senaisp', PASSWORD_DEFAULT);

    foreach ($rows as $index => $row) {
        $nome = trim($row[0] ?? '');
        $email = trim($row[1] ?? '');
        $nif = trim($row[2] ?? '');
        $permissao = trim($row[3] ?? '');
        $setor_nome = trim($row[4] ?? '');

        if (empty($nome) || empty($email) || empty($nif) || empty($setor_nome)) {
            continue;
        }

        // 1. Buscar ID do Setor
        $stmt_setor = $conn->prepare("SELECT idsetor FROM setor WHERE setor_nome = ? AND setor_status = 'Ativo' LIMIT 1");
        $stmt_setor->bind_param("s", $setor_nome);
        $stmt_setor->execute();
        $res_setor = $stmt_setor->get_result()->fetch_assoc();
        $stmt_setor->close();

        if (!$res_setor) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": Setor '$setor_nome' não encontrado.";
            continue;
        }
        $setor_id = $res_setor['idsetor'];

        // 2. Verificar duplicata (por email ou NIF)
        $stmt_check = $conn->prepare("SELECT idcolaborador FROM colaborador WHERE colaborador_email = ? OR colaborador_nif = ? LIMIT 1");
        $stmt_check->bind_param("ss", $email, $nif);
        $stmt_check->execute();
        $exists = $stmt_check->get_result()->fetch_assoc();
        $stmt_check->close();

        if ($exists) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": E-mail ou NIF já cadastrado.";
            continue;
        }

        // 3. Inserir
        $stmt_insert = $conn->prepare("INSERT INTO colaborador (colaborador_nome, colaborador_email, senha, colaborador_nif, colaborador_permissao, setor_id, colaborador_status, senha_padrao) VALUES (?, ?, ?, ?, ?, ?, 'Ativo', 1)");
        $stmt_insert->bind_param("sssssi", $nome, $email, $senha_padrao, $nif, $permissao, $setor_id);

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
