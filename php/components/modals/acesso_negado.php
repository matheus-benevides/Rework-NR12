<?php if (isset($_GET['acesso']) && $_GET['acesso'] == 'negado') {
?>
    <div class="modal-fundo" id="acesso" style="display: flex;">
        <div class="modal-box-acesso">
            <div class="modal-header-acesso">
                <!-- <button onclick="closeModal('acesso')"><i class="bi bi-x-lg"></i></button> -->
            </div>
            <div class="modal-txt-acesso">
                <div>
                    <i class="bi bi-exclamation-diamond"></i>
                    <h3>Acesso Negado</h3>
                </div>
                <?php if (basename($_SERVER['PHP_SELF']) == "index.php") {
                ?>
                    <p>Realize o login antes de tentar acessar nosso sistema.</p>
                <?php
                } else {
                ?>
                    <p>O seu nível de permissão não permite que você acesse está página.</p>
                <?php } ?>
            </div>
            <div class="modal-btn-acesso">
                <button onclick="closeModal('acesso')" class="btn confirmar">OK</button>
            </div>
        </div>
    </div>
<?php } ?>