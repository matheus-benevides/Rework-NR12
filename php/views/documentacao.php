<?php require __DIR__ . "/../controllers/validar_acesso.php"; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>
<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">

    <link rel="stylesheet" href="../../css/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
</head>

<body>
    <?php require __DIR__ . '/../components/nav.php'; ?>

    <section class="sec-main">

        <?php require __DIR__ . '/../components/header.php'; ?>

        <div class="doc-container">
            <div class="doc-hero">
                <div class="hero-content">
                    <h1>Documentação Técnica</h1>
                    <p>Central de informações e normas regulamentadoras para segurança no trabalho.</p>
                </div>
                <div class="hero-action">
                    <form action="download.php" method="POST">
                        <button class="btn-download-hero">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Baixar Norma Integrada
                        </button>
                    </form>
                </div>
            </div>

            <div class="doc-grid">
                <div class="doc-card">
                    <div class="card-icon-box">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h2>O que é a NR12?</h2>
                    <p>A NR12 é uma norma regulamentadora que estabelece referências técnicas para garantir a segurança
                        no trabalho em máquinas e equipamentos. Seu objetivo é prevenir acidentes e doenças
                        ocupacionais.</p>
                </div>

                <div class="doc-card">
                    <div class="card-icon-box">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <h2>Sobre a Norma</h2>
                    <p>A NR-12 é obrigatória para organizações e órgãos públicos que utilizem máquinas e equipamentos em
                        regime CLT. Ela garante que o ambiente de trabalho seja seguro e produtivo.</p>
                </div>

                <div class="doc-card full-width">
                    <div class="card-icon-box">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <h2>Objetivos Principais</h2>
                    <ul class="doc-list">
                        <li><i class="bi bi-check2-circle"></i> Proteger a saúde e a integridade física dos
                            trabalhadores.</li>
                        <li><i class="bi bi-check2-circle"></i> Estabelecer requisitos para a utilização segura de
                            máquinas.</li>
                        <li><i class="bi bi-check2-circle"></i> Promover a melhoria contínua das condições de trabalho.
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </section>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>
