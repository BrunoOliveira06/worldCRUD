<?php
require_once '../includes/conexao.php';

$id_cidade = $_GET['id'] ?? null;

if (!$id_cidade) {
    header("Location: listar.php?mensagem=" . urlencode("ID da cidade não fornecido para edição."));
    exit();
}

// Busca os dados da cidade
$sql_cidade = "SELECT * FROM cidades WHERE id_cidade = ?";
$stmt_cidade = $conexao->prepare($sql_cidade);
$stmt_cidade->bind_param("i", $id_cidade);
$stmt_cidade->execute();
$resultado_cidade = $stmt_cidade->get_result();
$cidade = $resultado_cidade->fetch_assoc();
$stmt_cidade->close();

if (!$cidade) {
    header("Location: listar.php?mensagem=" . urlencode("Cidade não encontrada."));
    exit();
}

// Busca a lista de países para o select
$sql_paises = "SELECT id_pais, nome FROM paises ORDER BY nome";
$resultado_paises = $conexao->query($sql_paises);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cidade</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Editar Cidade: <?php echo htmlspecialchars($cidade['nome']); ?></h1>
            <nav>
                <a href="listar.php">Voltar para Cidades</a>
            </nav>
        </header>

        <form action="processa_cidade.php" method="POST">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id_cidade" value="<?php echo $cidade['id_cidade']; ?>">

            <label for="nome">Nome da Cidade:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cidade['nome']); ?>" required>

            <label for="populacao">População:</label>
            <input type="number" id="populacao" name="populacao" value="<?php echo $cidade['populacao']; ?>" required min="1">

            <label for="id_pais">País:</label>
            <select id="id_pais" name="id_pais" required>
                <option value="">Selecione o País</option>
                <?php while($pais = $resultado_paises->fetch_assoc()): ?>
                    <?php
                    $selected = ($pais['id_pais'] == $cidade['id_pais']) ? 'selected' : '';
                    ?>
                    <option value="<?php echo $pais['id_pais']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($pais['nome']); ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Salvar Alterações</button>
            <a href="listar.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>
</html>
<?php $conexao->close(); ?>
