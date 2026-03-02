<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção - NR12</title>

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
                        <select id="select-filtro-manuntencao" name="filtro-status" onchange="filtrarManuntencao()">
                            <option value="todos">Todos</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <!-- Hidden submit button to allow Enter to search -->
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>
            <button class="btn" onclick="showModal('adicaoManutencao')">Adicionar Manutenção <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-wrench-adjustable"></i>
                <h2>Manutenção</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Data</th>
                    <th>Máquina</th>
                    <th>Colaborador</th>
                    <th>Estado</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Realizada</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-manuntencao">
                    <?php

                    if (!empty($busca_atual)) {

                        $termo_seguro = $conn->real_escape_string($busca_atual);

                        $sql = "SELECT 
                           mtn.*,
                           mq.maquina_modelo,
                           col.colaborador_nome
                       FROM manutencao mtn
                       INNER JOIN maquina mq
                           ON mtn.maquina_id = mq.idmaquina
                       INNER JOIN colaborador col
                           ON mtn.colaborador_id = col.idcolaborador
                       WHERE mtn.manutencao_estado LIKE '%$termo_seguro%'
                          OR mtn.tipo_manutencao LIKE '%$termo_seguro%'
                          OR col.colaborador_nome LIKE '%$termo_seguro%'";
                    } else {

                        $sql = "SELECT 
                           mtn.*,
                           mq.maquina_modelo,
                           col.colaborador_nome
                       FROM manutencao mtn
                       INNER JOIN maquina mq
                           ON mtn.maquina_id = mq.idmaquina
                       INNER JOIN colaborador col
                           ON mtn.colaborador_id = col.idcolaborador";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["manutencao_data"] . "</td>";
                            echo "<td>" . ($linha["maquina_modelo"] ?? 'Máquina não encontrada') . "</td>";
                            echo "<td>" . ($linha["colaborador_nome"] ?? 'Colaborador não encontrado') . "</td>";
                            echo "<td>" . $linha["manutencao_estado"] . "</td>";
                            echo "<td>" . $linha["manutencao_descricao"] . "</td>";
                            echo "<td>" . $linha["tipo_manutencao"] . "</td>";
                            echo "<td>" . $linha["manutencao_realizada"] . "</td>";

                            $status = strtolower($linha["manutencao_status"]);

                            if ($status == 'ativo') {
                                $classe = 'status-ativo';
                            } else {
                                $classe = 'status-inativo';
                            }

                            echo "<td><span class='$classe'>" . $linha["manutencao_status"] . "</span></td>";

                            // Botões de Ação
                            echo "<td>
                                    <div>
                                        <button class='btnAcao deletar' type='button' onclick=\"showModal('desativarManutencao', " . $linha['idmanutencao'] . ")\"><i class='bi bi-x-lg'></i></button>
                                        <button class='btnAcao deletar' type='button' onclick=\"showModal('deletarManutencao', " . $linha['idmanutencao'] . ",'')\"><i class='bi bi-trash'></i></button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center; padding:15px;'>Nenhuma turma encontrada.</td></tr>";
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