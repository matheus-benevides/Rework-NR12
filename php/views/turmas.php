<?php require __DIR__ . '/../controllers/validar_acesso.php'; ?>
<?php require __DIR__ . '/../configs/conexao.php'; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Turmas - NR12</title>

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

        <div class="page-actions-bar">
            <form action="" method="GET" class="page-search-form">
                <?php $busca_atual = isset($_GET['search']) ? $_GET['search'] : ''; ?>
                <div class="page-search-box <?php echo $busca_atual ? 'has-content' : ''; ?>">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar turma...">
                    <?php if ($busca_atual): ?>
                        <a href="?" class="page-clear-btn"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
                <div class="page-filter-box">
                    <label>Status:</label>
                    <select name="filtro-status" onchange="this.form.submit()">
                        <option value="todos">Todos</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
            </form>
            <button class="btn-page-action" onclick="showModal('adicaoTurma')"><i class="bi bi-plus-circle"></i> Adicionar Turma</button>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-mortarboard"></i>
                <h2>Turmas</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Turma</th>
                    <th>Período</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Nome do Curso</th>
                    <th>Colaborador</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-turmas-srv">
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
                        $where .= " AND (t.turma_nome LIKE '%$termo_seguro%' 
                                   OR t.turma_periodo LIKE '%$termo_seguro%' 
                                   OR cs.curso_nome LIKE '%$termo_seguro%' 
                                   OR c.colaborador_nome LIKE '%$termo_seguro%')";
                    }

                    // Query de Contagem
                    $sql_count = "SELECT COUNT(*) as total FROM turmas t 
                                 LEFT JOIN colaborador c ON t.colaborador_id = c.idcolaborador
                                 LEFT JOIN curso cs ON t.curso_id = cs.idcurso $where";
                    $total_resultado = $conn->query($sql_count);
                    $total_registros = $total_resultado->fetch_assoc()['total'];
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Principal com Paginação
                    $sql = "SELECT t.*, c.colaborador_nome, cs.curso_nome 
                            FROM turmas t
                            LEFT JOIN colaborador c ON t.colaborador_id = c.idcolaborador
                            LEFT JOIN curso cs ON t.curso_id = cs.idcurso
                            $where
                            ORDER BY t.turma_nome ASC
                            LIMIT $registros_por_pagina OFFSET $offset";

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["turma_nome"] . "</td>";
                            echo "<td>" . $linha["turma_periodo"] . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($linha["turma_inicio"])) . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($linha["turma_fim"])) . "</td>";
                            echo "<td>" . $linha["curso_nome"] . "</td>";
                            echo "<td>" . $linha["colaborador_nome"] . "</td>";

                            $status = strtolower($linha["turmas_status"]);
                            $classe = ($status == 'ativo') ? 'status-ativo' : 'status-inativo';

                            echo "<td><span class='$classe'>" . $linha["turmas_status"] . "</span></td>";

                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' title='Editar' type='button' onclick=\"abrirModalEdicaoTurma(" . $linha['idturmas'] . ", '" . addslashes($linha['turma_nome']) . "', '" . $linha['turma_periodo'] . "', " . $linha['colaborador_id'] . ", '" . $linha['turma_inicio'] . "', '" . $linha['turma_fim'] . "', " . $linha['curso_id'] . ")\"><i class='bi bi-pencil-square'></i></button>";

                            if ($status == 'ativo') {
                                echo "<button class='btnAcao deletar' title='Desativar' type='button' onclick=\"showModal('deletarTurma', " . $linha['idturmas'] . ")\"><i class='bi bi-x-lg'></i></button>";
                            } else {
                                echo "<button class='btnAcao confirmar' style='background-color: var(--confirmar);' title='Ativar' type='button' onclick=\"showModal('ativarTurma', " . $linha['idturmas'] . ")\"><i class='bi bi-check-lg'></i></button>";
                            }

                            echo "    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center; padding:30px; opacity:0.6;'><i class='bi bi-info-circle' style='font-size:1.5rem; display:block; margin-bottom:10px;'></i>Nenhuma turma encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
                        <div class="page-pagination">
                <?php if ($pagina_atual > 1): ?>
                    <a href="?search=<?php echo urlencode($busca_atual); ?>&page=<?php echo $pagina_atual - 1; ?>" class="pag-btn"><i class="bi bi-chevron-left"></i> Anterior</a>
                <?php else: ?>
                    <span class="pag-btn disabled"><i class="bi bi-chevron-left"></i> Anterior</span>
                <?php endif; ?>
                <span class="pag-current">Página <?php echo $pagina_atual; ?> de <?php echo max(1, $total_paginas); ?></span>
                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="?search=<?php echo urlencode($busca_atual); ?>&page=<?php echo $pagina_atual + 1; ?>" class="pag-btn">Próxima <i class="bi bi-chevron-right"></i></a>
                <?php else: ?>
                    <span class="pag-btn disabled">Próxima <i class="bi bi-chevron-right"></i></span>
                <?php endif; ?>
            </div>
         </div>

    </section>

    <script src="../../js/processa.js" defer></script>
    <script src="../../js/scripts.js" defer></script>
    <script src="../../js/processa_lotes.js" defer></script>
</body>

</html>
