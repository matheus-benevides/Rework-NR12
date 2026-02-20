<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../configs/conexao.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'OPTIONS':
        http_response_code(200);
        exit;

    case 'POST':
        // CADASTRAR
        $nome = $input['nome'] ?? null;
        $unidade_id = $input['unidade_id'] ?? null;

        if (!$nome || !$unidade_id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos (Nome, Unidade) são obrigatórios."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO setor (setor_nome, unidade_id, setor_status) VALUES (?, ?, 'Ativo')");
        $stmt->bind_param("si", $nome, $unidade_id);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Setor cadastrado com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao cadastrar setor: " . $conn->error]);
        }
        break;

    case 'PUT':
        // EDITAR
        $id = $input['id'] ?? null;
        $nome = $input['nome'] ?? null;
        $unidade_id = $input['unidade_id'] ?? null;

        if (!$id || !$nome || !$unidade_id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Dados incompletos para edição."]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE setor SET setor_nome = ?, unidade_id = ? WHERE idsetor = ?");
        $stmt->bind_param("sii", $nome, $unidade_id, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Setor atualizado com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar setor: " . $conn->error]);
        }
        break;

    case 'PATCH':
        // ALTERAR STATUS (ATIVAR/DESATIVAR)
        $id = $input['id'] ?? null;
        $status = $input['status'] ?? null;

        if (!$id || !$status) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID e Status são obrigatórios."]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE setor SET setor_status = ? WHERE idsetor = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Status do setor atualizado com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar status: " . $conn->error]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["mensagem" => "Método não permitido."]);
        break;
}
