<?php
require_once __DIR__ . '/../configs/conexao.php';
// Nota: validar_acesso.php geralmente depende de sessão. APIs do projeto parecem ser independentes ou usar token.
// Vou seguir o padrão de conexao.php e assumir que os dados necessários vêm no JSON.
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$metodo = $_SERVER['REQUEST_METHOD'];
$json_recebido = file_get_contents("php://input");
$input = json_decode($json_recebido, true);

if ($metodo === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($metodo !== 'POST') {
    http_response_code(405);
    echo json_encode(["mensagem" => "Método não permitido."]);
    exit;
}

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["mensagem" => "JSON inválido."]);
    exit;
}

$colaborador_id = $input['colaborador_id'] ?? null;
$requisitos_ids = $input['requisitos_ids'] ?? [];
$requisitos_especifico_ids = $input['requisitos_especifico_ids'] ?? [];
$tipo_checklist = $input['tipo_checklist'] ?? 'Seguranca';

if (!$colaborador_id || (empty($requisitos_ids) && empty($requisitos_especifico_ids))) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Dados insuficientes."]);
    exit;
}

// Busca aluno_id e maquina_id da sessão ou do input
$aluno_id = $input['aluno_id'] ?? $_SESSION['idaluno'] ?? null;
$maquina_id = $input['maquina_id'] ?? $_SESSION['idmaquina'] ?? null;

if (!$aluno_id || !$maquina_id) {
    // Tenta resolver aluno_id se tiver matrícula na sessão
    if (isset($_SESSION['matricula'])) {
        $sqlA = "SELECT idaluno FROM aluno WHERE aluno_matricula = ?";
        $stmtA = $conn->prepare($sqlA);
        $stmtA->bind_param("s", $_SESSION['matricula']);
        $stmtA->execute();
        $aluno_id = $stmtA->get_result()->fetch_assoc()['idaluno'] ?? null;
    }
}

if (!$aluno_id || !$maquina_id) {
    http_response_code(401);
    echo json_encode(["mensagem" => "Usuário ou máquina não identificados."]);
    exit;
}

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

try {
    $conn->begin_transaction();

    // Insere requisitos padrão
    if (!empty($requisitos_ids)) {
        $sql = "INSERT INTO historico (maquina_id, aluno_id, colaborador_id, requisito_id, historico_data, historico_hora, historico_status)
                VALUES (?, ?, ?, ?, ?, ?, 'Checado')";
        $stmt = $conn->prepare($sql);
        foreach ($requisitos_ids as $req_id) {
            $stmt->bind_param("iiiiss", $maquina_id, $aluno_id, $colaborador_id, $req_id, $data_atual, $hora_atual);
            if (!$stmt->execute())
                throw new Exception($stmt->error);
        }
    }

    // Insere requisitos específicos
    if (!empty($requisitos_especifico_ids)) {
        $sqlEsp = "INSERT INTO historico (maquina_id, aluno_id, colaborador_id, requisito_especifico_id, historico_data, historico_hora, historico_status)
                   VALUES (?, ?, ?, ?, ?, ?, 'Checado')";
        $stmtEsp = $conn->prepare($sqlEsp);
        foreach ($requisitos_especifico_ids as $req_esp_id) {
            $stmtEsp->bind_param("iiiiss", $maquina_id, $aluno_id, $colaborador_id, $req_esp_id, $data_atual, $hora_atual);
            if (!$stmtEsp->execute())
                throw new Exception($stmtEsp->error);
        }
    }

    $conn->commit();
    echo json_encode(["mensagem" => "Checklist enviado com sucesso!"]);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro ao processar: " . $e->getMessage()]);
}

$conn->close();
?>
