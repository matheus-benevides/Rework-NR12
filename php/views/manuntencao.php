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

        <div class="page-actions-bar">
            <form action="" method="GET" class="page-search-form">
                <?php $busca_atual = isset($_GET['search']) ? $_GET['search'] : ''; ?>
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
                        <option value="todos">Todos</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
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
                                   OR mq.maquina_modelo LIKE '%$termo_seguro%')";
                    }

                    // Query para contar o total (para paginação)
                    $sql_count = "SELECT COUNT(*) as total FROM manutencao mtn
                                  INNER JOIN maquina mq ON mtn.maquina_id = mq.idmaquina
                                  INNER JOIN colaborador col ON mtn.colaborador_id = col.idcolaborador
                                  $where";
                    $total_resultado = $conn->query($sql_count);
                    $total_registros = $total_resultado->fetch_assoc()['total'];
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Final com LIMIT e OFFSET
                    $sql = "SELECT 
                               mtn.*,
                               mq.maquina_modelo,
                               col.colaborador_nome
                           FROM manutencao mtn
                           INNER JOIN maquina mq
                               ON mtn.maquina_id = mq.idmaquina
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

    <script src="../../js/scripts.js" defer></script>
</body>

</html>
