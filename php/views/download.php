<?php
$arquivo = "../../_documentos/Coordenador.docx";

if (file_exists($arquivo)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($arquivo).'"');
    header('Content-Length: ' . filesize($arquivo));
    readfile($arquivo);
    exit;
} else {
    echo "Arquivo não encontrado.";
}
?>
