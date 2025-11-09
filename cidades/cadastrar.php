<?php
require_once '../includes/conexao.php';

// Busca a lista de países para o select
$sql_paises = "SELECT id_pais, nome FROM paises ORDER BY nome";
$resultado_paises = $conexao->query($sql_paises);

if ($resultado_paises->num_rows == 0) {
    $conexao->close();
    header("Location: listar.php?mensagem=" . urlencode("É necessário cadastrar pelo menos um país antes de cadastrar uma cidade."));
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cidade</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Cadastrar Nova Cidade</h1>
            <nav>
                <a href="listar.php">Voltar para Cidades</a>
            </nav>
        </header>

        <form action="processa_cidade.php" method="POST">
            <input type="hidden" name="acao" value="cadastrar">

            <label for="nome">Nome da Cidade:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="populacao">População:</label>
            <input type="number" id="populacao" name="populacao" required min="1">

            <label for="id_pais">País:</label>
            <select id="id_pais" name="id_pais" required>
                <option value="">Selecione o País</option>
                <?php while($pais = $resultado_paises->fetch_assoc()): ?>
                    <option value="<?php echo $pais['id_pais']; ?>"><?php echo htmlspecialchars($pais['nome']); ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Cadastrar</button>
            <a href="listar.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>
</html>
<?php $conexao->close(); ?>
