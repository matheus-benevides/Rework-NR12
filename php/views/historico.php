<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">

</head>

<body>
    <?php require '../components/nav.php'; ?>

    <section class="sec-main">

        <?php require '../components/header.php'; ?>

        <div class="div-btns-pages">
            <form action="" method="GET" class="form-pesquisa">
                <div class="search-container">
                    <?php
                    $busca_atual = isset($_GET['search']) ? $_GET['search'] : '';
                    ?>
                    <div class="box-pesquisa">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" id="pesquisa"
                            value="<?php echo htmlspecialchars($busca_atual); ?>"
                            placeholder="Pesquisar máquina, NI, aluno ou colaborador..." class="input-pesquisa">

                        <?php if ($busca_atual): ?>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn-clear-search"><i
                                    class="bi bi-x-lg"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="filtrar-status">
                        <label for="">Status:</label>
                        <select id="select-filtro-status" name="filtro-status"
                            onchange="filtrarTabela('tabela-historico', 6)">
                            <option value="todos">Todos</option>
                            <option value="checkado">Checkado</option>
                            <option value="nao-checkado">Não Checkado</option>
                        </select>
                    </div>
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-clock-history"></i>
                <h2>Histórico</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Máquina (NI)</th>
                    <th>Aluno</th>
                    <th>Colaborador</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Requisito</th>
                    <th>Status</th>
                </thead>
                <tbody id="tabela-historico">
                    <?php
                    $sql = "SELECT 
                                h.*,
                                a.aluno_nome,
                                c.colaborador_nome,
                                m.maquina_modelo,
                                m.maquina_ni,
                                r.requisito_topico
                            FROM historico h
                            LEFT JOIN aluno a ON h.aluno_id = a.idaluno
                            LEFT JOIN colaborador c ON h.colaborador_id = c.idcolaborador
                            LEFT JOIN maquina m ON h.maquina_id = m.idmaquina
                            LEFT JOIN requisitos r ON h.requisito_id = r.idrequisitos";

                    if (!empty($busca_atual)) {
                        $termo = $conn->real_escape_string($busca_atual);
                        $sql .= " WHERE m.maquina_modelo LIKE '%$termo%' 
                                   OR m.maquina_ni LIKE '%$termo%' 
                                   OR a.aluno_nome LIKE '%$termo%' 
                                   OR c.colaborador_nome LIKE '%$termo%'";
                    }

                    $sql .= " ORDER BY h.historico_data DESC, h.historico_hora DESC";

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            $data_br = date('d/m/Y', strtotime($linha["historico_data"]));
                            $hora_br = date('H:i', strtotime($linha["historico_hora"]));
                            $status = $linha["historico_status"];
                            $classe_status = (strtolower($status) == 'checado') ? 'status-ativo' : 'status-inativo';

                            echo "<tr>";
                            echo "<td>" . ($linha["maquina_modelo"] ?? 'N/A') . " (" . ($linha["maquina_ni"] ?? '-') . ")</td>";
                            echo "<td>" . ($linha["aluno_nome"] ?? '<span style="opacity:0.5">N/A</span>') . "</td>";
                            echo "<td>" . ($linha["colaborador_nome"] ?? 'N/A') . "</td>";
                            echo "<td>" . $data_br . "</td>";
                            echo "<td>" . $hora_br . "</td>";
                            echo "<td>" . ($linha["requisito_topico"] ?? 'ID: ' . $linha["requisito_id"]) . "</td>";
                            echo "<td><span class='$classe_status'>$status</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center; padding:15px;'>Nenhum registro encontrado.</td></tr>";
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