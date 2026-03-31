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
$aluno_id = !empty($_GET['aluno_id']) ? $_GET['aluno_id'] : null;
$colaborador_id = !empty($_GET['colaborador_id']) ? $_GET['colaborador_id'] : null;

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

// Dynamically bind params
if ($types !== "") {
    $stmt->bind_param($types, ...$params);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $detalhes = [];
    while ($row = $result->fetch_assoc()) {
        $topico = $row['requisito_topico'] ? $row['requisito_topico'] : $row['requisitos_especificos'];
        $detalhes[] = [
            'topico' => $topico ? $topico : 'Requisito Indefinido',
            'status' => $row['historico_status']
        ];
    }
    echo json_encode(['sucesso' => true, 'dados' => $detalhes]);
} else {
    echo json_encode(['erro' => 'Falha ao buscar detalhes']);
}

$stmt->close();
$conn->close();
?>

