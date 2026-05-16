<?php require __DIR__ . '/../controllers/validar_acesso.php'; ?>
<?php require __DIR__ . '/../configs/conexao.php'; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Máquinas - NR12</title>

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
        $filtro_modelo = isset($_GET['filtro-modelo']) ? trim($_GET['filtro-modelo']) : '';
        $filtro_marca = isset($_GET['filtro-marca']) ? trim($_GET['filtro-marca']) : '';
        $filtro_setor = isset($_GET['filtro-setor']) ? trim($_GET['filtro-setor']) : '';

        // Queries leves para popular os selects de filtro rápido
        $modelos_lista = [];
        $r = $conn_manutencao->query("SELECT DISTINCT modelo FROM maquinas WHERE modelo IS NOT NULL AND modelo != '' ORDER BY modelo ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $modelos_lista[] = $row['modelo']; }

        $marcas_lista = [];
        $r = $conn_manutencao->query("SELECT DISTINCT marca FROM maquinas WHERE marca IS NOT NULL AND marca != '' ORDER BY marca ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $marcas_lista[] = $row['marca']; }

        $setores_lista = [];
        $r = $conn_manutencao->query("SELECT DISTINCT setor FROM maquinas WHERE setor IS NOT NULL AND setor != '' ORDER BY setor ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $setores_lista[] = $row['setor']; }
        ?>

        <div class="page-actions-bar">
            <form action="" method="GET" class="page-search-form">
                <div class="page-search-box <?php echo $busca_atual ? 'has-content' : ''; ?>">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar máquina...">
                    <?php if ($busca_atual): ?>
                        <a href="?" class="page-clear-btn"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
                <?php if (!empty($modelos_lista)): ?>
                <div class="page-filter-box">
                    <label>Modelo:</label>
                    <select name="filtro-modelo" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($modelos_lista as $m): ?>
                            <option value="<?= htmlspecialchars($m) ?>" <?= $filtro_modelo === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <?php if (!empty($marcas_lista)): ?>
                <div class="page-filter-box">
                    <label>Marca:</label>
                    <select name="filtro-marca" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($marcas_lista as $m): ?>
                            <option value="<?= htmlspecialchars($m) ?>" <?= $filtro_marca === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <?php if (!empty($setores_lista)): ?>
                <div class="page-filter-box">
                    <label>Setor:</label>
                    <select name="filtro-setor" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($setores_lista as $s): ?>
                            <option value="<?= htmlspecialchars($s) ?>" <?= $filtro_setor === $s ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </form>
            <button class="btn-page-action" onclick="showModal('adicaoMaquina')"><i class="bi bi-plus-circle"></i> Adicionar Máquina</button>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-gear"></i>
                <h2>Máquinas</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Denominação</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>NI</th>
                    <th>Ano</th>
                    <th>Setor</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-maquinas-srv">
                    <?php
                    // Configuração da Paginação
                    $registros_por_pagina = 10;
                    $pagina_atual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($pagina_atual < 1) $pagina_atual = 1;
                    $offset = ($pagina_atual - 1) * $registros_por_pagina;

                    // Query Base
                    $where = "WHERE 1=1";
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn_manutencao->real_escape_string($busca_atual);
                        $where .= " AND (denominacao LIKE '%$termo_seguro%' 
                                   OR marca LIKE '%$termo_seguro%' 
                                   OR modelo LIKE '%$termo_seguro%' 
                                   OR numero_identificacao LIKE '%$termo_seguro%')";
                    }
                    if ($filtro_modelo !== '') {
                        $where .= " AND modelo = '" . $conn_manutencao->real_escape_string($filtro_modelo) . "'";
                    }
                    if ($filtro_marca !== '') {
                        $where .= " AND marca = '" . $conn_manutencao->real_escape_string($filtro_marca) . "'";
                    }
                    if ($filtro_setor !== '') {
                        $where .= " AND setor = '" . $conn_manutencao->real_escape_string($filtro_setor) . "'";
                    }

                    // Query de Contagem
                    $sql_count = "SELECT COUNT(*) as total FROM maquinas $where";
                    $total_resultado = $conn_manutencao->query($sql_count);
                    $total_registros = $total_resultado->fetch_assoc()['total'];
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Principal com Paginação
                    $sql = "SELECT id, denominacao, marca, modelo, numero_identificacao, ano_fabricacao, setor
                            FROM maquinas
                            $where
                            ORDER BY denominacao ASC
                            LIMIT $registros_por_pagina OFFSET $offset";

                    $resultado = $conn_manutencao->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["denominacao"] . "</td>";
                            echo "<td>" . $linha["marca"] . "</td>";
                            echo "<td>" . $linha["modelo"] . "</td>";
                            echo "<td>" . $linha["numero_identificacao"] . "</td>";
                            echo "<td>" . $linha["ano_fabricacao"] . "</td>";
                            echo "<td>" . $linha["setor"] . "</td>";

                            // Botões de Ação
                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' title='Editar' type='button' onclick=\"showModal('edicaoMaquina', " . $linha['id'] . ")\"><i class='bi bi-pencil-square'></i></button>
                                        <button class='btnAcao deletar' title='Excluir' type='button' onclick=\"showModal('deletarMaquina', " . $linha['id'] . ",'')\"><i class='bi bi-trash'></i></button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center; padding:30px; opacity:0.6;'><i class='bi bi-info-circle' style='font-size:1.5rem; display:block; margin-bottom:10px;'></i>Nenhuma máquina encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <?php
                $pag_params = http_build_query(array_filter([
                    'search' => $busca_atual,
                    'filtro-modelo' => $filtro_modelo,
                    'filtro-marca' => $filtro_marca,
                    'filtro-setor' => $filtro_setor,
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

    <script src="../../js/scripts.js?v=2" defer></script>
    <script src="../../js/processa_lotes.js?v=2" defer></script>
</body>

</html>
