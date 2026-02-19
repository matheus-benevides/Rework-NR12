<?php
require_once("../configs/conexao.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NR12 - Requisitos Máquinas</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<?php 
    $requisito_associados = []
?>
<body>

    <div class="modal-fundo">
        <h1 id="titulo">Associar Requisitos a tipo de Máquinas</h1>
        <div class="container-requisitos">
            <form action="" method="POST">
                <label for="">Filtrar por tipo de requisito:</label>
                <select name="select-requisitos" id="select-requisitos">
                    <option value="Todos">Todos</option>
                    <option value="Segurança">Segurança</option>
                    <option value="Operacional">Operacional</option>
                    <option value="Preventivo">Preventivo</option>
                </select>
                <br><br>
                <label for="nome-requisito">Pesquisar por nome do requisito:</label>
                <input type="text" name="nome-req" id="nome-req" placeholder="Digite o nome do requisito...">
                <br><br>
                <label for="tipo-maquina">
                    <select name="select-tipo-maquina" id="select-tipo-maquina">
                        <option value="" disabled selected>Selecione uma máquina...</option>
                        <?php
                        $sql = "SELECT 
                                    m.idmaquina,
                                    m.maquina_ni,
                                    t.tipomaquina_nome 
                                FROM maquina m
                                INNER JOIN tipomaquina t ON t.idtipomaquina = m.tipomaquina_id
                                ORDER BY m.maquina_ni ASC";

                        $stmt = $conn->prepare($sql);

                        if ($stmt) {
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $nome_exibicao = $row['maquina_ni'] . ' (Tipo: ' . $row['tipomaquina_nome'] . ')';
                                echo '<option value="' . $row['idmaquina'] . '">' . htmlspecialchars($nome_exibicao) . '</option>';
                            }
                            $stmt->close();
                        } else {
                            echo '<option value="">Erro: ' . $conn->error . '</option>';
                        }
                        ?>
                    </select>
                </label>
                <div class="checklist-requisito">
                    <?php foreach ($requisitos as $requisito): ?>
                        <label for="">
                            <input type="checkbox" name="check-requisitos[]" value="<?php $requisito['idrequisitos'] ?>
                            <?=(in_array($requisito, $requisito_associados)) ? 'checked' : '' ?>">
                            <?= htmlspecialchars($requisito['requisito_topico']) ?>
                        </label>     
                <?php endforeach; ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>