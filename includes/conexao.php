<?php
// Configurações de conexão com o banco de dados (padrão XAMPP)
$host = "localhost";
$usuario = "root"; // Usuário padrão do XAMPP
$senha = "";       // Senha padrão do XAMPP
$banco = "bd_mundo";

// Conexão com o banco de dados
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// Define o charset para UTF-8
$conexao->set_charset("utf8");
?>
