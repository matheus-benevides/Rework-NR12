<?php
// Busca o idmaquina e tipomaquina_id correspondentes ao maquina_ni na sessão
// Essas variáveis já devem estar disponíveis via validar_acesso.php incluído no menualuno.php

$requisitos_seguranca = [];
$requisitos_operacionais = [];
$requisitos_especificos = [];
$colaboradores_geral = [];

if (isset($id_maquina)) {
    // 1. Busca dados da máquina
    $sqlMaquina = "SELECT m.tipomaquina_id, m.maquina_ni, t.tipomaquina_nome 
                   FROM maquina m
                   LEFT JOIN tipomaquina t ON m.tipomaquina_id = t.idtipomaquina
                   WHERE m.idmaquina = ?";
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
                                <input class="checkbox-input check-norma" type="checkbox" name="requisitos_ids[]"
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
                                <input class="checkbox-input check-norma" type="checkbox"
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
                                <input class="checkbox-input check-norma" type="checkbox" name="requisitos_ids[]"
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

<!-- MODAL DE CONFIRMAÇÃO PARA PROSSEGUIR COM CHECKLIST INCOMPLETO -->
<div class="modal-fundo" id="confirmarProceed" style="display: none;">
    <div class="modal-box premium-modal" style="max-width: 450px;">
        <div class="modal-header">
            <h3 class="premium-title"><i class="bi bi-question-circle-fill"></i> Itens não marcados</h3>
            <button type="button" class="bi bi-x-lg" onclick="closeModal('confirmarProceed')"></button>
        </div>
        <div class="premium-form" style="padding: 20px; text-align: center;">
            <div class="modal-input">
                <p style="color: var(--sombra); font-size: var(--txt-4xl); margin-bottom: 25px;">
                    Identificamos que nem todos os itens foram marcados. Deseja prosseguir e reportar um problema à manutenção?
                </p>
            </div>
            <div class="modal-footer-premium" style="display: flex; gap: 15px; justify-content: center;">
                <button type="button" class="cadastrarhist-premium" onclick="confirmarNaoProceed()" style="background-color: var(--corBase); flex: 1;">
                    Não, Voltar <i class="bi bi-arrow-left"></i>
                </button>
                <button type="button" class="cadastrarhist-premium" onclick="confirmarSimProceed()" style="background-color: var(--confirmar); flex: 1;">
                    Sim, Prosseguir <i class="bi bi-check-lg"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE ERRO (VISUAL PREMIUM) -->
<div class="modal-fundo" id="erro" style="display: none;">
    <div class="modal-box premium-modal" style="max-width: 450px; text-align: center;">
        <div class="modal-header">
            <h3 class="premium-title"><i class="bi bi-exclamation-octagon-fill"></i> Atenção</h3>
            <button type="button" class="bi bi-x-lg" onclick="closeModal('erro')"></button>
        </div>
        <div class="premium-form" style="padding: 30px;">
            <div class="modal-input">
                <p id="erro-msg" style="color: var(--sombra); font-size: var(--txt-4xl); margin-bottom: 25px;">
                    Você precisa reportar o defeito para prosseguir com o checklist incompleto.
                </p>
            </div>
            <div class="modal-footer-premium">
                <button type="button" class="cadastrarhist-premium" onclick="closeModal('erro')" style="background-color: var(--corBase); width: 100%;">
                    Entendido <i class="bi bi-check-lg"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal-fundo" id="reportarMaquina">
    <div class="modal-box premium-modal" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="premium-title"><i class="bi bi-exclamation-triangle-fill"></i> Reportar Erro à Manutenção</h3>
            <button type="button" class="bi bi-x-lg" onclick="closeModal('reportarMaquina')"></button>
        </div>
        <form id="formReportarErro" onsubmit="enviarReporteErro(event)" class="premium-form">
            <div class="modal-input">
                <p style="color: var(--sombra); font-size: 1.1rem; margin-bottom: 20px; text-align: center;">Identificamos que nem todos os requisitos foram selecionados.</p>
                
                <!-- Info da Máquina Automática -->
                <div style="background: var(--corFundo); padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid var(--corBordas); display: flex; align-items: center; gap: 15px; justify-content: center;">
                    <i class="bi bi-cpu-fill" style="font-size: 1.5rem; color: var(--corBase);"></i>
                    <div style="text-align: left;">
                        <p style="margin: 0; color: var(--corTxt3); font-size: 0.9rem; opacity: 0.8;">Patrimônio / Máquina:</p>
                        <p style="margin: 0; color: var(--corTxt3); font-weight: 600;">
                            <?= htmlspecialchars($maquina['maquina_ni'] ?? 'N/A') ?> - <?= htmlspecialchars($maquina['tipomaquina_nome'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-input" style="margin-top: 15px;">
                <label for="tipo_reporte" class="premium-label">TIPO:</label>
                <div class="select-wrapper">
                    <select name="tipo" id="tipo_reporte" class="premium-select" required>
                        <option value="Corretivo" selected>Corretivo</option>
                        <!-- <option value="Outros">Outros</option> -->
                    </select>
                </div>
            </div>

            <div class="modal-input" style="margin-top: 15px;">
                <label for="desc_reporte" class="premium-label">DESCRIÇÃO DO PROBLEMA:</label>
                <textarea name="descricao" id="desc_reporte" class="premium-input" style="height: 120px; resize: none; padding: 12px;" placeholder="Descreva o problema detalhadamente..." required></textarea>
            </div>

            <div class="modal-footer-premium" style="margin-top: 25px; display: flex; justify-content: center;">
                <button type="submit" class="cadastrarhist-premium" style="background-color: var(--confirmar); width: 100%; padding: 15px; font-weight: 600;">Abrir O.S. <i class="bi bi-send-fill"></i></button>
            </div>
        </form>
    </div>
</div>