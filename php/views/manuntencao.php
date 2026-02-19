<?php require '../controllers/validar_acesso.php'; ?>
<?php require '../configs/conexao.php'; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Manuntenção - NR12</title>

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

        <div class="div-header">
            <div class="div-img-header">
                <h2>Painel de Manuntenção</h2>
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

        <div class="div-btns-pages">

            <form action="" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <div class="box-pesquisar">
                    <?php
                    // Captura o valor atual para manter no input
                    $busca_atual = isset($_GET['search']) ? $_GET['search'] : '';
                    ?>
                    <input type="text" name="search" id="pesquisa" value="<?php echo htmlspecialchars($busca_atual); ?>"
                        placeholder="Pesquisar..." style="width: 1000%;">
                    <button type="submit" class="botao-acoes confirmar" style="width: 420px;"><i class="bi bi-search"></i></button>
                    <?php if ($busca_atual): ?>
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="botao-acoes deletar" style="width: 420px;"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                    <div class="filtrar-status">

                        </select>
                    </div>
                </div>
            </form>

            <button class="btn" onclick="showModal('adicaoSetor')">Adicionar Manutenção <i
                    class="bi bi-plus-circle"></i></button>
        </div>

        <div class="tabela-bg2">
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
                <tbody id="tabela-setores">
                    <?php

                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);

                        $sql = "SELECT * FROM manutencao WHERE 
                                setor_nome LIKE '%$termo_seguro%'";
                    } else {
                        $sql = "SELECT * FROM manutencao ";
                    }

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha["manutencao_data"] . "</td>";
                            echo "<td>" . $linha["maquina_id"] . "</td>";
                            echo "<td>" . $linha["colaborador_id"] . "</td>";
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
                                        <button class='btnAcao editar' type='button' onclick=\"showModal('editarManuntencao', " . $linha['idmanutencao'] . ")\"><i class='bi bi-pencil-square'></i></button>
                                        <button class='btnAcao deletar' type='button' onclick=\"showModal('excluirManuntencao', " . $linha['idmanutencao'] . ",'')\"><i class='bi bi-trash'></i></button>
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

    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>