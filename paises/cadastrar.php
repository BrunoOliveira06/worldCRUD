<?php
require_once '../includes/conexao.php';
// Não é necessário lógica de banco aqui, apenas o formulário
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar País</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Cadastrar Novo País</h1>
            <nav>
                <a href="../index.php">Voltar para Países</a>
            </nav>
        </header>

        <form action="processa_pais.php" method="POST">
            <input type="hidden" name="acao" value="cadastrar">

            <label for="nome">Nome Oficial:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="continente">Continente:</label>
            <select id="continente" name="continente" required>
                <option value="">Selecione</option>
                <option value="África">África</option>
                <option value="América do Norte">América do Norte</option>
                <option value="América do Sul">América do Sul</option>
                <option value="Ásia">Ásia</option>
                <option value="Europa">Europa</option>
                <option value="Oceania">Oceania</option>
            </select>

            <label for="populacao">População:</label>
            <input type="number" id="populacao" name="populacao" required min="1">

            <label for="idioma">Idioma Principal:</label>
            <input type="text" id="idioma" name="idioma" required>

            <button type="submit">Cadastrar</button>
            <a href="../index.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>
</html>
<?php $conexao->close(); ?>
