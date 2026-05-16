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

        <a href="home.php" class="<?php if ($atualmente_em == 'home.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-house-door-fill"></i> Home
        </a>

        <a href="dashboard.php" style="display: none;" class="<?php if ($atualmente_em == 'dashboard.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="cursos.php" class="<?php if ($atualmente_em == 'cursos.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-mortarboard-fill"></i> Cursos
        </a>

        <a href="turmas.php" class="<?php if ($atualmente_em == 'turmas.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-people-fill"></i> Turmas
        </a>

        <a href="alunos.php" class="<?php if ($atualmente_em == 'alunos.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-person-lines-fill"></i> Alunos
        </a>

        <a href="unidade.php" class="<?php if ($atualmente_em == 'unidade.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-unity"></i> Unidade
        </a>

        <a href="setores.php" class="<?php if ($atualmente_em == 'setores.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-diagram-3-fill"></i> Setor
        </a>

        <a href="colaboradores.php" class="<?php if ($atualmente_em == 'colaboradores.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-person-badge-fill"></i> Colaboradores
        </a>

        <div class="menu-maquinas">
            <a href="javascript:void(0)" class="links maquinas-btn" id="btn-maquinas">
                <div>
                    <i class="bi bi-cpu"></i>
                    <span>Máquinas</span>
                </div>
                <i class="bi bi-caret-down-fill seta"></i>
            </a>

            <div class="submenu" id="submenu-maquinas">
                <a href="maquinas.php" class="<?php if ($atualmente_em == 'maquinas.php')
    echo 'ativo'; ?> links-sub">
                    <i class="bi bi-gear-fill"></i> Máquinas
                </a>
                <a href="tipo_maquina.php" class="<?php if ($atualmente_em == 'tipo_maquina.php')
    echo 'ativo'; ?> links-sub">
                    <i class="bi bi-tags-fill"></i> Descrição Máquinas
                </a>
            </div>
        </div>

        <div class="menu-manutencao">
            <a href="javascript:void(0)" class="links manutencao-btn" id="btn-manutencao">
                <div>
                    <i class="bi bi-wrench"></i>
                    <span>Requisitos</span>
                </div>
                <i class="bi bi-caret-down-fill seta"></i>
            </a>

            <div class="submenu" id="submenu-manutencao">
                <a href="requisitos.php" class="<?php if ($atualmente_em == 'requisitos.php')
    echo 'ativo'; ?> links-sub">
                    <i class="bi bi-gear-wide-connected"></i> Requisitos
                </a>
                <a href="requisitos_maquina.php" class="<?php if ($atualmente_em == 'requisitos_maquina.php')
    echo 'ativo'; ?> links-sub">
                    <i class="bi bi-wrench-adjustable"></i> Relacionar Requisitos
                </a>
            </div>
        </div>

        <a href="historico.php" class="<?php if ($atualmente_em == 'historico.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-journal-check"></i> Histórico
        </a>

        <a href="documentacao.php" class="<?php if ($atualmente_em == 'documentacao.php')
    echo 'ativo'; ?> links">
            <i class="bi bi-file-earmark"></i> Documentação
        </a>

    </div>

    <div class="div-configs">
        <div>
            <button onclick="changeTheme()" id="tema"></button>

            <a href="suporte.php" class="configs dont-rotate" title="Suporte">
                <i class="bi bi-headset"></i>
            </a>

            <a href="perfil.php" class="configs dont-rotate" title="Perfil">
                <i class="bi bi-person-fill"></i>
            </a>
        </div>

        <button onclick="window.location.href='../actions/logout.php'" class="sair"
            onmouseover="changeSairBtn('open')" onmouseleave="changeSairBtn('closed')">
            <span>Sair</span> <i class="bi bi-door-closed-fill"></i>
        </button>
    </div>
</nav>

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
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const dropdowns = [
            {
                btnId: "btn-manutencao",
                submenuId: "submenu-manutencao",
                paginas: ["requisitos.php", "requisitos_maquina.php"]
            },
            {
                btnId: "btn-maquinas",
                submenuId: "submenu-maquinas",
                paginas: ["maquinas.php", "tipo_maquina.php"]
            }
        ];

        const paginaAtual = window.location.pathname;

        dropdowns.forEach(({ btnId, submenuId, paginas }) => {
            const btn = document.getElementById(btnId);
            const submenu = document.getElementById(submenuId);
            if (!btn || !submenu) return;

            const menu = btn.parentElement;

            function abrir() {
                submenu.classList.add("aberto");
                menu.classList.add("aberto");
                btn.classList.add("ativo");
            }

            function fechar() {
                submenu.classList.remove("aberto");
                menu.classList.remove("aberto");
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
