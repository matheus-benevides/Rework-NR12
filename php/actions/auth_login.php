<?php
require "../configs/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // --- LÓGICA PARA ALUNO (Matrícula e NI) ---
    if (isset($_POST['matricula']) && isset($_POST['nimaquina'])) {
        $matricula = $_POST['matricula'];
        $nimaquina = $_POST['nimaquina'];

        // Ajustar dps, tá só email agr
        $sqlAluno = "SELECT * FROM aluno WHERE aluno_matricula = ? OR aluno_email = ?";
        $stmt = mysqli_prepare($conn, $sqlAluno);
        mysqli_stmt_bind_param($stmt, "ss", $matricula, $matricula);
        mysqli_stmt_execute($stmt);
        $resAluno = mysqli_stmt_get_result($stmt);

        if ($rowAluno = mysqli_fetch_assoc($resAluno)) {

            // Verifica se o status do aluno permite login (opcional, baseado na sua imagem 'aluno_status')
            if ($rowAluno['aluno_status'] !== 'Ativo') { // Ajuste 'Ativo' conforme seu banco
                header("Location: ../../index.php?erro=alunoInativo");
                exit;
            }

            // 2. Verifica Máquina (Conforme sua imagem: maquina_ni e maquina_status)
            $sqlMaq = "SELECT idmaquina, maquina_ni FROM maquina WHERE maquina_ni = ? AND maquina_status = 'Ativo'";
            $stmtMaq = mysqli_prepare($conn, $sqlMaq);
            mysqli_stmt_bind_param($stmtMaq, "s", $nimaquina);
            mysqli_stmt_execute($stmtMaq);
            $resMaq = mysqli_stmt_get_result($stmtMaq);

            if (mysqli_num_rows($resMaq) > 0) {
                $maquina = mysqli_fetch_assoc($resMaq);

                // Inicia sessão e guarda os dados
                $_SESSION['matricula'] = $rowAluno['aluno_matricula'];
                $_SESSION['aluno_nome'] = $rowAluno['aluno_nome'];
                $_SESSION['turmas_id'] = $rowAluno['turmas_id'];
                $_SESSION['nimaquina'] = $maquina['maquina_ni'];
                $_SESSION['idmaquina'] = $maquina['idmaquina'];

                header("Location: ../views/menualuno.php");
                exit;
            } else {
                // Máquina não existe ou está "Inativo" no banco
                header("Location: ../../index.php?erro=maquinaNM");
                exit;
            }
        } else {
            // Matrícula não encontrada
            header("Location: ../../index.php?erro=maquinaN");
            exit;
        }
    } // --- LÓGICA PARA COLABORADOR (Email e Senha) ---
    else if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sqlColab = "SELECT * FROM colaborador WHERE colaborador_email = ?";
        $stmt = mysqli_prepare($conn, $sqlColab);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resColab = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resColab) > 0) {
            $colaborador = mysqli_fetch_assoc($resColab);

            if ($colaborador['colaborador_status'] === 'Inativo') {
                $erro = "Usuário inativo. Contate o administrador.";
                header("Location: ../../index.php?erro=usuarioI");
            }
            // Validação de senha
            if (password_verify($senha, $colaborador['senha'])) {
                $_SESSION['user_id'] = $colaborador['idcolaborador'];
                $_SESSION['colaborador_email'] = $colaborador['colaborador_email'];
                $_SESSION['colaborador_permissao'] = $colaborador['colaborador_permissao'];
                $_SESSION['colaborador_nome'] = $colaborador['colaborador_nome'];
                $_SESSION['user_senha_padrao'] = $colaborador['senha_padrao'];
                header("Location: ../views/home.php");
                exit;
            } else {
                header("Location: ../../index.php?erro=senha");
            }
        } else {
            header("Location: ../../index.php?erro=email");
        }
    } else {
        header("Location: ../../index.php?erro=erro");
    }
} else {
    header("Location: ../../index.php");
}
