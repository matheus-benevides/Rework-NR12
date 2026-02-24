<?php require "../controllers/validar_acesso.php"; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - NR12</title>

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

    <section class="sec-main">

        <?php require '../components/header.php'; ?>

        <div class="card-box1">
            <div class="card-box-filho">
                <h1>Bem-vindo ao Sistema NR12</h1>
                <p>Este sistema foi desenvolvido para otimizar o processo de realização de checklists de máquinas, atendendo à norma NR12. Substituímos os formulários em papel por uma solução digital prática e eficiente, especialmente projetada para os alunos do SENAI. Para realizar o checklist antes de utilizar uma máquina, basta acessar o sistema com sua matrícula e NI. Tudo foi pensado para tornar o processo mais
                    simples e garantir a segurança no ambiente de aprendizado.</p>
            </div>

            <div class="card-box-filho">
                <h1>Sobre a Norma NR12</h1>
                <p>NR-12 é uma Norma Regulamentadora (NR) que estabelece requisitos mínimos de segurança no trabalho com máquinas e equipamentos. A NR-12 é obrigatória para organizações e órgãos públicos que utilizem máquinas e equipamentos e tenham empregados regidos pela Consolidação das Leis do Trabalho.</p>
            </div>
        </div>

    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>