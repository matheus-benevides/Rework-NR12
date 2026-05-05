<?php

require_once __DIR__ . "/../configs/conexao.php";
$atualmente_em = basename($_SERVER['PHP_SELF']);
$permissao_usuario = $_SESSION['colaborador_permissao'] ?? $_SESSION['user_permissao'] ?? 'NORMAL';
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
        <a href="dashboard.php" style="display: none;" class="<?php if ($atualmente_em == 'dashboard.php') echo 'ativo'; ?> links">
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

        <!-- MÁQUINAS (DROP-DOWN) -->
        <div class="menu-manutencao" id="menu-maquinas-container">
            <a href="javascript:void(0)" class="links manutencao-btn" id="btn-maquinas">
                <div>
                    <i class="bi bi-cpu"></i>
                    <span>Máquinas</span>
                </div>
                <i class="bi bi-caret-down-fill seta"></i>
            </a>

            <div class="submenu" id="submenu-maquinas">
                <a href="maquinas.php"
                    class="<?php if ($atualmente_em == 'maquinas.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-gear-fill"></i> Máquinas
                </a>
                <a href="tipo_maquina.php"
                    class="<?php if ($atualmente_em == 'tipo_maquina.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-tags-fill"></i> Descrição Máquinas
                </a>
            </div>
        </div>

        <!-- REQUISITOS (DROP-DOWN) -->
        <div class="menu-manutencao" id="menu-manutencao-container">

            <a href="javascript:void(0)"
                class="links manutencao-btn"
                id="btn-manutencao">
                <div>
                    <i class="bi bi-wrench"></i>
                    <span>Requisitos</span>
                </div>
                <i class="bi bi-caret-down-fill seta"></i>
            </a>

            <div class="submenu" id="submenu-manutencao">

                <a href="requisitos.php"
                    class="<?php if ($atualmente_em == 'requisitos.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-gear-wide-connected"></i> Requisitos
                </a>

                <a href="requisitos_maquina.php"
                    class="<?php if ($atualmente_em == 'requisitos_maquina.php') echo 'ativo'; ?> links-sub">
                    <i class="bi bi-wrench-adjustable"></i>
                    Relacionar requisitos a máquina
                </a>
            </div>
        </div>

        <a href="historico.php" class="<?php if ($atualmente_em == 'historico.php') echo 'ativo'; ?> links">
            <i class="bi bi-journal-check"></i> Histórico
        </a>

        <a href="documentacao.php" class="<?php if ($atualmente_em == 'documentacao.php') echo 'ativo'; ?> links">
            <i class="bi bi-file-earmark"></i> Documentação
        </a>

    </div>

    <!-- CONFIGURAÇÕES -->
    <div class="div-configs">
        <div>
            <button onclick="changeTheme()" id="tema">I got Black, i got White, what you want?</button>

            <a href="suporte.php" class="configs dont-rotate" title="Suporte">
                <i class="bi bi-headset"></i>
            </a>

            <a href="perfil.php" class="configs dont-rotate" title="Perfil">
                <i class="bi bi-person-fill"></i>
            </a>
        </div>

        <button
            onclick="window.location.href='../actions/logout.php'"
            class="sair"
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
    }

    .submenu.aberto {
        display: block;
    }

    .links-sub {
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--txtClaro);
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 5px;
        transition: 0.3s;
    }
    
    .links-sub:hover, .links-sub.ativo {
        background-color: var(--corFundo);
        color: var(--corTxt3);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const dropdowns = [
            {
                btnId: "btn-manutencao",
                submenuId: "submenu-manutencao",
                containerId: "menu-manutencao-container",
                paginas: ["requisitos.php", "requisitos_maquina.php"]
            },
            {
                btnId: "btn-maquinas",
                submenuId: "submenu-maquinas",
                containerId: "menu-maquinas-container",
                paginas: ["maquinas.php", "tipo_maquina.php"]
            }
        ];

        const paginaAtual = window.location.pathname;

        dropdowns.forEach(({ btnId, submenuId, containerId, paginas }) => {
            const btn = document.getElementById(btnId);
            const submenu = document.getElementById(submenuId);
            const container = document.getElementById(containerId);
            if (!btn || !submenu || !container) return;

            function abrir() {
                submenu.classList.add("aberto");
                container.classList.add("aberto");
                btn.classList.add("ativo");
            }

            function fechar() {
                submenu.classList.remove("aberto");
                container.classList.remove("aberto");
                btn.classList.remove("ativo");
            }

            btn.addEventListener("click", (e) => {
                e.preventDefault();
                submenu.classList.contains("aberto") ? fechar() : abrir();
            });

            if (paginas.some(p => paginaAtual.includes(p))) {
                abrir();
            }
        });
    });
</script>
