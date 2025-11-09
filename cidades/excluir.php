<?php
// Este arquivo apenas redireciona para o processamento de exclusão
// A confirmação é feita via JavaScript na listagem (listar.php)

$id_cidade = $_GET['id'] ?? null;

if ($id_cidade) {
    header("Location: processa_cidade.php?acao=excluir&id=" . urlencode($id_cidade));
    exit();
} else {
    header("Location: listar.php?mensagem=" . urlencode("ID da cidade não fornecido para exclusão."));
    exit();
}
?>
