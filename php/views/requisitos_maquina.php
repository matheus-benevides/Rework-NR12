<?php require "../controllers/validar_acesso.php"; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitos - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link rel="stylesheet" href="../../css/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/icons/favicon.ico" type="image/x-icon">
</head>

<body>

    <?php require '../components/nav.php'; ?>

    <section class="sec-main dontmove" style="align-items: center; justify-content: center;">
        
        <div class="modal-box" style="width: 50em; height: auto">
            <div class="modal-header">
                <h3>Relacionar Requisitos</h3>
            </div>

            <form id="form-suporte" class="modal-form">

                <div class="modal-row">
                    <div class="modal-input">
                        <label for="filtro">Filtrar por Tipo de Requisitos: </label>
                        <div class="input-wrapper">
                            <select name="filtro" id="filtro">
                                <option value="Todos" selected>Todos</option>
                                <option value="Seguranca">Segurança</option>
                                <option value="Operacional">Operacional</option>
                                <option value="Operacional">Preventivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-input">
                        <label for="pesquisa">Pesquisar por Nome: </label>
                        <div class="input-wrapper">
                            <input type="text" name="pesquisa" id="pesquisa">
                        </div>
                    </div>
                </div>

                <div class="modal-row">
                    <div class="modal-input">
                        <label for="tipo">Tipo de Máquina: </label>
                        <div class="input-wrapper">
                            <select name="tipo" id="tipo">
                                <option value="">Selecione...</option>
                                <?php
                                    $sql = "SELECT idtipomaquina, tipomaquina_nome FROM tipomaquina ORDER BY tipomaquina_nome";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    
                                    if ($result->num_rows > 0) {
                                        while ($resultado = $result->fetch_assoc()) {
                                            echo '<option value="'.$resultado['idtipomaquina'].'">'.$resultado['tipomaquina_nome'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-input">
                        <label for="requisitos">Requisitos: </label>
                        <div class="input-wrapper">
                            <select name="requisitos" id="requisitos">
                                <option value="">Selecione...</option>

                                
                                <?php
                                /*CREATE TABLE requisitos (
  idrequisitos int(11) NOT NULL,
  requisito_topico varchar(255) NOT NULL,
  tipo_req enum('Seguranca','Operacional','Preventivo') NOT NULL,
  requisitos_status enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;*/
                                    $sql = "SELECT idtipomaquina, tipomaquina_nome FROM tipomaquina ORDER BY tipomaquina_nome";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    
                                    if ($result->num_rows > 0) {
                                        while ($resultado = $result->fetch_assoc()) {
                                            echo '<option value="'.$resultado['idtipomaquina'].'">'.$resultado['tipomaquina_nome'].'</option>';
                                        }
                                    }
                                ?>
                              
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-row">
                    <div class="modal-input">
                        <label for="funcao">Função: </label>
                        <div class="input-wrapper">
                            <input type="text" name="funcao" id="funcao" disabled value="<?php echo $permissao_usuario; ?>">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-confirmar-full deletar" onclick="window.location.href='../actions/logout.php'">
                        Sair <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>