<?php
require_once __DIR__ . '/../configs/conexao.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$metodo = $_SERVER['REQUEST_METHOD'];
$json_recebido = file_get_contents("php://input");
$input = json_decode($json_recebido, true);

if (json_last_error() !== JSON_ERROR_NONE && $metodo !== 'OPTIONS' && $metodo !== 'DELETE') {
    file_put_contents(__DIR__ . "/debug_api.log", "JSON Error: " . json_last_error_msg() . " | Input: " . $json_recebido . "\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(["mensagem" => "JSON inválido: " . json_last_error_msg()]);
    exit;
}
file_put_contents(__DIR__ . "/debug_api.log", "Method: $metodo | Input: " . $json_recebido . "\n", FILE_APPEND);

$id = $input['id'] ?? null;

switch ($metodo) {
    case 'OPTIONS':
        // PREFLIGHT CORS
        http_response_code(200);
        exit;

    case 'POST':
        // CADASTRAR
        $nome = $input['nome'] ?? null;
        $matricula = $input['matricula'] ?? null;
        $email = $input['email'] ?? null;
        $turma_id = $input['turma_id'] ?? null;

        if (!$nome || !$matricula || !$turma_id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos (Nome, Matrícula, Turma) são obrigatórios. E-mail é opcional."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO aluno (aluno_nome, aluno_matricula, aluno_email, turmas_id, aluno_status) VALUES (?, ?, ?, ?, 'Ativo')");
        $stmt->bind_param("sssi", $nome, $matricula, $email, $turma_id);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Aluno cadastrado com sucesso.", "id" => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao cadastrar aluno: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PUT':
        // ATUALIZAR
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório para edição."]);
            exit;
        }

        $nome = $input['nome'] ?? null;
        $matricula = $input['matricula'] ?? null;
        $email = $input['email'] ?? null;
        $turma_id = $input['turma_id'] ?? null;

        if (!$nome || !$matricula || !$turma_id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos (Nome, Matrícula, Turma) são obrigatórios. E-mail é opcional."]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE aluno SET aluno_nome = ?, aluno_matricula = ?, aluno_email = ?, turmas_id = ? WHERE idaluno = ?");
        $stmt->bind_param("sssii", $nome, $matricula, $email, $turma_id, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Aluno atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar aluno: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        // DESATIVAR / ATIVAR (SOFT DELETE/REACTIVATE)
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório."]);
            exit;
        }

        $status = $input['status'] ?? 'Inativo'; // Default to Inativo

        $stmt = $conn->prepare("UPDATE aluno SET aluno_status = ? WHERE idaluno = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Status do aluno alterado para $status."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao alterar status: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'DELETE':
        // DELETAR (HARD DELETE)
        // Check if ID is passed in body (for some clients) or query param
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório para deleção."]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM aluno WHERE idaluno = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Aluno excluído permanentemente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao excluir aluno: " . $stmt->error]);
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
