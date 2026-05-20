<?php require __DIR__ . "/../controllers/validar_acesso.php"; ?>
<?php require __DIR__ . '/../configs/conexao.php'; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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
                    <input type="text" name="search" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar suporte...">
                    <?php if ($busca_atual): ?>
                        <a href="?" class="page-clear-btn"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
                <div class="page-filter-box">
                    <label>Situação:</label>
                    <select name="filtro-suporte" onchange="this.form.submit()">
                        <option value="todos">Todos</option>
                        <option value="resolvido">Resolvido</option>
                        <option value="pendente">Pendente</option>
                    </select>
                </div>
            </form>
            <button class="btn-page-action" onclick="showModal('adicaoSuporte')"><i class="bi bi-plus-circle"></i> Solicitar Suporte</button>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-headset"></i>
                <h2>Suporte</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Colaborador</th>
                    <th>Descrição</th>
                    <th>Situação</th>
                    <th>Data Solicitação</th>
                    <th>Data Solução</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-suporte-srv">
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
                        $where .= " AND (se.desc_erro LIKE '%$termo_seguro%' 
                                   OR se.situacao LIKE '%$termo_seguro%' 
                                   OR c.colaborador_nome LIKE '%$termo_seguro%')";
                    }

                    // Se não for Adm, vê apenas as suas solicitações
                    if ($permissao_usuario != "Adm") {
                        $where .= " AND se.id_colaborador = $id_usuario";
                    }

                    // Query de Contagem
                    $sql_count = "SELECT COUNT(*) as total FROM solicitacao_erro se LEFT JOIN colaborador c ON se.id_colaborador = c.idcolaborador $where";
                    $total_resultado = $conn->query($sql_count);
                    $total_registros = $total_resultado->fetch_assoc()['total'];
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Principal com Paginação
                    $sql = "SELECT se.*, c.colaborador_nome
                            FROM solicitacao_erro se
                            LEFT JOIN colaborador c ON se.id_colaborador = c.idcolaborador
                            $where
                            ORDER BY se.data_solicitacao DESC
                            LIMIT $registros_por_pagina OFFSET $offset";

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($linha["colaborador_nome"]) . "</td>";
                            echo "<td>" . htmlspecialchars($linha["desc_erro"]) . "</td>";
                            
                            $status = strtolower($linha["situacao"]);
                            $classe = ($status == 'resolvido') ? 'status-ativo' : 'status-inativo';

                            echo "<td><span class='$classe'>" . htmlspecialchars($linha["situacao"]) . "</span></td>";
                            echo "<td>" . ($linha["data_solicitacao"] ? date('d/m/Y H:i', strtotime($linha["data_solicitacao"])) : '---') . "</td>";
                            echo "<td>" . ($linha["data_solucao"] ? date('d/m/Y H:i', strtotime($linha["data_solucao"])) : '---') . "</td>";

                            echo "<td><div style='display: flex; gap: 5px; justify-content: center;'>";
                            if ($permissao_usuario == "Adm") {
                                if ($status != 'resolvido') {
                                    echo "<button type='button' onclick=\"resolverSuporte(" . $linha['idsolicitacao_erro'] . ")\" class='btnAcao confirmar' title='Resolver'><i class='bi bi-check-lg'></i></button>";
                                } else {
                                    echo "<button type='button' class='btnAcao clipes' title='Concluído'><i class='bi bi-shield-fill'></i></button>";
                                }
                            } else {
                                echo "---";
                            }
                            echo "</div></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding:30px; opacity:0.6;'><i class='bi bi-info-circle' style='font-size:1.5rem; display:block; margin-bottom:10px;'></i>Nenhuma solicitação de suporte encontrada.</td></tr>";
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
    <script src="../../js/processa.js" defer></script>
</body>

</html>
