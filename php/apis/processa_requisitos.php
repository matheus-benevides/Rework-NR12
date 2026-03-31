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

if (json_last_error() !== JSON_ERROR_NONE && !in_array($metodo, ['GET', 'OPTIONS'])) {
    http_response_code(400);
    echo json_encode(["mensagem" => "JSON inválido: " . json_last_error_msg()]);
    exit;
}

switch ($metodo) {
    case 'OPTIONS':
        // PREFLIGHT CORS
        http_response_code(200);
        exit;

    case 'GET':
        // BUSCAR REQUISITO(S)
        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $conn->prepare("SELECT * FROM requisitos WHERE idrequisitos = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                echo json_encode($resultado->fetch_assoc());
            } else {
                http_response_code(404);
                echo json_encode(["mensagem" => "Requisito não encontrado."]);
            }
            $stmt->close();
        } else {
            $resultado = $conn->query("SELECT * FROM requisitos ORDER BY requisito_topico ASC");
            $requisitos = [];
            while ($linha = $resultado->fetch_assoc()) {
                $requisitos[] = $linha;
            }
            echo json_encode($requisitos);
        }
        break;

    case 'POST':
        // CADASTRAR REQUISITO
        $topico = $input['topico'] ?? null;
        $tipo = $input['tipo'] ?? null;

        if (!$topico || !$tipo) {
            http_response_code(400);
            echo json_encode(["mensagem" => "Tópico e Tipo são obrigatórios."]);
            exit;
        }

        $status = 'Ativo';

        $stmt = $conn->prepare("INSERT INTO requisitos (requisito_topico, tipo_req, requisitos_status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $topico, $tipo, $status);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Requisito cadastrado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao cadastrar requisito: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PUT':
        // EDITAR REQUISITO
        $id = $input['id'] ?? null;
        $topico = $input['topico'] ?? null;
        $tipo = $input['tipo'] ?? null;

        if (!$id || !$topico || !$tipo) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID, Tópico e Tipo são obrigatórios para edição."]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE requisitos SET requisito_topico = ?, tipo_req = ? WHERE idrequisitos = ?");
        $stmt->bind_param("ssi", $topico, $tipo, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                http_response_code(200);
                echo json_encode(["mensagem" => "Requisito atualizado com sucesso."]);
            } else {
                http_response_code(404);
                echo json_encode(["mensagem" => "Requisito não encontrado ou nenhuma alteração realizada."]);
            }
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar requisito: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        // ATIVAR/DESATIVAR REQUISITO
        $id = $input['id'] ?? null;
        $status = $input['status'] ?? null;

        if (!$id || !$status || !in_array($status, ['Ativo', 'Inativo'])) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID e Status válido (Ativo/Inativo) são obrigatórios."]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE requisitos SET requisitos_status = ? WHERE idrequisitos = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                http_response_code(200);
                $acao = $status === 'Ativo' ? "ativado" : "desativado";
                echo json_encode(["mensagem" => "Requisito $acao com sucesso."]);
            } else {
                http_response_code(404);
                echo json_encode(["mensagem" => "Requisito não encontrado ou status já definido."]);
            }
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar status do requisito: " . $stmt->error]);
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
