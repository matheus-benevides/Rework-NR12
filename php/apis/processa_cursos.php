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

        if (!$nome) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Nome do curso é obrigatório."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO curso (curso_nome, curso_status) VALUES (?, 'Ativo')");
        $stmt->bind_param("s", $nome);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Curso criado com sucesso.", "id" => $conn->insert_id]);
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
            echo json_encode(["mensagem" => "ID é obrigatório."]);
            exit;
        }

        $nome = $input['nome'] ?? null;

        if (!$nome) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Nome do curso é obrigatório."]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE curso SET curso_nome = ? WHERE idcurso = ?");
        $stmt->bind_param("si", $nome, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Curso atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        // DESATIVAR (SOFT DELETE)
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório."]);
            exit;
        }

        // Verifica se foi enviado um status específico, senão assume 'Inativo'
        $status = $input['status'] ?? 'Inativo';

        $stmt = $conn->prepare("UPDATE curso SET curso_status = ? WHERE idcurso = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Status do curso alterado para $status."]);
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
