<?php require "../controllers/validar_acesso.php"; ?>
<?php require '../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil - NR12</title>

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

  <section class="sec-main dontmove" style="align-items: center; justify-content: center;">

    <div class="modal-box">
      <div class="modal-header">
        <h3>Perfil de Usuário</h3>
      </div>

      <form id="form-suporte" class="modal-form">

        <div class="modal-row">

        </div>
        <div class="modal-row">
          <div class="modal-input">
            <label for="">Nome de Usuário: </label>
            <div class="input-wrapper">
              <input type="text" disabled value="<?php echo $nome_usuario ?>">
            </div>
            <br>
            <label for="">E-mail: </label>
            <div class="input-wrapper">
              <input type="text" disabled value="<?php
                                                  $sql = "SELECT colaborador_email FROM colaborador WHERE idcolaborador = ?";
                                                  $stmt = $conn->prepare($sql);
                                                  $stmt->bind_param("i", $id_usuario);
                                                  $stmt->execute();
                                                  $resultado = $stmt->get_result();
                                                  $convertendo = $resultado->fetch_assoc();
                                                  $convertendo != null ? $resposta = $convertendo['colaborador_email'] : $resposta = "E-MAIL NÃO CADASTRADO";
                                                  echo $resposta; ?>">
            </div>
          </div>
          <div class="avatar-profile">
            <?php echo substr($nome_usuario, 0, 2); ?>
          </div>
        </div>
        <div class="modal-row">
          <div class="modal-input">
            <label for="">NIF: </label>
            <div class="input-wrapper">
              <input type="text" disabled value="<?php
                                                  $sql = "SELECT colaborador_nif FROM colaborador WHERE idcolaborador = ?";
                                                  $stmt = $conn->prepare($sql);
                                                  $stmt->bind_param("i", $id_usuario);
                                                  $stmt->execute();
                                                  $resultado = $stmt->get_result();
                                                  $convertendo = $resultado->fetch_assoc();
                                                  $convertendo != null ? $resposta = $convertendo['colaborador_nif'] : $resposta = "NIF NÃO CADASTRADO";
                                                  echo $resposta;
                                                  ?>">
            </div>
          </div>
          <div class="modal-input">
            <label for="">Setor: </label>
            <div class="input-wrapper">
              <input type="text" disabled value="<?php
                                                  $sql = "SELECT setor.setor_nome FROM setor INNER JOIN colaborador ON colaborador.setor_id = setor.idsetor WHERE colaborador.idcolaborador = ?";
                                                  $stmt = $conn->prepare($sql);
                                                  $stmt->bind_param("i", $id_usuario);
                                                  $stmt->execute();
                                                  $resultado = $stmt->get_result();
                                                  $convertendo = $resultado->fetch_assoc();
                                                  $convertendo != null ? $resposta = $convertendo['setor_nome'] : $resposta = "SETOR NÃO CADASTRADO";
                                                  echo $resposta;
                                                  ?>">
            </div>
          </div>
        </div>
        <div class="modal-input">
          <label for="">Função: </label>
          <div class="input-wrapper">
            <input type="text" name="" id="" disabled value="<?php echo $permissao_usuario; ?>">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn-confirmar-full deletar" onclick="window.location.href='../actions/logout.php'">
            Sair <i class="bi bi-plus-lg"></i>
          </button>
        </div>
      </form>
    </div>
  </section>

  <script src="../../js/scripts.js" defer></script>
</body>

</html>