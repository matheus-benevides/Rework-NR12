<?php
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['matricula'])) {
    header("Location: ../../index.php?acesso=negado");
}

if (isset($_SESSION['user_id'])) {
    $id_usuario = $_SESSION['user_id'];
    $nome_usuario = $_SESSION['colaborador_nome'] ?? $_SESSION['user_nome'] ?? 'Usuário';
    $permissao_usuario = $_SESSION['colaborador_permissao'] ?? $_SESSION['user_permissao'] ?? 'NORMAL';

    $atualmente_em = basename($_SERVER['PHP_SELF']);
} else {
    $permissao_usuario = 'aluno';
    $id_maquina = $_SESSION['idmaquina'];
    $nome_usuario = $_SESSION['aluno_nome']; 
    $turma_usuario = $_SESSION['turmas_id'];
    $ni_usuario = $_SESSION['matricula'];
    $maquina_ni = $_SESSION['nimaquina'];
}


