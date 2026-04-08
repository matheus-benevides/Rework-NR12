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

// $input = json_decode($json_recebido, true);

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
            $stmt = $conn_manutencao->prepare("SELECT * FROM maquinas WHERE id = ?");
            if (!$stmt) {
                echo json_encode(["mensagem" => "Erro na preparação: " . $conn_manutencao->error]);
                exit;
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                echo json_encode($resultado->fetch_assoc());
            } else {
                http_response_code(404);
                echo json_encode(["mensagem" => "Máquina não encontrada."]);
            }
            $stmt->close();
        } else {
            $resultado = $conn_manutencao->query("SELECT * FROM maquinas ORDER BY denominacao ASC");
            $maquinas = [];
            while ($linha = $resultado->fetch_assoc()) {
                $maquinas[] = $linha;
            }
            echo json_encode($maquinas);
        }
        break;

    case 'POST':
        $denominacao = $input['denominacao'] ?? null;
        $marca = $input['marca'] ?? null;
        $modelo = $input['modelo'] ?? null;
        $numero_identificacao = $input['numero_identificacao'] ?? null;
        $numero_serie = $input['numero_serie'] ?? null;
        $ano_fabricacao = !empty($input['ano_fabricacao']) ? intval($input['ano_fabricacao']) : null;
        $setor = $input['setor'] ?? null;

        if (!$denominacao) {
            http_response_code(400);
            echo json_encode(["mensagem" => "A denominação é obrigatória."]);
            exit;
        }

        $sql = "INSERT INTO maquinas (denominacao, marca, modelo, numero_identificacao, numero_serie, ano_fabricacao, setor) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn_manutencao->prepare($sql);
        
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao preparar banco: " . $conn_manutencao->error]);
            exit;
        }

        $stmt->bind_param("sssssis", $denominacao, $marca, $modelo, $numero_identificacao, $numero_serie, $ano_fabricacao, $setor);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Máquina cadastrada com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao cadastrar máquina: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'PUT':
        $id = $input['id'] ?? null;
        $denominacao = $input['denominacao'] ?? null;
        $marca = $input['marca'] ?? null;
        $modelo = $input['modelo'] ?? null;
        $numero_identificacao = $input['numero_identificacao'] ?? null;
        $numero_serie = $input['numero_serie'] ?? null;
        $ano_fabricacao = !empty($input['ano_fabricacao']) ? intval($input['ano_fabricacao']) : null;
        $setor = $input['setor'] ?? null;

        if (!$id || !$denominacao) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID e Denominação são obrigatórios."]);
            exit;
        }

        $sql = "UPDATE maquinas SET denominacao = ?, marca = ?, modelo = ?, numero_identificacao = ?, numero_serie = ?, ano_fabricacao = ?, setor = ? WHERE id = ?";
        $stmt = $conn_manutencao->prepare($sql);
        
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao preparar banco: " . $conn_manutencao->error]);
            exit;
        }

        $stmt->bind_param("sssssisi", $denominacao, $marca, $modelo, $numero_identificacao, $numero_serie, $ano_fabricacao, $setor, $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Máquina atualizada com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar máquina: " . $stmt->error]);
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

        $stmt = $conn_manutencao->prepare("DELETE FROM maquinas WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Máquina excluída com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao excluir máquina: " . $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        http_response_code(405);
        echo json_encode(["mensagem" => "Método não permitido."]);
        break;
}

$conn_manutencao->close();
?>
