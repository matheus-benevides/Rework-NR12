<?php
require_once '../configs/conexao.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PATCH, OPTIONS");
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

$id = $input['id'] ?? null;

switch ($metodo) {
    case 'OPTIONS':
        http_response_code(200);
        exit;

    case 'POST':
        // SOLICITAR SUPORTE
        $id_colaborador = $input['id_colaborador'] ?? null;
        $onde = $input['onde'] ?? null;
        $tipo = $input['tipo'] ?? null;
        $urgencia = $input['urgencia'] ?? null;
        $desc = $input['desc_erro'] ?? null;

        if (!$id_colaborador || !$onde || !$tipo || !$urgencia || !$desc) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos são obrigatórios."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO solicitacao_erro (id_colaborador, desc_erro, onde, tipo, urgencia, situacao, data_solicitacao) VALUES (?, ?, ?, ?, ?, 'Pendente', NOW())");
        $stmt->bind_param("issss", $id_colaborador, $desc, $onde, $tipo, $urgencia);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Solicitação enviada com sucesso.", "id" => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao enviar solicitação: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        // RESOLVER SUPORTE
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório."]);
            exit;
        }

        $situacao = 'Resolvido';

        $stmt = $conn->prepare("UPDATE solicitacao_erro SET situacao = ?, data_solucao = NOW() WHERE idsolicitacao_erro = ?");
        $stmt->bind_param("si", $situacao, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Solicitação marcada como resolvida."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar solicitação: " . $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        http_response_code(405);
        echo json_encode(["mensagem" => "Método não permitido."]);
        break;
}

$conn->close();
?>