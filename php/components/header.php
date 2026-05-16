<div class="div-header">
    <div class="div-img-header">
        <div class="avatar">
            <?php 
            $foto_path = $_SESSION['user_foto'] ?? $_SESSION['aluno_foto'] ?? '';
            if (!empty($foto_path) && file_exists("../../uploads/perfis/" . $foto_path)): ?>
                <img src="../../uploads/perfis/<?= $foto_path ?>" alt="Foto de Perfil" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            <?php else: ?>
                <i class="bi bi-person"></i>
            <?php endif; ?>
        </div>
        <h4 style="color: var(--corTxt3)">Olá, <span
                style="color: var(--corDestaque);"><?php echo $nome_usuario ?></span></h4>
    </div>
    <div class="div-txt-header">
        <p>
            <i class="bi bi-calendar3"></i><?php echo date('d/m/Y') ?>
        </p>
    </div>
</div>