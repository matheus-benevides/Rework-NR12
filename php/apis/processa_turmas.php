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
        $periodo = $input['periodo'] ?? null;
        $inicio = $input['inicio'] ?? null;
        $fim = $input['fim'] ?? null;
        $curso_id = $input['curso_id'] ?? null;
        $colaborador_id = $input['colaborador_id'] ?? null;

        if (!$nome || !$periodo || !$inicio || !$fim || !$curso_id || !$colaborador_id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos são obrigatórios."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO turmas (turma_nome, turma_periodo, turma_inicio, turma_fim, curso_id, colaborador_id, turmas_status) VALUES (?, ?, ?, ?, ?, ?, 'Ativo')");
        $stmt->bind_param("ssssii", $nome, $periodo, $inicio, $fim, $curso_id, $colaborador_id);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Turma criada com sucesso.", "id" => $conn->insert_id]);
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
        $periodo = $input['periodo'] ?? null;
        $inicio = $input['inicio'] ?? null;
        $fim = $input['fim'] ?? null;
        $curso_id = $input['curso_id'] ?? null;
        $colaborador_id = $input['colaborador_id'] ?? null;

        if (!$nome || !$periodo || !$inicio || !$fim || !$curso_id || !$colaborador_id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos são obrigatórios."]);
            exit;
        }

        // Correção na query UPDATE para corresponder Ã  tabela turmas
        $stmt = $conn->prepare("UPDATE turmas SET turma_nome = ?, turma_periodo = ?, turma_inicio = ?, turma_fim = ?, curso_id = ?, colaborador_id = ? WHERE idturmas = ?");
        $stmt->bind_param("ssssiii", $nome, $periodo, $inicio, $fim, $curso_id, $colaborador_id, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Turma atualizada com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar: " . $stmt->error]);
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

        $status = $input['status'] ?? 'Inativo'; // Default to Inativo if not specified

        $stmt = $conn->prepare("UPDATE turmas SET turmas_status = ? WHERE idturmas = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Status da turma alterado para $status."]);
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
