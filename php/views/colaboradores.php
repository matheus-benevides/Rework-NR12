<?php require __DIR__ . '/../controllers/validar_acesso.php'; ?>
<?php require __DIR__ . '/../configs/conexao.php'; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Cursos - NR12</title>

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
        $filtro_setor = isset($_GET['filtro-setor']) ? trim($_GET['filtro-setor']) : '';
        $filtro_permissao = isset($_GET['filtro-permissao']) ? trim($_GET['filtro-permissao']) : '';

        // Queries leves para filtros rápidos
        $setores_lista = [];
        $r = $conn->query("SELECT DISTINCT s.setor_nome FROM colaborador c LEFT JOIN setor s ON s.idsetor = c.setor_id WHERE s.setor_nome IS NOT NULL AND s.setor_nome != '' ORDER BY s.setor_nome ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $setores_lista[] = $row['setor_nome']; }

        $permissoes_lista = [];
        $r = $conn->query("SELECT DISTINCT colaborador_permissao FROM colaborador WHERE colaborador_permissao IS NOT NULL AND colaborador_permissao != '' ORDER BY colaborador_permissao ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $permissoes_lista[] = $row['colaborador_permissao']; }
        ?>

        <div class="page-actions-bar">
            <form action="" method="GET" class="page-search-form">
                <div class="page-search-box <?php echo $busca_atual ? 'has-content' : ''; ?>">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar colaborador...">
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
                <?php if (!empty($permissoes_lista)): ?>
                <div class="page-filter-box">
                    <label>Permissão:</label>
                    <select name="filtro-permissao" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($permissoes_lista as $p): ?>
                            <option value="<?= htmlspecialchars($p) ?>" <?= $filtro_permissao === $p ? 'selected' : '' ?>><?= htmlspecialchars($p) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </form>
            <button class="btn-page-action" onclick="showModal('adicaoColaborador')"><i class="bi bi-plus-circle"></i> Adicionar Colaborador</button>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-person-badge"></i>
                <h2>Colaboradores</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Nome</th>
                    <th>NIF</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Setor</th>
                    <th>Status</th>
                    <th>Permissão</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-colaboradores-srv">
                    <?php
                    // Configuração da Paginação
                    $registros_por_pagina = 10;
                    $pagina_atual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($pagina_atual < 1) $pagina_atual = 1;
                    $offset = ($pagina_atual - 1) * $registros_por_pagina;

                    // Query Base
                    $where = "WHERE 1=1";
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $where .= " AND (c.colaborador_nome LIKE '%$termo_seguro%' 
                                   OR c.colaborador_nif LIKE '%$termo_seguro%' 
                                   OR c.colaborador_email LIKE '%$termo_seguro%' 
                                   OR s.setor_nome LIKE '%$termo_seguro%')";
                    }
                    // Filtro de Status
                    if ($filtro_status !== 'todos') {
                        $where .= " AND LOWER(c.colaborador_status) = '" . $conn->real_escape_string($filtro_status) . "'";
                    }
                    // Filtro de Setor
                    if ($filtro_setor !== '') {
                        $where .= " AND s.setor_nome = '" . $conn->real_escape_string($filtro_setor) . "'";
                    }
                    // Filtro de Permissão
                    if ($filtro_permissao !== '') {
                        $where .= " AND c.colaborador_permissao = '" . $conn->real_escape_string($filtro_permissao) . "'";
                    }

                    // Query de Contagem
                    $sql_count = "SELECT COUNT(*) as total FROM colaborador c LEFT JOIN setor s ON s.idsetor = c.setor_id $where";
                    $total_resultado = $conn->query($sql_count);
                    $total_registros = $total_resultado->fetch_assoc()['total'];
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Principal com Paginação
                    $sql = "SELECT c.*, s.setor_nome 
                            FROM colaborador c
                            LEFT JOIN setor s ON s.idsetor = c.setor_id
                            $where
                            ORDER BY c.colaborador_nome ASC
                            LIMIT $registros_por_pagina OFFSET $offset";

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["colaborador_nome"] . "</td>";
                            echo "<td>" . $linha["colaborador_nif"] . "</td>";
                            echo "<td>" . $linha["colaborador_email"] . "</td>";
                            echo "<td> ***** </td>";

                            $nome_setor = !empty($linha["setor_nome"]) ? $linha["setor_nome"] : "<span style='color: #999; font-style: italic;'>Sem setor</span>";
                            echo "<td>" . $nome_setor . "</td>";

                            $status = strtolower($linha["colaborador_status"]);
                            $classe = ($status == 'ativo') ? 'status-ativo' : 'status-inativo';

                            echo "<td><span class='$classe'>" . $linha["colaborador_status"] . "</span></td>";
                            echo "<td>" . $linha["colaborador_permissao"] . "</td>";

                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>";

                            // Edit
                            echo "<button class='btnAcao editar' title='Editar' type='button' onclick=\"abrirModalEdicaoColaborador(" . $linha['idcolaborador'] . ", '" . addslashes($linha['colaborador_nome']) . "', '" . addslashes($linha['colaborador_email']) . "', '" . addslashes($linha['colaborador_permissao']) . "', '" . addslashes($linha['colaborador_nif']) . "', '" . $linha['setor_id'] . "')\"><i class='bi bi-pencil-square'></i></button>";

                            // Ativar / Desativar
                            if ($status == 'ativo') {
                                echo "<button class='btnAcao deletar' title='Desativar' type='button' onclick=\"showModal('desativarColaborador', " . $linha['idcolaborador'] . ")\"><i class='bi bi-x-lg'></i></button>";
                            } else {
                                echo "<button class='btnAcao confirmar' style='background-color: var(--confirmar);' title='Ativar' type='button' onclick=\"showModal('ativarColaborador', " . $linha['idcolaborador'] . ")\"><i class='bi bi-check-lg'></i></button>";
                            }

                            // Reset Senha
                            echo "<button class='btnAcao deletar' type='button' style='background-color: #ffc107; color: #000;' title='Resetar Senha' onclick=\"showModal('resetPass', " . $linha['idcolaborador'] . ")\"><i class='bi bi-key-fill'></i></button>";

                            echo "  </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center; padding:30px; opacity:0.6;'><i class='bi bi-info-circle' style='font-size:1.5rem; display:block; margin-bottom:10px;'></i>Nenhum colaborador encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <?php
                $pag_params = http_build_query(array_filter([
                    'search' => $busca_atual,
                    'filtro-status' => $filtro_status !== 'todos' ? $filtro_status : '',
                    'filtro-setor' => $filtro_setor,
                    'filtro-permissao' => $filtro_permissao,
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
    <script src="../../js/processa.js" defer></script>
    <script src="../../js/processa_lotes.js" defer></script>
</body>

</html>
