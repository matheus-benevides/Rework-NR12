<?php

require_once "../configs/conexao.php";
$atualmente_em = basename($_SERVER['PHP_SELF']);
$permissao_usuario = $_SESSION['colaborador_permissao'];
?>

<nav class="sidebar">
    <div class="botao-fechar">
        <button id="fechar-nav">
            <i class="bi bi-arrow-left-circle-fill"></i>
        </button>
    </div>

    <div class="div-img">
        <img src="../../assets/imgs/senailogo2.png" alt="Logo Senai" id="senai-logo2">
    </div>

    <div class="div-links">

        <!-- HOME -->
        <a href="home.php" class="<?php if ($atualmente_em == 'home.php') echo 'ativo'; ?> links">
            <i class="bi bi-house-door-fill"></i> Home
        </a>

        <!-- DASHBOARD -->
        <a href="dashboard.php" class="<?php if ($atualmente_em == 'dashboard.php') echo 'ativo'; ?> links">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <!-- CURSOS -->
        <a href="cursos.php" class="<?php if ($atualmente_em == 'cursos.php') echo 'ativo'; ?> links">
            <i class="bi bi-mortarboard-fill"></i> Cursos
        </a>

        <!-- TURMAS -->
        <a href="turmas.php" class="<?php if ($atualmente_em == 'turmas.php') echo 'ativo'; ?> links">
            <i class="bi bi-people-fill"></i> Turmas
        </a>

        <!-- ALUNOS -->
        <a href="alunos.php" class="<?php if ($atualmente_em == 'alunos.php') echo 'ativo'; ?> links">
            <i class="bi bi-person-lines-fill"></i>Alunos
        </a>

        <!-- UNIDADE -->
        <a href="unidade.php" class="<?php if ($atualmente_em == 'unidade.php') echo 'ativo'; ?> links">
            <i class="bi bi-unity"></i> Unidade
        </a>

        <!-- SETOR -->
        <a href="setores.php" class="<?php if ($atualmente_em == 'setores.php') echo 'ativo'; ?> links">
            <i class="bi bi-diagram-3-fill"></i> Setor
        </a>

        <!-- FUNCIONARIOS -->
        <a href="colaboradores.php" class="<?php if ($atualmente_em == 'colaboradores.php') echo 'ativo'; ?> links">
            <i class="bi bi-person-badge-fill"></i> Colaboradores
        </a>


        <a href="motores.php"
            class="<?php if ($atualmente_em == 'motores.php') echo 'ativo'; ?> links" style='display: none;'>
            <i class="bi bi-gear-fill"></i> Motores
        </a>

        <!-- MANUTENÇÃO -->

        <div class="menu-manutencao" style="display: flex;">

            <a href="javascript:void(0)"
                class="links manutencao-btn"
                id="btn-manutencao">
                <div>
                    <i class="bi bi-wrench"></i>
                    <span>Máquinas</span>
                </div>
                <i class="bi bi-caret-down-fill seta"></i>
            </a>

            <div class="submenu" id="submenu-manutencao">
                <!-- tem que criar o arquivo de manuntenção, vou criar -->

                <a href="maquinas.php"
                    class="<?php if ($atualmente_em == 'maquinas.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-gear-wide-connected"></i> Máquinas
                </a>

                <a href="manuntencao.php"
                    class="<?php if ($atualmente_em == 'manuntencao.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-tools"></i> Manuntenção
                </a>

                <a href="motores.php"
                    class="<?php if ($atualmente_em == 'motores.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-wrench-adjustable-circle"></i> Motores
                </a>

                <a href="tipo_maquina.php"
                    class="<?php if ($atualmente_em == 'tipo_maquina.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-gear-fill"></i> Tipo de Máquinas
                </a>

                <a href="requisitos_maquina.php"
                    class="<?php if ($atualmente_em == 'requisitos_maquina.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-wrench-adjustable"></i>
                    Relacionar requisitos a máquina
                </a>
            </div>
        </div>

        <!-- DASHBOARD -->
        <a href="historico.php" class="<?php if ($atualmente_em == 'historico.php') echo 'ativo'; ?> links">
            <i class="bi bi-journal-check"></i> Historico
        </a>

        <!-- DASHBOARD -->
        <a href="documentacao.php" class="<?php if ($atualmente_em == 'documentacao.php') echo 'ativo'; ?> links">
            <i class="bi bi-file-earmark"></i> Documentação
        </a>

        <!-- DASHBOARD -->
        <a href="suporte.php" class="<?php if ($atualmente_em == 'suporte.php') echo 'ativo'; ?> links">
            <i class="bi bi-headset"></i> Suporte
        </a>

        <!-- DASHBOARD -->
        <a href="perfil.php" class="<?php if ($atualmente_em == 'perfil.php') echo 'ativo'; ?> links">
            <i class="bi bi-person-fill"></i> Perfil
        </a>

    </div>

    <!-- CONFIGURAÇÕES -->
    <div class="div-configs">
        <div>
            <button onclick="changeTheme()" id="tema"></button>

            <button id="notificacao" onclick="showModal('notificacao-modal')">
                <i class="bi bi-bell-fill"></i>
                <div class="div-noti">0</div>
            </button>
        </div>

        <button
            onclick="window.location.href='../actions/logout.php'"
            class="btn sair"
            onmouseover="changeSairBtn('open')"
            onmouseleave="changeSairBtn('closed')">
            Sair <i class="bi bi-door-closed-fill"></i>
        </button>
    </div>
</nav>

<!-- AJUSTES VISUAIS DO SUBMENU -->
<style>
    .submenu {
        display: none;
        margin-left: 28px;
        /* rente ao ícone de Manutenção */
    }

    .submenu.aberto {
        display: block;
    }

    .links-sub {
        margin-top: 4px;
        /* espaçamento leve entre os botões */
    }
</style>

<!-- MANUTENCAO -->

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const btnManutencao = document.getElementById("btn-manutencao");
        const submenu = document.getElementById("submenu-manutencao");
        const menuManutencao = btnManutencao.parentElement;

        function abrirMenu() {
            submenu.classList.add("aberto");
            menuManutencao.classList.add("aberto");
            btnManutencao.classList.add("ativo");
        }

        function fecharMenu() {
            submenu.classList.remove("aberto");
            menuManutencao.classList.remove("aberto");
            btnManutencao.classList.remove("ativo");
        }

        // Toggle no clique
        btnManutencao.addEventListener("click", (e) => {
            e.preventDefault();
            submenu.classList.contains("aberto") ? fecharMenu() : abrirMenu();
        });

        // Mantém aberto se estiver em Preventiva ou Corretiva
        const paginaAtual = window.location.pathname;
        if (paginaAtual.includes("preventiva.php") || paginaAtual.includes("corretiva.php") || paginaAtual.includes("manuntencao.php")) {
            abrirMenu();
        }

        //   MAQUINAS

    });

    document.addEventListener("DOMContentLoaded", () => {

        const btnMaquinas = document.getElementById("btn-maquinas");
        const submenu = document.getElementById("submenu-maquinas");
        const menuMaquinas = btnMaquinas.parentElement;

        function abrirMenu() {
            submenu.classList.add("aberto");
            menuMaquinas.classList.add("aberto");
            btnMaquinas.classList.add("ativo");
        }

        function fecharMenu() {
            submenu.classList.remove("aberto");
            menuMaquinas.classList.remove("aberto");
            btnMaquinas.classList.remove("ativo");
        }

        // Toggle no clique
        btnMaquinas.addEventListener("click", (e) => {
            e.preventDefault();
            submenu.classList.contains("aberto") ? fecharMenu() : abrirMenu();
        });

        // Mantém aberto se estiver em Preventiva ou Corretiva
        const paginaAtual = window.location.pathname;
        if (paginaAtual.includes("maquinas.php") || paginaAtual.includes("tipo_maquina.php") || paginaAtual.includes("consultar_maquina.php") || paginaAtual.includes("consultar_tipo_maquina.php") || paginaAtual.includes("requisitos_maquina.php")) {
            abrirMenu();
        }

    });
</script>