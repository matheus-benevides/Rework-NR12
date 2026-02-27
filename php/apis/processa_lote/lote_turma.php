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
        $periodo = trim($row[1] ?? '');
        $inicio = trim($row[2] ?? '');
        $fim = trim($row[3] ?? '');
        $curso_nome = trim($row[4] ?? '');
        $colaborador_nome = trim($row[5] ?? '');

        if (empty($nome) || empty($curso_nome) || empty($colaborador_nome)) {
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
            $mensagensErro[] = "Linha " . ($index + 2) . ": Curso '$curso_nome' não encontrado.";
            continue;
        }
        $curso_id = $res_curso['idcurso'];

        // 2. Buscar ID do colaborador
        $stmt_colab = $conn->prepare("SELECT idcolaborador FROM colaborador WHERE colaborador_nome = ? AND colaborador_status = 'Ativo' LIMIT 1");
        $stmt_colab->bind_param("s", $colaborador_nome);
        $stmt_colab->execute();
        $res_colab = $stmt_colab->get_result()->fetch_assoc();
        $stmt_colab->close();

        if (!$res_colab) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": Colaborador '$colaborador_nome' não encontrado.";
            continue;
        }
        $colaborador_id = $res_colab['idcolaborador'];

        // 3. Verificar duplicata
        $stmt_check = $conn->prepare("SELECT idturmas FROM turmas WHERE turma_nome = ? AND curso_id = ? LIMIT 1");
        $stmt_check->bind_param("si", $nome, $curso_id);
        $stmt_check->execute();
        $exists = $stmt_check->get_result()->fetch_assoc();
        $stmt_check->close();

        if ($exists) {
            $erroCount++;
            $mensagensErro[] = "Linha " . ($index + 2) . ": Turma '$nome' para este curso já existe.";
            continue;
        }

        // 4. Inserir
        $stmt_insert = $conn->prepare("INSERT INTO turmas (turma_nome, turma_periodo, turma_inicio, turma_fim, curso_id, colaborador_id, turmas_status) VALUES (?, ?, ?, ?, ?, ?, 'Ativo')");
        $stmt_insert->bind_param("ssssii", $nome, $periodo, $inicio, $fim, $curso_id, $colaborador_id);

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
