<?php require "../controllers/validar_acesso.php"; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/icons/favicon.ico" type="image/x-icon">
</head>

<body>
    <?php require '../components/nav.php'; ?>

    <section class="sec-main dontmove" style="align-items: center; justify-content: center;">

        <?php require '../components/header.php'; ?>

        <div class="div-btns-pages">

            <form action="" method="GET" class="form-pesquisa">
                <div class="search-container">
                    <?php
                    // Captura o valor atual para manter no input
                    $busca_atual = isset($_GET['search']) ? $_GET['search'] : '';
                    ?>
                    <div class="box-pesquisa">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" id="pesquisa"
                            value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar..."
                            class="input-pesquisa">

                        <?php if ($busca_atual): ?>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn-clear-search"><i
                                    class="bi bi-x-lg"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="filtrar-status">
                        <label for="">Status:</label>
                        <select id="select-filtro-suporte" name="filtro-suporte" onchange="filtrarSuporte()">
                            <option value="todos">Todos</option>
                            <option value="resolvido">Resolvido</option>
                            <option value="pendente">Pendente</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoSuporte')">Solicitar Suporte <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>
                    <th>Colaborador</th>
                    <th>Descrição</th>
                    <th>Onde</th>
                    <th>Tipo</th>
                    <th>Urgência</th>
                    <th>Situação</th>
                    <th>Data Solicitação</th>
                    <th>Data Solução</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-suporte">
                    <?php
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);

                        $sql = "SELECT se.*, c.colaborador_nome
                        FROM solicitacao_erro se
                        LEFT JOIN colaborador c 
                            ON se.id_colaborador = c.idcolaborador
                        WHERE se.desc_erro LIKE '%$termo_seguro%' OR 
                              se.onde LIKE '%$termo_seguro%' OR 
                              se.tipo LIKE '%$termo_seguro%' OR
                              se.urgencia LIKE '%$termo_seguro%' OR
                              se.situacao LIKE '%$termo_seguro%' OR
                              c.colaborador_nome LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT se.idsolicitacao_erro, se.desc_erro, se.onde, se.urgencia, se.tipo, se.situacao, se.data_solicitacao, se.data_solucao, c.colaborador_nome
                            FROM solicitacao_erro se
                            LEFT JOIN colaborador c 
                                ON se.id_colaborador = c.idcolaborador";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        if ($permissao_usuario == "Adm") {
                            while ($linha = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $linha["colaborador_nome"] . "</td>";
                                echo "<td>" . $linha["desc_erro"] . "</td>";
                                echo "<td>" . $linha["onde"] . "</td>";
                                echo "<td>" . $linha["tipo"] . "</td>";
                                echo "<td>" . $linha["urgencia"] . "</td>";
                                $status = strtolower($linha["situacao"]);

                                if ($status == 'resolvido') {
                                    $classe = 'status-ativo';
                                } else {
                                    $classe = 'status-inativo';
                                }

                                echo "<td><span class='$classe'>" . $linha["situacao"] . "</span></td>";
                                echo "<td>" . $linha["data_solicitacao"] . "</td>";
                                echo "<td>" . $linha["data_solucao"] . "</td>";

                                if ($permissao_usuario == "Adm") {
                                    if ($status != 'resolvido') {
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'><button type='button' onclick=\"resolverSuporte(" . $linha['idsolicitacao_erro'] . ")\" class='btnAcao confirmar' title='Resolver'><i class='bi bi-check-lg'></i></button>";
                                        echo "</div></td>";
                                    } else {
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'><button type='button' class='btnAcao clipes' title='Concluído'><i class='bi bi-shield-fill'></i></button></td>";
                                    }
                                }
                                echo "</tr>";
                            }
                        } else {
                            $sql = "SELECT se.idsolicitacao_erro, se.desc_erro, se.onde, se.urgencia, se.tipo, se.situacao, se.data_solicitacao, se.data_solucao, c.colaborador_nome
                            FROM solicitacao_erro se
                            LEFT JOIN colaborador c 
                                ON se.id_colaborador = c.idcolaborador WHERE se.id_colaborador = $id_usuario";

                            $resultado = $conn->query($sql);
                            while ($linha = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $linha["colaborador_nome"] . "</td>";
                                echo "<td>" . $linha["desc_erro"] . "</td>";
                                echo "<td>" . $linha["onde"] . "</td>";
                                echo "<td>" . $linha["tipo"] . "</td>";
                                echo "<td>" . $linha["urgencia"] . "</td>";
                                $status = strtolower($linha["situacao"]);

                                if ($status == 'resolvido') {
                                    $classe = 'status-ativo';
                                } else {
                                    $classe = 'status-inativo';
                                }

                                echo "<td><span class='$classe'>" . $linha["situacao"] . "</span></td>";
                                echo "<td>" . $linha["data_solicitacao"] . "</td>";
                                echo "<td>" . $linha["data_solucao"] . "</td>";

                                if ($permissao_usuario == "Adm") {
                                    if ($status != 'resolvido') {
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'><button type='button' onclick=\"resolverSuporte(" . $linha['idsolicitacao_erro'] . ")\" class='btnAcao confirmar' title='Resolver'><i class='bi bi-check-lg'></i></button>";
                                        echo "</div></td>";
                                    } else {
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'><button type='button' class='btnAcao clipes' title='Concluído'><i class='bi bi-shield-fill'></i></button></td>";
                                    }
                                } else {
                                    echo "<td>---</td>";
                                }
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center; padding:15px;'>Nenhuma solicitação de suporte encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="div-btns-change">
            <button id="btn-ant" type="button"><i class="bi bi-chevron-left"></i></button>

            <button id="btn-prox" type="button"><i class="bi bi-chevron-right"></i></button>
        </div>

    </section>

    <script src="../../js/scripts.js" defer></script>
    <script src="../../js/processa.js" defer></script>
</body>

</html>