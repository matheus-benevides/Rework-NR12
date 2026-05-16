<?php
session_start();
require_once __DIR__ . "/../configs/conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $id_colab = $_SESSION['user_id'] ?? null;
    $matricula_aluno = $_SESSION['matricula'] ?? null;
    $arquivo = $_FILES['foto'];
    
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extensao, $extensoes_permitidas)) {
        header("Location: ../views/perfil.php?erro=extensao");
        exit;
    }
    
    if ($arquivo['size'] > 2 * 1024 * 1024) {
        header("Location: ../views/perfil.php?erro=tamanho");
        exit;
    }
    
    $prefixo = ($id_colab) ? "colab_" . $id_colab : "aluno_" . $matricula_aluno;
    $novo_nome = $prefixo . "_" . time() . "." . $extensao;
    $destino = "../../uploads/perfis/" . $novo_nome;
    
    if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
        if ($id_colab) {
            // Deletar antiga
            if (!empty($_SESSION['user_foto'])) {
                $antiga = "../../uploads/perfis/" . $_SESSION['user_foto'];
                if (file_exists($antiga)) unlink($antiga);
            }
            $sql = "UPDATE colaborador SET foto = ? WHERE idcolaborador = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $novo_nome, $id_colab);
            $stmt->execute();
            $_SESSION['user_foto'] = $novo_nome;
        } else if ($matricula_aluno) {
            if (!empty($_SESSION['aluno_foto'])) {
                $antiga = "../../uploads/perfis/" . $_SESSION['aluno_foto'];
                if (file_exists($antiga)) unlink($antiga);
            }
            $sql = "UPDATE aluno SET foto = ? WHERE aluno_matricula = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $novo_nome, $matricula_aluno);
            $stmt->execute();
            $_SESSION['aluno_foto'] = $novo_nome;
        }
        
        header("Location: ../views/perfil.php?sucesso=upload");
    } else {
        header("Location: ../views/perfil.php?erro=upload");
    }
} else {
    header("Location: ../views/perfil.php");
}
