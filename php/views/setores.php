<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

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
                        <label for="">Status:</label>
                        <select id="select-filtro-setor" name="filtro-status" onchange="filtrarSetor()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoSetor')">Adicionar Setor <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>

                    <th>Nome</th>
                    <th>Unidade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-setores">
                    <?php
                    // 1. Define a query base com o JOIN
                    $sql = "SELECT 
                              setor.idsetor,
                              setor.setor_nome, 
                              setor.unidade_id,
                              unidade.unidade_nome,
                              setor.setor_status
                          FROM setor 
                          LEFT JOIN unidade ON setor.unidade_id = unidade.idunidade";

                    // 2. Se houver busca, adiciona o filtro WHERE ao final da query
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $sql .= " WHERE setor.idsetor LIKE '%$termo_seguro%' OR setor.setor_nome LIKE '%$termo_seguro%' OR unidade.unidade_nome LIKE '%$termo_seguro%' OR setor.setor_status LIKE '%$termo_seguro%'";
                    }

                    // 3. Executa a query
                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";

                            echo "<td>" . $linha["setor_nome"] . "</td>";
                            echo "<td>" . $linha["unidade_nome"] . "</td>";

                            $status = strtolower($linha["setor_status"]);
                            $classe = ($status == 'ativo') ? 'status-ativo' : 'status-inativo';
                            echo "<td><span class='$classe'>" . ($linha["setor_status"] ? $linha["setor_status"] : 'Ativo') . "</span></td>";

                            // Botões de Ação
                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' type='button' 
                                            onclick=\"abrirModalEdicaoSetor(" . $linha['idsetor'] . ", '" . addslashes($linha['setor_nome']) . "', '" . $linha['unidade_id'] . "')\">
                                            <i class='bi bi-pencil-square'></i>
                                        </button>";

                            if ($status == 'inativo') {
                                echo "<button class='btnAcao confirmar' type='button' style='background-color: #28a745;' onclick=\"showModal('ativarSetor', " . $linha['idsetor'] . ")\"><i class='bi bi-check-lg'></i></button>";
                            } else {
                                echo "<button class='btnAcao deletar' type='button' onclick=\"showModal('desativarSetor', " . $linha['idsetor'] . ")\"><i class='bi bi-x-lg'></i></button>";
                            }

                            echo "</div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        // Colspan ajustado para 5
                        echo "<tr><td colspan='5' style='text-align:center; padding:15px;'>Nenhum setor encontrado.</td></tr>";
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
    <script src="../../js/processa_lotes.js" defer></script>
</body>

</html>