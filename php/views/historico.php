<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Historico - NR12</title>

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

        <div class="div-header">
            <div class="div-img-header">
                <h2>Painel de Controle de Logs</h2>
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

        <div class="div-btns-pages logs-div">
            <form action="" method="GET">
                <div style="width: 75.5dvw;">
                    <?php
                    $busca_atual = isset($_GET['search']) ? $_GET['search'] : '';
                    ?>
                    <input type="text" name="search" id="pesquisa" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar por nome, IP ou comando...">
                    <button type="submit" class="botao-acoes confirmar"><i class="bi bi-search"></i></button>
                    <?php if ($busca_atual): ?>
                        <a href="log.php" class="botao-acoes deletar"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="tabela-bg2">
            <table class="tabela-main">
                <thead>
                    <th>ID</th>
                    <th>Máquina (NI)</th>
                    <th>Aluno</th>
                    <th>Colaborador</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Requisitos</th>
                </thead>
                <tbody id="tabela-historico">
                    <?php
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $sql = "SELECT h.*, a.aluno_nome 
                                FROM historico h 
                                LEFT JOIN aluno a ON h.aluno_id = a.idaluno 
                                WHERE h.historicoid LIKE '%$termo_seguro%' OR 
                                      h.historico_status LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT 
                                    h.*,
                                    a.aluno_nome,
                                    c.colaborador_nome
                                FROM historico h
                                LEFT JOIN aluno a 
                                    ON h.aluno_id = a.idaluno
                                INNER JOIN colaborador c 
                                    ON h.colaborador_id = c.idcolaborador;
                                ";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["historicoid"] . "</td>";
                            echo "<td>" . $linha["maquina_id"] . "</td>";

                            if (isset($linha["aluno_nome"])) {
                                echo "<td>" . $linha["aluno_nome"] . "</td>";
                            } else {
                                echo "<td>Erro: Nome não veio</td>";
                            }

                            echo "<td>" . $linha["colaborador_nome"] . "</td>";
                            echo "<td>" . $linha["historico_data"] . "</td>";
                            echo "<td>" . $linha["historico_hora"] . "</td>";
                            echo "<td>" . $linha["requisito_id"] . "</td>";
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

    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>