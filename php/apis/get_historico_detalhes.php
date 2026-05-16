<?php
require_once __DIR__ . '/../configs/conexao.php';

header('Content-Type: application/json');

if (!isset($_GET['data']) || !isset($_GET['hora']) || !isset($_GET['maquina_id'])) {
    echo json_encode(['erro' => 'ParÃ¢metros inválidos']);
    exit;
}

$data = $_GET['data'];
$hora = $_GET['hora'];
$maquina_id = $_GET['maquina_id'];

// Handling optional IDs (might be zero or empty)
// In PHP, empty('0') is true, so we must check specifically for empty string or null
$aluno_id = (isset($_GET['aluno_id']) && $_GET['aluno_id'] !== '') ? $_GET['aluno_id'] : null;
$colaborador_id = (isset($_GET['colaborador_id']) && $_GET['colaborador_id'] !== '') ? $_GET['colaborador_id'] : null;

// Build query depending on presence of aluno/colaborador
$sql = "SELECT h.historico_status, r.requisito_topico, mq.requisitos_especificos 
        FROM historico h
        LEFT JOIN requisitos r ON h.requisito_id = r.idrequisitos
        LEFT JOIN maquina_requisitos mq ON h.requisito_especifico_id = mq.idmaquina_requisitos
        WHERE h.historico_data = ? AND h.historico_hora = ? AND h.maquina_id = ?";

$params = [$data, $hora, $maquina_id];
$types = "ssi";

if ($aluno_id !== null) {
    $sql .= " AND h.aluno_id = ?";
    $params[] = $aluno_id;
    $types .= "i";
} else {
    $sql .= " AND h.aluno_id IS NULL";
}

if ($colaborador_id !== null) {
    $sql .= " AND h.colaborador_id = ?";
    $params[] = $colaborador_id;
    $types .= "i";
} else {
    $sql .= " AND h.colaborador_id IS NULL";
}

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['sucesso' => false, 'erro' => 'Falha ao preparar a query: ' . $conn->error]);
    exit;
}

// Dynamically bind params using call_user_func_array for PHP < 8.1 compatibility
if ($types !== "") {
    $bind_names = array();
    $bind_names[] = $types;
    for ($i=0; $i<count($params); $i++) {
        $bind_name = 'bind' . $i;
        $$bind_name = $params[$i];
        $bind_names[] = &$$bind_name;
    }
    call_user_func_array(array($stmt, 'bind_param'), $bind_names);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $detalhes = [];
    while ($row = $result->fetch_assoc()) {
        $topico = !empty($row['requisito_topico']) ? $row['requisito_topico'] : $row['requisitos_especificos'];
        $detalhes[] = [
            'topico' => !empty($topico) ? $topico : 'Requisito Indefinido',
            'status' => $row['historico_status'] ?? 'Não checado'
        ];
    }
    echo json_encode(['sucesso' => true, 'dados' => $detalhes]);
} else {
    echo json_encode(['sucesso' => false, 'erro' => 'Falha ao executar query: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

