<?php
require_once '../configs/conexao.php';

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
        http_response_code(200);
        exit;

    case 'POST':
        // CADASTRAR
        $nome = $input['nome'] ?? null;
        $email = $input['email'] ?? null;
        $senha = $input['senha'] ?? 'senaisp'; // Default se não enviado
        $nif = $input['nif'] ?? null;
        $tipo = $input['tipo'] ?? null;
        $setor = $input['setor'] ?? null;

        if (!$nome || !$email || !$senha || !$nif || !$tipo || !$setor) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos são obrigatórios."]);
            exit;
        }

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO colaborador (colaborador_nome, colaborador_email, colaborador_senha, colaborador_nif, colaborador_permissao, setor_id, colaborador_status) VALUES (?, ?, ?, ?, ?, ?, 'Ativo')");
        $stmt->bind_param("sssssi", $nome, $email, $senha_hash, $nif, $tipo, $setor);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Colaborador cadastrado com sucesso.", "id" => $conn->insert_id]);
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
        $email = $input['email'] ?? null;
        $senha = $input['senha'] ?? null;
        $nif = $input['nif'] ?? null;
        $tipo = $input['tipo'] ?? null;
        $setor = $input['setor'] ?? null;

        if (!$nome || !$email || !$nif || !$tipo || !$setor) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Todos os campos não-senha são obrigatórios."]);
            exit;
        }

        if (!empty($senha)) {
            // Atualiza com senha nova
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE colaborador SET colaborador_nome = ?, colaborador_email = ?, colaborador_senha = ?, colaborador_nif = ?, colaborador_permissao = ?, setor_id = ? WHERE idcolaborador = ?");
            $stmt->bind_param("sssssii", $nome, $email, $senha_hash, $nif, $tipo, $setor, $id);
        } else {
            // Atualiza sem mexer na senha
            $stmt = $conn->prepare("UPDATE colaborador SET colaborador_nome = ?, colaborador_email = ?, colaborador_nif = ?, colaborador_permissao = ?, setor_id = ? WHERE idcolaborador = ?");
            $stmt->bind_param("ssssii", $nome, $email, $nif, $tipo, $setor, $id);
        }

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Colaborador atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        // ALTERAR STATUS
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório."]);
            exit;
        }

        $status = $input['status'] ?? 'Inativo';

        $stmt = $conn->prepare("UPDATE colaborador SET colaborador_status = ? WHERE idcolaborador = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Status do colaborador alterado para $status."]);
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