<?php
// Este arquivo apenas redireciona para o processamento de exclusão
// A confirmação é feita via JavaScript na listagem (index.php)

$id_pais = $_GET['id'] ?? null;

if ($id_pais) {
    header("Location: processa_pais.php?acao=excluir&id=" . urlencode($id_pais));
    exit();
} else {
    header("Location: ../index.php?mensagem=" . urlencode("ID do país não fornecido para exclusão."));
    exit();
}
?>
