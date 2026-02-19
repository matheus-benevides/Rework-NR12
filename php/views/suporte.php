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

        <div class="div-header">
            <div class="div-img-header">
                <h2>Suporte</h2>
            </div>
            <div class="div-txt-header">
                <p>
                    <span id="msg_especial"></span> <?php echo $nome_usuario; ?>
                    <br>
                    <span>Esperamos que tenha uma ótima experiência em nosso sistema.</span>
                </p>
                <div class="avatar">
                    <i class="bi bi-person"></i>
                </div>
            </div>
        </div>

        <div class="div-btns-pages">

            <form action="" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <div>
                    <?php
                    $busca_atual = isset($_GET['search']) ? $_GET['search'] : '';
                    ?>
                    <input type="text" name="search" id="pesquisa" value="<?php echo htmlspecialchars($busca_atual); ?>"
                        placeholder="Pesquisar..." style="width: 1000%;">
                    <button type="submit" class="botao-acoes confirmar" style="width: 420px;"><i
                            class="bi bi-search"></i></button>
                    <?php if ($busca_atual): ?>
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="botao-acoes deletar" style="width: 420px"><i
                                class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                    <div class="filtrar-status">
                        <label for="">Status:</label>
                        <select id="select-filtro-turmas" name="filtro-status" onchange="filtrarTurmas()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoSuporte')">Solicitar Suporte <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>
                    <th>ID</th>
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
                <tbody id="tabela-turmas">
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
                                echo "<td>" . $linha["idsolicitacao_erro"] . "</td>";
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
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'>" . "<button type='button' onclick='showModal('resolverSuporte'," . $linha['idsolicitacao_erro'] . "' class='btnAcao confirmar'><i class='bi bi-check-lg'></i></button>";
                                        echo "<button type='button' class='btnAcao confirmar' onclick='showModal('observarSuporte'," . $linha['idsolicitacao_erro'] . "')'><i class='bi bi-eye-fill'></i></button>";
                                        echo "</div></td>";
                                    } else {
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'><button type='button' class='btnAcao clipes'><i class='bi bi-shield-fill'></i></button></td>";
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
                                echo "<td>" . $linha["idsolicitacao_erro"] . "</td>";
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
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'>" . "<button type='button' onclick='showModal('resolverSuporte'," . $linha['idsolicitacao_erro'] . "' class='btnAcao confirmar'><i class='bi bi-check-lg'></i></button>";
                                        echo "<button type='button' class='btnAcao confirmar' onclick='showModal('observarSuporte'," . $linha['idsolicitacao_erro'] . "')'><i class='bi bi-eye-fill'></i></button>";
                                        echo "</div></td>";
                                    } else {
                                        echo "<td><div style='display: flex; gap: 5px; justify-content: center;'><button type='button' class='btnAcao clipes'><i class='bi bi-shield-fill'></i></button></td>";
                                    }
                                } else {
                                    echo "<td><div style='display: flex; gap: 5px; justify-content: center;'><button type='button' class='btnAcao confirmar' onclick='showModal('observarSuporte'," . $linha['idsolicitacao_erro'] . "')'><i class='bi bi-eye-fill'></i></button></div></td>";
                                }
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center; padding:15px;'>Nenhuma turma encontrada.</td></tr>";
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
</body>

</html>