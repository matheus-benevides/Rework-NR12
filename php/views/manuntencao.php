<?php require __DIR__ . '/../controllers/validar_acesso.php'; ?>
<?php require __DIR__ . '/../configs/conexao.php'; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">

</head>

<body>
    <?php require __DIR__ . '/../components/nav.php'; ?>

    <section class="sec-main">

        <?php require __DIR__ . '/../components/header.php'; ?>

        <?php
        // Capturar filtros
        $busca_atual = isset($_GET['search']) ? $_GET['search'] : '';
        $filtro_status = isset($_GET['filtro-status']) ? trim($_GET['filtro-status']) : 'todos';
        $filtro_maquina = isset($_GET['filtro-maquina']) ? trim($_GET['filtro-maquina']) : '';
        $filtro_tipo = isset($_GET['filtro-tipo']) ? trim($_GET['filtro-tipo']) : '';
        $filtro_colaborador = isset($_GET['filtro-colaborador']) ? trim($_GET['filtro-colaborador']) : '';

        // Queries leves para popular filtros rápidos
        $maquinas_lista = [];
        $r = $conn->query("SELECT DISTINCT COALESCE(NULLIF(mq.modelo, ''), mq.denominacao) AS nome
                           FROM manutencao mtn
                           INNER JOIN manutencao_tds2026.maquinas mq ON mtn.maquina_id = mq.id
                           ORDER BY nome ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $maquinas_lista[] = $row['nome']; }

        $tipos_lista = [];
        $r = $conn->query("SELECT DISTINCT tipo_manutencao FROM manutencao WHERE tipo_manutencao IS NOT NULL AND tipo_manutencao != '' ORDER BY tipo_manutencao ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $tipos_lista[] = $row['tipo_manutencao']; }

        $colaboradores_lista = [];
        $r = $conn->query("SELECT DISTINCT col.colaborador_nome
                           FROM manutencao mtn
                           INNER JOIN colaborador col ON mtn.colaborador_id = col.idcolaborador
                           ORDER BY col.colaborador_nome ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $colaboradores_lista[] = $row['colaborador_nome']; }
        ?>

        <div class="page-actions-bar">
            <form action="" method="GET" class="page-search-form">
                <div class="page-search-box <?php echo $busca_atual ? 'has-content' : ''; ?>">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar manutenção...">
                    <?php if ($busca_atual): ?>
                        <a href="?" class="page-clear-btn"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
                <div class="page-filter-box">
                    <label>Status:</label>
                    <select name="filtro-status" onchange="this.form.submit()">
                        <option value="todos" <?= $filtro_status == 'todos' ? 'selected' : '' ?>>Todos</option>
                        <option value="ativo" <?= $filtro_status == 'ativo' ? 'selected' : '' ?>>Ativo</option>
                        <option value="inativo" <?= $filtro_status == 'inativo' ? 'selected' : '' ?>>Inativo</option>
                    </select>
                </div>
                <?php if (!empty($maquinas_lista)): ?>
                <div class="page-filter-box">
                    <label>Máquina:</label>
                    <select name="filtro-maquina" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($maquinas_lista as $m): ?>
                            <option value="<?= htmlspecialchars($m) ?>" <?= $filtro_maquina === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <?php if (!empty($tipos_lista)): ?>
                <div class="page-filter-box">
                    <label>Tipo:</label>
                    <select name="filtro-tipo" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($tipos_lista as $t): ?>
                            <option value="<?= htmlspecialchars($t) ?>" <?= $filtro_tipo === $t ? 'selected' : '' ?>><?= htmlspecialchars($t) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <?php if (!empty($colaboradores_lista)): ?>
                <div class="page-filter-box">
                    <label>Colaborador:</label>
                    <select name="filtro-colaborador" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($colaboradores_lista as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" <?= $filtro_colaborador === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </form>
            <button class="btn-page-action" onclick="showModal('adicaoManutencao')"><i class="bi bi-plus-circle"></i> Adicionar Manutenção</button>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-wrench-adjustable"></i>
                <h2>Manutenção</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Data</th>
                    <th>Máquina</th>
                    <th>Colaborador</th>
                    <th>Estado</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Realizada</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-manuntencao-srv">
                                      <?php
                    // Configuração da Paginação
                    $registros_por_pagina = 10;
                    $pagina_atual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($pagina_atual < 1) $pagina_atual = 1;
                    $offset = ($pagina_atual - 1) * $registros_por_pagina;

                    // Construção da Query Base
                    $where = "WHERE 1=1";
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $where .= " AND (mtn.manutencao_estado LIKE '%$termo_seguro%'
                                   OR mtn.tipo_manutencao LIKE '%$termo_seguro%'
                                   OR col.colaborador_nome LIKE '%$termo_seguro%'
                                   OR COALESCE(NULLIF(mq.modelo, ''), mq.denominacao) LIKE '%$termo_seguro%')";
                    }
                    // Filtro de Status
                    if ($filtro_status !== 'todos') {
                        $where .= " AND LOWER(mtn.manutencao_status) = '" . $conn->real_escape_string($filtro_status) . "'";
                    }
                    // Filtro de Máquina
                    if ($filtro_maquina !== '') {
                        $maq_safe = $conn->real_escape_string($filtro_maquina);
                        $where .= " AND COALESCE(NULLIF(mq.modelo, ''), mq.denominacao) = '$maq_safe'";
                    }
                    // Filtro de Tipo
                    if ($filtro_tipo !== '') {
                        $where .= " AND mtn.tipo_manutencao = '" . $conn->real_escape_string($filtro_tipo) . "'";
                    }
                    // Filtro de Colaborador
                    if ($filtro_colaborador !== '') {
                        $where .= " AND col.colaborador_nome = '" . $conn->real_escape_string($filtro_colaborador) . "'";
                    }

                    // Query para contar o total (para paginação)
                    $sql_count = "SELECT COUNT(*) as total FROM manutencao mtn
                                  INNER JOIN manutencao_tds2026.maquinas mq ON mtn.maquina_id = mq.id
                                  INNER JOIN colaborador col ON mtn.colaborador_id = col.idcolaborador
                                  $where";
                    $total_resultado = $conn->query($sql_count);
                    $total_registros = $total_resultado->fetch_assoc()['total'];
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Final com LIMIT e OFFSET
                    $sql = "SELECT 
                               mtn.*,
                               COALESCE(NULLIF(mq.modelo, ''), mq.denominacao) AS maquina_modelo,
                               col.colaborador_nome
                           FROM manutencao mtn
                           INNER JOIN manutencao_tds2026.maquinas mq
                               ON mtn.maquina_id = mq.id
                           INNER JOIN colaborador col
                               ON mtn.colaborador_id = col.idcolaborador
                           $where
                           ORDER BY mtn.manutencao_data DESC
                           LIMIT $registros_por_pagina OFFSET $offset";

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . date('d/m/Y', strtotime($linha["manutencao_data"])) . "</td>";
                            echo "<td>" . ($linha["maquina_modelo"] ?? 'Máquina não encontrada') . "</td>";
                            echo "<td>" . ($linha["colaborador_nome"] ?? 'Colaborador não encontrado') . "</td>";
                            echo "<td>" . $linha["manutencao_estado"] . "</td>";
                            echo "<td>" . $linha["manutencao_descricao"] . "</td>";
                            echo "<td>" . $linha["tipo_manutencao"] . "</td>";
                            echo "<td>" . $linha["manutencao_realizada"] . "</td>";

                            $status = strtolower($linha["manutencao_status"]);
                            $classe = ($status == 'ativo') ? 'status-ativo' : 'status-inativo';

                            echo "<td><span class='$classe'>" . ucfirst($status) . "</span></td>";

                            echo "<td>
                                    <div style='display:flex; gap:5px; justify-content:center;'>
                                        <button class='btnAcao editar' type='button' title='Desativar' onclick=\"showModal('desativarManutencao', " . $linha['idmanutencao'] . ")\"><i class='bi bi-power'></i></button>
                                        <button class='btnAcao deletar' type='button' title='Excluir' onclick=\"showModal('deletarManutencao', " . $linha['idmanutencao'] . ",'')\"><i class='bi bi-trash'></i></button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center; padding:30px; opacity:0.6;'><i class='bi bi-info-circle' style='font-size:1.5rem; display:block; margin-bottom:10px;'></i>Nenhum registro de manutenção encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <?php
                $pag_params = http_build_query(array_filter([
                    'search' => $busca_atual,
                    'filtro-status' => $filtro_status !== 'todos' ? $filtro_status : '',
                    'filtro-maquina' => $filtro_maquina,
                    'filtro-tipo' => $filtro_tipo,
                    'filtro-colaborador' => $filtro_colaborador,
                ], fn($v) => $v !== ''));
            ?>
            <div class="page-pagination">
                <?php if ($pagina_atual > 1): ?>
                    <a href="?<?= $pag_params ?>&page=<?= $pagina_atual - 1 ?>" class="pag-btn"><i class="bi bi-chevron-left"></i> Anterior</a>
                <?php else: ?>
                    <span class="pag-btn disabled"><i class="bi bi-chevron-left"></i> Anterior</span>
                <?php endif; ?>
                <span class="pag-current">Página <?php echo $pagina_atual; ?> de <?php echo max(1, $total_paginas); ?></span>
                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="?<?= $pag_params ?>&page=<?= $pagina_atual + 1 ?>" class="pag-btn">Próxima <i class="bi bi-chevron-right"></i></a>
                <?php else: ?>
                    <span class="pag-btn disabled">Próxima <i class="bi bi-chevron-right"></i></span>
                <?php endif; ?>
            </div>
         </div>

    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>
