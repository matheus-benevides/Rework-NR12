<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Alunos - NR12</title>

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
                        <select id="select-filtro-alunos" name="filtro-status" onchange="filtrarAlunos()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoAluno')">Adicionar Aluno <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Matrícula</th>
                    <th>Turmas</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-alunos">
                    <?php
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $sql = "SELECT a.*, t.turma_nome 
                                FROM aluno a
                                LEFT JOIN turmas t ON a.turmas_id = t.idturmas
                                WHERE a.aluno_nome LIKE '%$termo_seguro%' 
                                OR a.aluno_matricula LIKE '%$termo_seguro%' 
                                OR a.turmas_id LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT a.*, t.turma_nome 
                                FROM aluno a
                                LEFT JOIN turmas t ON a.turmas_id = t.idturmas";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["aluno_nome"] . "</td>";
                            echo "<td>" . ($linha["aluno_email"] ?? "<span style='color: var(--corBordas); font-style: italic;'>Não informado</span>") . "</td>";
                            echo "<td>" . $linha["aluno_matricula"] . "</td>";

                            $nome_turma = !empty($linha["turma_nome"]) ? $linha["turma_nome"] : "<span style='color: #999; font-style: italic;'>Sem turma</span>";
                            echo "<td>" . $nome_turma . "</td>";

                            $status = strtolower($linha["aluno_status"]);
                            $classe = ($status == 'ativo') ? 'status-ativo' : 'status-inativo';

                            echo "<td><span class='$classe'>" . $linha["aluno_status"] . "</span></td>";
                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' type='button' onclick=\"abrirModalEdicaoAluno(" . $linha['idaluno'] . ", '" . addslashes($linha['aluno_nome']) . "', '" . addslashes($linha['aluno_email']) . "', '" . $linha['aluno_matricula'] . "', " . $linha['turmas_id'] . ")\"><i class='bi bi-pencil-square'></i></button>";

                            if (strtolower($linha['aluno_status']) == 'ativo') {
                                echo "<button class='btnAcao deletar' type='button' onclick=\"showModal('desativarAluno', " . $linha['idaluno'] . ")\"><i class='bi bi-x-lg'></i></button>";
                            } else {
                                echo "<button class='btnAcao confirmar' type='button' style='background-color: var(--confirmar);' onclick=\"showModal('ativarAluno', " . $linha['idaluno'] . ")\"><i class='bi bi-check-lg'></i></button>";
                            }

                            echo "<button class='btnAcao deletar' type='button' style='background-color: red;' onclick=\"showModal('deletarAluno', " . $linha['idaluno'] . ")\"><i class='bi bi-trash'></i></button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding:15px;'>Nenhum aluno encontrado.</td></tr>";
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