<?php
require_once __DIR__ . '/../configs/conexao.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, PATCH, OPTIONS");
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
        // PREFLIGHT CORS
        http_response_code(200);
        exit;

    case 'POST':
        // CADASTRAR
        $nome = $input['nome'] ?? null;
        $cidade = $input['cidade'] ?? null;
        $estado = $input['estado'] ?? null;
        $numero = $input['numero'] ?? null;

        if (!$nome || !$cidade || !$estado) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos (Nome, Cidade, Estado) são obrigatórios."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO unidade (unidade_nome, unidade_cidade, unidade_estado, unidade_numero, unidade_status) VALUES (?, ?, ?, ?, 'Ativo')");
        $stmt->bind_param("ssss", $nome, $cidade, $estado, $numero);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Unidade criada com sucesso.", "id" => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao cadastrar: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PUT':
        // ATUALIZAR
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório para atualização."]);
            exit;
        }

        $nome = $input['nome'] ?? null;
        $cidade = $input['cidade'] ?? null;
        $estado = $input['estado'] ?? null;
        $numero = $input['numero'] ?? null;

        if (!$nome || !$cidade || !$estado) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos (Nome, Cidade, Estado) são obrigatórios."]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE unidade SET unidade_nome = ?, unidade_cidade = ?, unidade_estado = ?, unidade_numero = ? WHERE idunidade = ?");
        $stmt->bind_param("ssssi", $nome, $cidade, $estado, $numero, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Unidade atualizada com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        // ALTERAR STATUS (SOFT DELETE/REACTIVATE)
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório para alteração de status."]);
            exit;
        }

        $status = $input['status'] ?? 'Inativo';

        $stmt = $conn->prepare("UPDATE unidade SET unidade_status = ? WHERE idunidade = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Status da unidade alterado para $status."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao alterar status: " . $stmt->error]);
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
