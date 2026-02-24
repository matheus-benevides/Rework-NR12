<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

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
                        <select id="select-filtro-colaboradores" name="filtro-status" onchange="filtrarColaboradores()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoColaborador')">Adicionar Colaborador <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>NIF</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Setor</th>
                    <th>Status</th>
                    <th>Permissão</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-colaboradores">
                    <?php
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $sql = "SELECT c.*, s.setor_nome 
                                FROM colaborador c
                                LEFT JOIN setor s ON s.idsetor = c.setor_id
                                WHERE c.idcolaborador LIKE '%$termo_seguro%' 
                                OR c.colaborador_nome LIKE '%$termo_seguro%' 
                                OR c.colaborador_status LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT c.*, s.setor_nome 
                                FROM colaborador c
                                LEFT JOIN setor s ON s.idsetor = c.setor_id";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["idcolaborador"] . "</td>";
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
                                echo "<button class='btnAcao ferramentas' title='Desativar' type='button' onclick=\"showModal('desativarColaborador', " . $linha['idcolaborador'] . ")\"><i class='bi bi-x-lg'></i></button>";
                            } else {
                                echo "<button class='btnAcao clipes' style='background-color: var(--corSuccess);' title='Ativar' type='button' onclick=\"showModal('ativarColaborador', " . $linha['idcolaborador'] . ")\"><i class='bi bi-check-lg'></i></button>";
                            }

                            echo "  </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center; padding:15px;'>Nenhum colaborador encontrado.</td></tr>";
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