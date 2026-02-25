<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Unidades - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">
    <link rel="stylesheet" href="../../css/bootstrap-like.css">

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
                        <input type="text" name="search" id="pesquisa" value="<?php echo htmlspecialchars($busca_atual); ?>"
                            placeholder="Pesquisar..." class="input-pesquisa">
                        
                        <?php if ($busca_atual): ?>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn-clear-search"><i class="bi bi-x-lg"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="filtrar-status">
                        <label for="">Status:</label>
                        <select id="select-filtro-unidade" name="filtro-status" onchange="filtrarUnidade()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoUnidade')">Adicionar Unidade <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Número</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-unidade">
                    <?php
                    $sql = "SELECT idunidade, unidade_nome, unidade_cidade, unidade_estado, unidade_numero, unidade_status FROM unidade";

                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $sql .= " WHERE idunidade LIKE '%$termo_seguro%' OR unidade_nome LIKE '%$termo_seguro%' OR unidade_cidade LIKE '%$termo_seguro%' OR unidade_estado LIKE '%$termo_seguro%' OR unidade_numero LIKE '%$termo_seguro%' OR unidade_status LIKE '%$termo_seguro%'";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["unidade_nome"] . "</td>";
                            echo "<td>" . $linha["unidade_cidade"] . "</td>";
                            echo "<td>" . $linha["unidade_estado"] . "</td>";
                            echo "<td>" . ($linha["unidade_numero"] ?? '-') . "</td>";

                            $status = strtolower($linha["unidade_status"]);
                            $classe = ($status == 'ativo') ? 'status-ativo' : 'status-inativo';
                            echo "<td><span class='$classe'>" . $linha["unidade_status"] . "</span></td>";

                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' type='button' 
                                            onclick=\"abrirModalEdicaoUnidade(" . $linha['idunidade'] . ", '" . addslashes($linha['unidade_nome']) . "', '" . addslashes($linha['unidade_cidade']) . "', '" . addslashes($linha['unidade_estado']) . "', '" . addslashes($linha['unidade_numero']) . "')\">
                                            <i class='bi bi-pencil-square'></i>
                                        </button>";

                            if ($status == 'ativo') {
                                echo "<button class='btnAcao deletar' type='button' onclick=\"showModal('desativarUnidade', " . $linha['idunidade'] . ")\"><i class='bi bi-x-lg'></i></button>";
                            } else {
                                echo "<button class='btnAcao confirmar' type='button' style='background-color: #28a745;' onclick=\"showModal('ativarUnidade', " . $linha['idunidade'] . ")\"><i class='bi bi-check-lg'></i></button>";
                            }

                            echo "</div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center; padding:15px;'>Nenhuma unidade encontrada.</td></tr>";
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

    <script src="../../js/processa.js" defer></script>
    <script src="../../js/scripts.js" defer></script>
</body>

</html>