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
                        <select id="select-filtro-maquinas" name="filtro-status" onchange="filtrarMaquinas()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoMaquina')">Adicionar Máquina <i
                    class="bi bi-plus-circle"></i></button>
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
                    <th>N° Série</th>
                    <th>Ano</th>
                    <th>Setor</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-maquinas">
                    <?php
                    // Usando a conexão do banco de manutenção
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn_manutencao->real_escape_string($busca_atual);

                        $sql = "SELECT * FROM maquinas WHERE 
                                denominacao LIKE '%$termo_seguro%' OR 
                                marca LIKE '%$termo_seguro%' OR 
                                modelo LIKE '%$termo_seguro%' OR
                                numero_identificacao LIKE '%$termo_seguro%' OR
                                numero_serie LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT * FROM maquinas";
                    }

                    $resultado = $conn_manutencao->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["denominacao"] . "</td>";
                            echo "<td>" . $linha["marca"] . "</td>";
                            echo "<td>" . $linha["modelo"] . "</td>";
                            echo "<td>" . $linha["numero_identificacao"] . "</td>";
                            echo "<td>" . $linha["numero_serie"] . "</td>";
                            echo "<td>" . $linha["ano_fabricacao"] . "</td>";
                            echo "<td>" . $linha["setor"] . "</td>";

                            // Botões de Ação
                            echo "<td>
                                    <div>
                                        <button class='btnAcao editar' type='button' onclick=\"showModal('edicaoMaquina', " . $linha['id'] . ")\"><i class='bi bi-pencil-square'></i></button>
                                        <button class='btnAcao deletar' type='button' onclick=\"showModal('deletarMaquina', " . $linha['id'] . ",'')\"><i class='bi bi-trash'></i></button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center; padding:15px;'>Nenhuma máquina encontrada.</td></tr>";
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
