<?php require __DIR__ . "/../controllers/validar_acesso.php"; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>

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
    <?php require __DIR__ . '/../components/nav.php'; ?>

    <section class="sec-main">

        <?php require __DIR__ . '/../components/header.php'; ?>

        <div class="doc-container">

            <div class="doc-hero">
                <div class="hero-content">
                    <h1>Bem-vindo ao Sistema NR12</h1>
                    <p>
                        Sistema desenvolvido para otimizar o processo de checklists de máquinas,
                        substituindo formulários em papel por uma solução digital prática e eficiente.
                    </p>
                </div>
            </div>

            <div class="doc-grid">

                <div class="doc-card">
                    <div class="card-icon-box">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h2>Checklists Digitais</h2>
                    <p>
                        Realize o checklist antes de utilizar uma máquina acessando com matrícula e NI.
                        Processo simples, rápido e focado na segurança.
                    </p>
                </div>

                <div class="doc-card">
                    <div class="card-icon-box">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h2>Sobre a Norma NR12</h2>
                    <p>
                        A NR-12 estabelece requisitos mínimos de segurança no trabalho com máquinas e equipamentos,
                        sendo obrigatória para organizações que operam sob regime CLT.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <script src="../../js/scripts.js" defer></script>
    <script src="../../js/processa.js" defer></script>

    <?php if (isset($_SESSION['user_senha_padrao']) && $_SESSION['user_senha_padrao'] == 1) { ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('changePassword');
                if (modal) {
                    modal.style.display = 'flex';
                }
            });
        </script>
    <?php }
    ; ?>

    
</body>

</html>
