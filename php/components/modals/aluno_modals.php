<?php
// Busca o idmaquina e tipomaquina_id correspondentes ao maquina_ni na sessão
// Essas variáveis já devem estar disponíveis via validar_acesso.php incluído no menualuno.php

$requisitos_seguranca = [];
$requisitos_operacionais = [];
$requisitos_especificos = [];
$colaboradores_geral = [];

if (isset($id_maquina)) {
    // 1. Busca dados da máquina
    $sqlMaquina = "SELECT tipomaquina_id FROM maquina WHERE idmaquina = ?";
    $stmtMaquina = $conn->prepare($sqlMaquina);
    $stmtMaquina->bind_param('i', $id_maquina);
    $stmtMaquina->execute();
    $resMaquina = $stmtMaquina->get_result();
    $maquina = $resMaquina->fetch_assoc();

    if ($maquina) {
        $tipomaquina_id = $maquina['tipomaquina_id'];

        // 2. Busca requisitos de Segurança
        $sqlSeg = "SELECT r.idrequisitos, r.requisito_topico
                   FROM tipomaquina_requisito tr
                   JOIN requisitos r ON tr.requisitos_id = r.idrequisitos
                   WHERE tr.tipomaquina_id = ? AND r.tipo_req = 'Seguranca' AND r.requisitos_status = 'Ativo'";
        $stmtSeg = $conn->prepare($sqlSeg);
        $stmtSeg->bind_param('i', $tipomaquina_id);
        $stmtSeg->execute();
        $requisitos_seguranca = $stmtSeg->get_result()->fetch_all(MYSQLI_ASSOC);

        // 3. Busca requisitos Operacionais
        $sqlOp = "SELECT r.idrequisitos, r.requisito_topico
                  FROM tipomaquina_requisito tr
                  JOIN requisitos r ON tr.requisitos_id = r.idrequisitos
                  WHERE tr.tipomaquina_id = ? AND r.tipo_req = 'Operacional' AND r.requisitos_status = 'Ativo'";
        $stmtOp = $conn->prepare($sqlOp);
        $stmtOp->bind_param('i', $tipomaquina_id);
        $stmtOp->execute();
        $requisitos_operacionais = $stmtOp->get_result()->fetch_all(MYSQLI_ASSOC);

        // 4. Busca Requisitos Específicos
        $sqlEsp = "SELECT idmaquina_requisitos, requisitos_especificos FROM maquina_requisitos WHERE maquina_id = ?";
        $stmtEsp = $conn->prepare($sqlEsp);
        $stmtEsp->bind_param('i', $id_maquina);
        $stmtEsp->execute();
        $requisitos_especificos = $stmtEsp->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// 5. Busca Todos os Colaboradores Ativos
$sqlColab = "SELECT idcolaborador, colaborador_nome, colaborador_email 
             FROM colaborador 
             WHERE colaborador_status = 'Ativo' 
             ORDER BY colaborador_nome ASC";
$resColab = $conn->query($sqlColab);
if ($resColab) {
    $colaboradores_geral = $resColab->fetch_all(MYSQLI_ASSOC);
}
?>

<!-- CHECKLIST SEGURANÇA -->
<div id="checkSeguranca" class="modal-fundo">
    <div class="modal-box premium-modal">
        <div class="modal-header">
            <h3 class="premium-title"><i class="bi bi-shield-check"></i> Checklist de Segurança</h3>
            <button type="button" class="bi bi-x-lg" onclick="closeModal('checkSeguranca')"></button>
        </div>



        <form method="post" id="formCheckSeguranca" onsubmit="enviarChecklist(event, 'Seguranca')" class="premium-form">
            <input type="hidden" name="tipo_checklist" value="Seguranca">

            <div class="colab-section">
                <label for="colaborador_id" class="premium-label">COLABORADOR RESPONSÁVEL</label>
                <div class="select-wrapper">
                    <select name="colaborador_id" class="premium-select" required>
                        <option value="">Selecione um colaborador</option>
                        <?php foreach ($colaboradores_geral as $colab): ?>
                            <option value="<?= $colab['idcolaborador'] ?>">
                                <?= htmlspecialchars($colab['colaborador_nome']) ?>
                                (<?= htmlspecialchars($colab['colaborador_email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="checklist-body">
                <h3 class="titulochecks-premium">Normas de Segurança</h3>
                <div class="checklist-scroll-premium">
                    <?php if (empty($requisitos_seguranca)): ?>
                        <div class="empty-state">Nenhum requisito de segurança vinculado.</div>
                    <?php else: ?>
                        <?php foreach ($requisitos_seguranca as $req): ?>
                            <label class="premium-checkbox-card">
                                <input class="checkbox-input check-norma" type="checkbox" required name="requisitos_ids[]"
                                    value="<?= $req['idrequisitos'] ?>" />
                                <div class="checkbox-box">
                                    <svg class="checkbox-check" width="20" height="20">
                                        <polyline points="16 4 7 13 3 9"></polyline>
                                    </svg>
                                </div>
                                <span class="checkbox-text"><?= htmlspecialchars($req['requisito_topico']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($requisitos_especificos): ?>
                        <h3 class="titulochecks-premium" style="margin-top: 25px;">Requisitos Específicos</h3>
                        <?php foreach ($requisitos_especificos as $reqEsp): ?>
                            <label class="premium-checkbox-card specific">
                                <input class="checkbox-input check-norma" type="checkbox" required
                                    name="requisitos_especifico_ids[]" value="<?= $reqEsp['idmaquina_requisitos'] ?>" />
                                <div class="checkbox-box">
                                    <svg class="checkbox-check" width="20" height="20">
                                        <polyline points="16 4 7 13 3 9"></polyline>
                                    </svg>
                                </div>
                                <span class="checkbox-text"><?= htmlspecialchars($reqEsp['requisitos_especificos']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modal-footer-premium">
                <button type="submit" class="cadastrarhist-premium">Finalizar Inspeção <i
                        class="bi bi-send-fill"></i></button>
            </div>
        </form>
    </div>
</div>

<!-- CHECKLIST OPERACIONAL -->
<div id="checkOperacional" class="modal-fundo">
    <div class="modal-box premium-modal">
        <div class="modal-header">
            <h3 class="premium-title"><i class="bi bi-gear-fill"></i> Checklist Operacional</h3>
            <button type="button" class="bi bi-x-lg" onclick="closeModal('checkOperacional')"></button>
        </div>



        <form method="post" id="formCheckOperacional" onsubmit="enviarChecklist(event, 'Operacional')"
            class="premium-form">
            <input type="hidden" name="tipo_checklist" value="Operacional">

            <div class="colab-section">
                <label for="colaborador_id_op" class="premium-label">COLABORADOR RESPONSÁVEL</label>
                <div class="select-wrapper">
                    <select name="colaborador_id" class="premium-select" required>
                        <option value="">Selecione um colaborador</option>
                        <?php foreach ($colaboradores_geral as $colab): ?>
                            <option value="<?= $colab['idcolaborador'] ?>">
                                <?= htmlspecialchars($colab['colaborador_nome']) ?>
                                (<?= htmlspecialchars($colab['colaborador_email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="checklist-body">
                <h3 class="titulochecks-premium">Normas Operacionais</h3>
                <div class="checklist-scroll-premium">
                    <?php if (empty($requisitos_operacionais)): ?>
                        <div class="empty-state">Nenhum requisito operacional vinculado.</div>
                    <?php else: ?>
                        <?php foreach ($requisitos_operacionais as $req): ?>
                            <label class="premium-checkbox-card op-card">
                                <input class="checkbox-input check-norma" type="checkbox" required name="requisitos_ids[]"
                                    value="<?= $req['idrequisitos'] ?>" />
                                <div class="checkbox-box">
                                    <svg class="checkbox-check" width="20" height="20">
                                        <polyline points="16 4 7 13 3 9"></polyline>
                                    </svg>
                                </div>
                                <span class="checkbox-text"><?= htmlspecialchars($req['requisito_topico']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modal-footer-premium">
                <button type="submit" class="cadastrarhist-premium op-btn">Finalizar Checklist <i
                        class="bi bi-send-fill"></i></button>
            </div>
        </form>
    </div>
</div>