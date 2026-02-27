<?php
require_once '../configs/conexao.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$metodo = $_SERVER['REQUEST_METHOD'];
$json_recebido = file_get_contents("php://input");
$input = json_decode($json_recebido, true);

if (json_last_error() !== JSON_ERROR_NONE && $metodo !== 'OPTIONS') {
    http_response_code(400);
    echo json_encode(["mensagem" => "JSON inválido: " . json_last_error_msg()]);
    exit;
}

switch ($metodo) {
    case 'OPTIONS':
        // PREFLIGHT CORS
        http_response_code(200);
        exit;

    case 'POST':
        // CADASTRAR RELACIONAMENTO
        $tipomaquina_id = $input['tipomaquina_id'] ?? null;
        $requisitos_ids = $input['requisitos_ids'] ?? [];

        if (!$tipomaquina_id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID do tipo de máquina é obrigatório."]);
            exit;
        }

        try {
            $conn->begin_transaction();

            // 1. Remove relacionamentos existentes para esta máquina
            $stmt_del = $conn->prepare("DELETE FROM tipomaquina_requisito WHERE tipomaquina_id = ?");
            $stmt_del->bind_param("i", $tipomaquina_id);
            $stmt_del->execute();
            $stmt_del->close();

            // 2. Insere os novos relacionamentos, se houver
            if (!empty($requisitos_ids)) {
                $stmt_ins = $conn->prepare("INSERT INTO tipomaquina_requisito (tipomaquina_id, requisitos_id) VALUES (?, ?)");
                foreach ($requisitos_ids as $req_id) {
                    $stmt_ins->bind_param("ii", $tipomaquina_id, $req_id);
                    $stmt_ins->execute();
                }
                $stmt_ins->close();
            }

            $conn->commit();
            
            http_response_code(200);
            echo json_encode(["mensagem" => "Requisitos associados com sucesso."]);
            
        } catch (Exception $e) {
            $conn->rollback();
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao associar requisitos: " . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["mensagem" => "Método não permitido."]);
        break;
}

$conn->close();
?>
