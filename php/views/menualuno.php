<?php require "../controllers/validar_acesso.php"; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Aluno - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/icons/favicon.ico" type="image/x-icon">
</head>

<body>

    <section class="sec-main dontmove" style="padding: 0; margin: 0; align-items: center; justify-content: center;">

        <div class="modal-box">
            <div class="modal-header">
                <h3>Olá <?php echo $nome_usuario ?></h3>
            </div>

            <form id="form-suporte" class="modal-form">

                <div class="modal-row">
                    <label style="color: var(--corDestaque);">Turma: <?php
                                    // 1. Busca a Turma
                                    $sqlBusca = "SELECT * FROM turmas WHERE idturmas = ?";
                                    $stmt = $conn->prepare($sqlBusca);
                                    $stmt->bind_param("i", $turma_usuario);
                                    $stmt->execute();
                                    $resultado = $stmt->get_result();

                                    if ($linha = $resultado->fetch_assoc()) {
                                        // Exibe o nome da turma (certifique-se se é 'turma_nome' ou 'turmas_nome' no seu banco)
                                        echo "Turma: " . ($linha['turma_nome'] ?? $linha['turmas_nome']);

                                        $curso_id = $linha['curso_id'];

                                        // 2. Busca o Curso (usando nomes de variáveis diferentes para não confundir)
                                        $sqlCurso = "SELECT * FROM curso WHERE idcurso = ?";
                                        $stmtCurso = $conn->prepare($sqlCurso);
                                        $stmtCurso->bind_param("i", $curso_id);
                                        $stmtCurso->execute();

                                        // O QUE FALTOU: Criar o $resultado2
                                        $resultado2 = $stmtCurso->get_result();

                                        if ($linha2 = $resultado2->fetch_assoc()) {
                                            echo " - Curso: " . $linha2['curso_nome'];
                                        } else {
                                            echo " - Curso não encontrado";
                                        }
                                    } else {
                                        echo "Turma não encontrada";
                                    }
                                    ?>
                    </label>
                </div>
                <div class="modal-row">
                    <label for="" style="color: var(--corDestaque);">NI Máquina:
                        <?php
                        // 1. Busca os dados da Máquina (Note que o nome da tabela na imagem é 'maquina' e não 'maquinas')
                        // Usamos o 'idmaquina' para buscar, que deve estar na sua variável de sessão ou vindo de um POST
                        $sqlMaq = "SELECT * FROM maquina WHERE idmaquina = ?";
                        $stmtMaq = $conn->prepare($sqlMaq);
                        $stmtMaq->bind_param("i", $id_maquina); // Usando o ID da sessão que configuramos antes
                        $stmtMaq->execute();
                        $resMaq = $stmtMaq->get_result();

                        if ($linhaMaq = $resMaq->fetch_assoc()) {
                            // Exibe o NI da Máquina
                            echo $linhaMaq['maquina_ni'];

                            // 2. Busca o Tipo de Máquina usando a chave estrangeira 'tipomaquina_id'
                            $idTipo = $linhaMaq['tipomaquina_id'];
                            $sqlTipo = "SELECT tipomaquina_nome FROM tipomaquina WHERE idtipomaquina = ?";
                            $stmtTipo = $conn->prepare($sqlTipo);
                            $stmtTipo->bind_param("i", $idTipo);
                            $stmtTipo->execute();
                            $resTipo = $stmtTipo->get_result();

                            if ($linhaTipo = $resTipo->fetch_assoc()) {
                                echo " - Tipo: " . $linhaTipo['tipomaquina_nome'];
                            } else {
                                echo " - Tipo não identificado";
                            }
                        } else {
                            echo "Dados da máquina não encontrados.";
                        }
                        ?>
                    </label>
                </div>

                <div class="modal-row">
                    <div class="modal-input">
                        <label for="">Pressione a opção que deseja</label>
                        <div class="input-wrapper" style="display: flex; justify-content: space-between">
                            <button type="button" onclick="showModal('checkOperacional')" class="btn-confirmar-metade clipes" style="width: 49%">Checklist Operacional <i class="bi bi-plus-lg"></i></button>
                            <button type="button" onclick="showModal('checkSeguranca')" class="btn-confirmar-metade clipes" style="width: 49%">Checklist de Segurança<i class="bi bi-plus-lg"></i></button>
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