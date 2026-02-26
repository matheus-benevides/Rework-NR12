<?php
require_once '../configs/conexao.php';
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

$descricao = $input['descricao'] ?? '';
$colaborador_id = $input['colaborador_id'] ?? null;
$requisitos_ids = $input['requisitos_ids'] ?? [];
$requisitos_especifico_ids = $input['requisitos_especifico_ids'] ?? [];

$aluno_id = $input['aluno_id'] ?? $_SESSION['idaluno'] ?? null;
$maquina_id = $input['maquina_id'] ?? $_SESSION['idmaquina'] ?? null;

if (!$aluno_id) {
    if (isset($_SESSION['matricula'])) {
        $sqlA = "SELECT idaluno FROM aluno WHERE aluno_matricula = ?";
        $stmtA = $conn->prepare($sqlA);
        $stmtA->bind_param("s", $_SESSION['matricula']);
        $stmtA->execute();
        $aluno_id = $stmtA->get_result()->fetch_assoc()['idaluno'] ?? null;
    }
}

if (!$descricao || !$colaborador_id || !$maquina_id || !$aluno_id) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Dados insuficientes para o registro."]);
    exit;
}

$reqs_str = !empty($requisitos_ids) ? implode(',', $requisitos_ids) : null;
$reqs_esp_str = !empty($requisitos_especifico_ids) ? implode(',', $requisitos_especifico_ids) : null;

$sql = "INSERT INTO defeitos (descricao, colaborador_id, aluno_id, maquina_id, requisitos_ids, requisitos_especifico_ids) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiiss", $descricao, $colaborador_id, $aluno_id, $maquina_id, $reqs_str, $reqs_esp_str);

if ($stmt->execute()) {
    echo json_encode(["mensagem" => "Defeito registrado com sucesso!"]);
} else {
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro ao registrar: " . $stmt->error]);
}

$conn->close();
?>