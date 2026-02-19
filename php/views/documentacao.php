<?php require "../controllers/validar_acesso.php"; ?>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/icons/favicon.ico" type="image/x-icon">
</head>

<body>
    <?php require '../components/nav.php'; ?>

    <section class="sec-main">

        <div class="div-header">
            <div class="div-img-header">
                <h2>Documentação da NR12</h2>
            </div>
            <div class="div-txt-header">
                <p>

                </p>

            </div>
        </div>

        <div class="card-box1">
            <div class="card-box-filho">
                <h1>O que é a NR12? </h1>
                <p>A NR12 é uma norma regulamentadora que estabelece referências técnicas para garantir a segurança no trabalho em máquinas e equipamentos. Seu objetivo é prevenir acidentes e doenças ocupacionais, assegurando um ambiente de trabalho seguro.</p>
            </div>

            <div class="card-box-filho">
                <h1>Sobre a Norma NR12</h1>
                <p>NR-12 é uma Norma Regulamentadora (NR) que estabelece requisitos mínimos de segurança no trabalho com máquinas e equipamentos. A NR-12 é obrigatória para organizações e órgãos públicos que utilizem máquinas e equipamentos e tenham empregados regidos pela Consolidação das Leis do Trabalho.</p>
            </div>

            <div class="card-box-filho">
                <h1>Objetivos da NR12</h1>
                <ul>
                    <li>Proteger a saúde e a integridade física dos trabalhadores;</li>
                    <li>Estabelecer requisitos para a utilização segura de máquinas e equipamentos;</li>
                    <li>Promover a melhoria das condições de trabalho.</li>
                </ul>
            </div>

        </div>

        <form action="download.php" method="POST">
        <div class="div-botao">
            <button class="btn-document" onclick="">Baixar documento</button>
        </div>
        </form>
           <form action="" method="POST">
        <div class="div-botao">
            <button class="btn-document" onclick="">Baixar documento</button>
        </div>
        </form>
        
    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>