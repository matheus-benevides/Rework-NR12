<?php
require_once __DIR__ . '/../configs/conexao.php';
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$metodo = $_SERVER['REQUEST_METHOD'];
$json_recebido = file_get_contents("php://input");
$input = json_decode($json_recebido, true);

if ($metodo === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($metodo !== 'POST') {
    http_response_code(405);
    echo json_encode(["mensagem" => "Método não permitido."]);
    exit;
}

$descricao = $input['descricao'] ?? '';
$colaborador_id = $input['colaborador_id'] ?? null;
$requisitos_ids = $input['requisitos_ids'] ?? [];
$requisitos_especifico_ids = $input['requisitos_especifico_ids'] ?? [];

$aluno_id = $input['aluno_id'] ?? $_SESSION['idaluno'] ?? null;
$maquina_id = $input['maquina_id'] ?? $_SESSION['idmaquina'] ?? null;

if (!$aluno_id) {
    if (isset($_SESSION['matricula'])) {
        $sqlA = "SELECT idaluno FROM aluno WHERE aluno_matricula = ?";
        $stmtA = $conn->prepare($sqlA);
        $stmtA->bind_param("s", $_SESSION['matricula']);
        $stmtA->execute();
        $aluno_id = $stmtA->get_result()->fetch_assoc()['idaluno'] ?? null;
    }
}

if (!$descricao || !$colaborador_id || !$maquina_id || !$aluno_id) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Dados insuficientes para o registro."]);
    exit;
}

$reqs_str = !empty($requisitos_ids) ? implode(',', $requisitos_ids) : null;
$reqs_esp_str = !empty($requisitos_especifico_ids) ? implode(',', $requisitos_especifico_ids) : null;

$sql = "INSERT INTO defeitos (descricao, colaborador_id, aluno_id, maquina_id, requisitos_ids, requisitos_especifico_ids) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiiss", $descricao, $colaborador_id, $aluno_id, $maquina_id, $reqs_str, $reqs_esp_str);

if ($stmt->execute()) {
    $defeito_id = $stmt->insert_id;

    // --- INTEGRAÇÃO COM SISTEMA DE MANUTENÇÃO (CRIAÇÃO DE O.S. AUTOMÃTICA) ---
    try {
        // 1. Coletar dados extras para a O.S.
        $ni = 'N/A';
        $nome_aluno = 'Aluno';
        
        $sqlInfo = "SELECT m.numero_identificacao AS maquina_ni, a.aluno_nome 
                    FROM manutencao_tds2026.maquinas m, aluno a 
                    WHERE m.id = ? AND a.idaluno = ?";
        $stmtI = $conn->prepare($sqlInfo);
        if($stmtI){
            $stmtI->bind_param("ii", $maquina_id, $aluno_id);
            $stmtI->execute();
            $rowI = $stmtI->get_result()->fetch_assoc();
            if($rowI){
                $ni = $rowI['maquina_ni'];
                $nome_aluno = $rowI['aluno_nome'];
            }
        }

        // 2. Conectar ao Banco de Manutenção
        $db_manut = 'manutencao_tds2026';
        $connM = mysqli_connect($host, $username, $password, $db_manut);

        if ($connM) {
            // 3. Definir Solicitante/Responsável (ADMIN Padrão)
            $tecnico_id = 1; // Fallback para o primeiro Admin/Técnico
            $sqlG = "SELECT id FROM usuarios WHERE permissao IN ('GESTOR','ADMIN') ORDER BY id ASC LIMIT 1";
            $resG = $connM->query($sqlG);
            if($resG && $rowG = $resG->fetch_assoc()){
                $tecnico_id = $rowG['id'];
            }

            // 4. Preparar Descrição e Inserir O.S.
            $tipo_reportado = $input['tipo'] ?? 'Corretivo';
            
            // O Usuário quer o nome do aluno como "Responsável" na O.S.
            $desc_os = "O.S. GERADA VIA CHECKLIST NR12\n";
            $desc_os .= "Responsável (Relatado por): $nome_aluno\n";
            $desc_os .= "-----------------------------------\n";
            $desc_os .= "Descrição: " . $descricao;

            $status_aberto = 'Em Aberto';

            $sqlOS = "INSERT INTO ordens_servico (descricao, tipo, patrimonio, status, solicitante_id, responsavel_id, anterior_responsavel_id) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtOS = $connM->prepare($sqlOS);
            if($stmtOS){
                $stmtOS->bind_param("ssssiii", $desc_os, $tipo_reportado, $ni, $status_aberto, $tecnico_id, $tecnico_id, $tecnico_id);
                if($stmtOS->execute()){
                    $os_id = $stmtOS->insert_id;
                    
                    // Histórico de Criação
                    $msg_h = "Ordem de Serviço criada pelo aluno $nome_aluno via reporte de checklist NR12.";
                    $sqlH = "INSERT INTO os_historico (os_id, status, origem_id, destino_id, descricao) VALUES (?, 'OS Criada', ?, ?, ?)";
                    $stmtH = $connM->prepare($sqlH);
                    if($stmtH){
                        $stmtH->bind_param("iiis", $os_id, $tecnico_id, $tecnico_id, $msg_h);
                        $stmtH->execute();
                    }
                }
            }
            mysqli_close($connM);
        }
    } catch (Exception $e) {
        // Registrar falha de integração
        error_log("Falha na integração NR12 -> Manutenção: " . $e->getMessage());
    }

    echo json_encode(["mensagem" => "Defeito registrado e O.S. aberta com sucesso!"]);
} else {
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro ao registrar: " . $stmt->error]);
}

$conn->close();
?>
