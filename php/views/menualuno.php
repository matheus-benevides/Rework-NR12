<?php require __DIR__ . "/../controllers/validar_acesso.php"; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>
<?php require __DIR__ . '/../components/modals/aluno_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Aluno - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/icons/favicon.ico" type="image/x-icon">
</head>

<body>

    <section
        style="width: 100%; min-height: 100vh; padding: 40px 20px; display: flex; flex-direction: column; align-items: center; background: var(--corFundo); overflow-y: auto;">

        <div class="doc-container" style="width: 100%; max-width: 1400px; margin: 0 auto;">
            <!-- Header / Hero Section -->
            <div class="doc-hero">
                <div class="hero-content">
                    <h1 style="font-size: var(--text-2xl);">Olá, <?php echo $nome_usuario ?>!</h1>
                    <p>Bem-vindo ao sistema de checklists NR12. Selecione uma das opções abaixo para iniciar sua
                        atividade.</p>
                </div>
                <button type="button" class="btn-download-hero" onclick="window.location.href='../actions/logout.php'"
                    title="Sair do Sistema" style="padding: 15px; width: 55px; justify-content: center;">
                    <i class="bi bi-box-arrow-right" style="margin: 0; font-size: 1.5rem;"></i>
                </button>
            </div>

            <!-- Dashboard Grid -->
            <div class="doc-grid">
                <!-- Card Turma e Curso -->
                <div class="doc-card">
                    <div class="card-icon-box">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2>Sua Turma</h2>
                    <?php
                    $sqlBusca = "SELECT * FROM turmas WHERE idturmas = ?";
                    $stmt = $conn->prepare($sqlBusca);
                    $stmt->bind_param("i", $turma_usuario);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    if ($linha = $resultado->fetch_assoc()) {
                        $nomeTurma = ($linha['turma_nome'] ?? $linha['turmas_nome']);
                        $curso_id = $linha['curso_id'];

                        $sqlCurso = "SELECT * FROM curso WHERE idcurso = ?";
                        $stmtCurso = $conn->prepare($sqlCurso);
                        $stmtCurso->bind_param("i", $curso_id);
                        $stmtCurso->execute();
                        $resultado2 = $stmtCurso->get_result();
                        $nomeCurso = ($linha2 = $resultado2->fetch_assoc()) ? $linha2['curso_nome'] : "Não identificado";

                        echo "<p><strong>Turma:</strong> $nomeTurma</p>";
                        echo "<p><strong>Curso:</strong> $nomeCurso</p>";
                    } else {
                        echo "<p>Informações de turma não encontradas.</p>";
                    }
                    ?>
                </div>

                <!-- Card Máquina -->
                <div class="doc-card">
                    <div class="card-icon-box">
                        <i class="bi bi-cpu-fill"></i>
                    </div>
                    <h2>Máquina Atribuída</h2>
                    <?php
                    $sqlMaq = "SELECT * FROM maquina WHERE idmaquina = ?";
                    $stmtMaq = $conn->prepare($sqlMaq);
                    $stmtMaq->bind_param("i", $id_maquina);
                    $stmtMaq->execute();
                    $resMaq = $stmtMaq->get_result();

                    if ($linhaMaq = $resMaq->fetch_assoc()) {
                        $niMaq = $linhaMaq['maquina_ni'];
                        $idTipo = $linhaMaq['tipomaquina_id'];

                        $sqlTipo = "SELECT tipomaquina_nome FROM tipomaquina WHERE idtipomaquina = ?";
                        $stmtTipo = $conn->prepare($sqlTipo);
                        $stmtTipo->bind_param("i", $idTipo);
                        $stmtTipo->execute();
                        $linhaTipo = $stmtTipo->get_result()->fetch_assoc();
                        $nomeTipo = $linhaTipo ? $linhaTipo['tipomaquina_nome'] : "Não identificado";

                        echo "<p><strong>NI da Máquina:</strong> $niMaq</p>";
                        echo "<p><strong>Tipo:</strong> $nomeTipo</p>";
                    } else {
                        echo "<p>Dados da máquina não encontrados.</p>";
                    }
                    ?>
                </div>

                <!-- Card de Ações / Checklists -->
                <div class="doc-card full-width"
                    style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                    <div class="card-icon-box" style="margin-bottom: 20px;">
                        <i class="bi bi-clipboard-check-fill"></i>
                    </div>
                    <h2>Realizar Checklists</h2>
                    <p style="margin-bottom: 30px;">Complete os checklists obrigatórios antes de iniciar a operação da
                        máquina.</p>

                    <div class="doc-list"
                        style="width: 100%; display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
                        <button type="button" onclick="showModal('checkOperacional')"
                            class="btn-confirmar-metade ferramentas"
                            style="width: 320px; padding: 25px; font-size: 1.15rem; border-radius: 15px; display: flex; align-items: center; justify-content: center; gap: 12px; transition: transform 0.2s;">
                            <i class="bi bi-tools" style="font-size: 1.5rem;"></i> Checklist Operacional
                        </button>

                        <button type="button" onclick="showModal('checkSeguranca')"
                            class="btn-confirmar-metade confirmar"
                            style="width: 320px; padding: 25px; font-size: 1.15rem; border-radius: 15px; display: flex; align-items: center; justify-content: center; gap: 12px; transition: transform 0.2s;">
                            <i class="bi bi-shield-check" style="font-size: 1.5rem;"></i> Checklist de Segurança
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../../js/processa.js" defer></script>
    <script src="../../js/scripts.js" defer></script>
</body>

</html>
