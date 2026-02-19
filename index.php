<?php require "php/components/modals/acesso_negado.php"; ?>
<!DOCTYPE html>
<html lang="pt-br" data-tema="">
<!-- NÃO TIRA O DATA-TEMA DE JEITO NENHUM -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SENAI MANUTENÇÃO</title>

    <!-- Estilização, BootstrapIcons e Favicon -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">

    <!-- Biblioteca do QRCODE -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<body class="body_login">

    <?php
    if (isset($_GET['erro'])) {
        if ($_GET['erro'] == 'email') {
            $erro = "<div class='div-msg-erro'><p>E-mail não encontrado! Tente novamente</p></div>";
        } else if ($_GET['erro'] == 'senha') {
            $erro = "<div class='div-msg-erro'><p>Senha incorreta! Tente novamente</p></div>";
        } else if ($_GET['erro'] == "maquinaNM") {
            $erro = "<div class='div-msg-erro'><p>Máquina não encontrada ou em manutenção.</p></div>";
        } else if ($_GET['erro'] == "maquinaN") {
            $erro = "<div class='div-msg-erro'><p>Matrícula não encontrada.</p></div>";
        }
    }
    ?>

    <div class="login-bg">
        <div class="login-box">
            <form class="login-form" action="php/actions/auth_login.php" method="POST">
                <div class="div-img" id="">
                    <img src="assets/imgs/senailogo1.png" alt="Logo Senai" id="senai-logo" style="width: 70%;">
                </div>
                <?php if (isset($erro)) echo $erro; ?>
                <div class="div-inputs-chefe">
                    <div class="div-input">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" id="email" name="email" placeholder="E-mail" class="input">
                        <button type="button" style="visibility: hidden;" id="btnScan1" class="btnEsp"><i class="bi bi-qr-code-scan"></i></button>
                    </div>
                    <div class="div-input">
                        <i class="bi bi-shield-fill"></i>
                        <input type="password" id="senhaLogin" name="senha" placeholder="*****" class="input">
                        <button type="button" onclick="showPass()" id="btnEyeLogin" class="btnEsp"><i class="bi bi-eye-fill"></i></button>
                    </div>

                    <div class="div-btn">
                        <button type="submit" class="btn">Entrar <i class="bi bi-box-arrow-in-right"></i></button>
                        <button type="button" id="trocarForm" onclick="trocarForm1()">Entrar como aluno</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="modal-fundo" id="reader-container">
        <div class="modal-cam">
            <div id="reader"></div>
            <button type="button" onclick="fecharScanner()" class="btn">Fechar</button>
        </div>
    </div>

    <!-- Carregando Js na página -->
    <script src="js/scripts.js" defer>
    </script>
</body>

</html>