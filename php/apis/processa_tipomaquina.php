<?php
require_once __DIR__ . '/../configs/conexao.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$metodo = $_SERVER['REQUEST_METHOD'];
$json_recebido = file_get_contents("php://input");
$input = json_decode($json_recebido, true);

if (json_last_error() !== JSON_ERROR_NONE && !in_array($metodo, ['GET', 'OPTIONS', 'DELETE'])) {
    http_response_code(400);
    echo json_encode(["mensagem" => "JSON inválido: " . json_last_error_msg()]);
    exit;
}

switch ($metodo) {
    case 'OPTIONS':
        http_response_code(200);
        exit;

    case 'GET':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $conn->prepare("SELECT * FROM tipomaquina WHERE idtipomaquina = ?");
            if (!$stmt) {
                http_response_code(500);
                echo json_encode(["mensagem" => "Erro na preparação: " . $conn->error]);
                exit;
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                echo json_encode($resultado->fetch_assoc());
            } else {
                http_response_code(404);
                echo json_encode(["mensagem" => "Tipo de máquina não encontrado."]);
            }
            $stmt->close();
        } else {
            $resultado = $conn->query("SELECT * FROM tipomaquina ORDER BY tipomaquina_nome ASC");
            $tipos = [];
            while ($linha = $resultado->fetch_assoc()) {
                $tipos[] = $linha;
            }
            echo json_encode($tipos);
        }
        break;

    case 'POST':
        $nome = $input['tipomaquina_nome'] ?? null;
        if (!$nome) {
            http_response_code(400);
            echo json_encode(["mensagem" => "O nome do tipo de máquina é obrigatório."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO tipomaquina (tipomaquina_nome, tipomaquina_status) VALUES (?, 'Ativo')");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao preparar banco: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("s", $nome);
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Tipo de máquina cadastrado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao cadastrar: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PUT':
        $id = $input['id'] ?? null;
        $nome = $input['tipomaquina_nome'] ?? null;
        $status = $input['status'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório para edição."]);
            exit;
        }

        if ($nome && $status) {
            $stmt = $conn->prepare("UPDATE tipomaquina SET tipomaquina_nome = ?, tipomaquina_status = ? WHERE idtipomaquina = ?");
            $stmt->bind_param("ssi", $nome, $status, $id);
        } elseif ($nome) {
            $stmt = $conn->prepare("UPDATE tipomaquina SET tipomaquina_nome = ? WHERE idtipomaquina = ?");
            $stmt->bind_param("si", $nome, $id);
        } elseif ($status) {
            $stmt = $conn->prepare("UPDATE tipomaquina SET tipomaquina_status = ? WHERE idtipomaquina = ?");
            $stmt->bind_param("si", $status, $id);
        } else {
            http_response_code(400);
            echo json_encode(["mensagem" => "Nenhum dado para atualizar."]);
            exit;
        }

        if ($stmt->execute()) {
            echo json_encode(["mensagem" => "Tipo de máquina atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? $input['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório para exclusão."]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM tipomaquina WHERE idtipomaquina = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["mensagem" => "Tipo de máquina excluído com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao excluir: " . $stmt->error]);
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
