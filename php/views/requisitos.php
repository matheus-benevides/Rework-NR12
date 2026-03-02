<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitos - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">

</head>

<body>
    <?php require '../components/nav.php'; ?>

    <section class="sec-main">

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
                        <label for="">Tipo:</label>
                        <select id="select-filtro-tipo" name="filtro-tipo" onchange="filtrarRequisito()">
                            <option value="todos">Todos</option>
                            <option value="seguranca">Segurança</option>
                            <option value="operacional">Operacional</option>
                            <option value="preventivo">Preventivo</option>
                        </select>
                    </div>
                    <div class="filtrar-status">
                        <label for="">Status:</label>
                        <select id="select-filtro-requisito" name="filtro-status" onchange="filtrarRequisito()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoRequisito')">Adicionar Requisito <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-journal-check"></i>
                <h2>Requisitos</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Tópico</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-requisitos">
                    <?php

                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);

                        $sql = "SELECT * FROM requisitos WHERE 
                                requisito_topico LIKE '%$termo_seguro%' OR 
                                tipo_req LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT * FROM requisitos";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["requisito_topico"] . "</td>";
                            echo "<td>" . $linha["tipo_req"] . "</td>";

                            $status = strtolower($linha["requisitos_status"]);

                            if ($status == 'ativo') {
                                $classe = 'status-ativo';
                            } else {
                                $classe = 'status-inativo';
                            }

                            echo "<td><span class='$classe'>" . $linha["requisitos_status"] . "</span></td>";
                            // Botões de Ação
                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' type='button' onclick=\"showModal('edicaoRequisito', " . $linha['idrequisitos'] . ")\"><i class='bi bi-pencil-square'></i></button>";

                            if ($status == 'ativo') {
                                echo "<button class='btnAcao deletar' type='button' onclick=\"showModal('deletarRequisito', " . $linha['idrequisitos'] . ")\"><i class='bi bi-trash'></i></button>";
                            } else {
                                echo "<button class='btnAcao confirmar' type='button' onclick=\"showModal('ativarRequisito', " . $linha['idrequisitos'] . ")\" style='background-color: var(--confirmar);'><i class='bi bi-check-circle'></i></button>";
                            }

                            echo "  </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center; padding:15px;'>Nenhum requisito encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <div class="div-btns-change">
                <button id="btn-ant" type="button"><i class="bi bi-chevron-left"></i></button>
                <button id="btn-prox" type="button"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>

    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>