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
                        <input type="text" name="search" id="pesquisa" value="<?php echo htmlspecialchars($busca_atual); ?>"
                            placeholder="Pesquisar..." class="input-pesquisa">
                        
                        <?php if ($busca_atual): ?>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn-clear-search"><i class="bi bi-x-lg"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="filtrar-status">
                        <label for="">Status:</label>
                        <select id="select-filtro-turmas" name="filtro-status" onchange="filtrarTurmas()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoTurma')">Adicionar Turma <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>
                    <th>Turma</th>
                    <th>Período</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Nome do Curso</th>
                    <th>Colaborador</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-turmas">
                    <?php
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);

                        $sql = "SELECT t.*, c.colaborador_nome, cs.curso_nome 
                                FROM turmas t
                                LEFT JOIN colaborador c ON t.colaborador_id = c.idcolaborador
                                LEFT JOIN curso cs ON t.curso_id = cs.idcurso
                                WHERE t.turma_nome LIKE '%$termo_seguro%' OR 
                                      t.turma_periodo LIKE '%$termo_seguro%' OR 
                                      cs.curso_nome LIKE '%$termo_seguro%' OR
                                      c.colaborador_nome LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT t.*, c.colaborador_nome, cs.curso_nome 
                                FROM turmas t
                                LEFT JOIN colaborador c ON t.colaborador_id = c.idcolaborador
                                LEFT JOIN curso cs ON t.curso_id = cs.idcurso";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["turma_nome"] . "</td>";
                            echo "<td>" . $linha["turma_periodo"] . "</td>";
                            echo "<td>" . $linha["turma_inicio"] . "</td>";
                            echo "<td>" . $linha["turma_fim"] . "</td>";
                            echo "<td>" . $linha["curso_nome"] . "</td>";
                            echo "<td>" . $linha["colaborador_nome"] . "</td>";

                            $status = strtolower($linha["turmas_status"]);

                            if ($status == 'ativo') {
                                $classe = 'status-ativo';
                            } else {
                                $classe = 'status-inativo';
                            }

                            echo "<td><span class='$classe'>" . $linha["turmas_status"] . "</span></td>";

                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' type='button' onclick=\"abrirModalEdicaoTurma(" . $linha['idturmas'] . ", '" . addslashes($linha['turma_nome']) . "', '" . $linha['turma_periodo'] . "', " . $linha['colaborador_id'] . ", '" . $linha['turma_inicio'] . "', '" . $linha['turma_fim'] . "', " . $linha['curso_id'] . ")\"><i class='bi bi-pencil-square'></i></button>";

                            if ($status == 'ativo') {
                                echo "<button class='btnAcao deletar' type='button' onclick=\"showModal('deletarTurma', " . $linha['idturmas'] . ")\"><i class='bi bi-x-lg'></i></button>";
                            } else {
                                echo "<button class='btnAcao confirmar' type='button' onclick=\"showModal('ativarTurma', " . $linha['idturmas'] . ")\"><i class='bi bi-check-lg'></i></button>";
                            }

                            echo "    </div>
                                  </td>";
                            echo "</tr>";
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

    <script src="../../js/processa.js" defer></script>
    <script src="../../js/scripts.js" defer></script>
</body>

</html>