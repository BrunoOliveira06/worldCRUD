<?php
require_once '../includes/conexao.php';

$id_pais = $_GET['id'] ?? null;

if (!$id_pais) {
    header("Location: ../index.php?mensagem=" . urlencode("ID do país não fornecido para edição."));
    exit();
}

// Busca os dados do país
$sql = "SELECT * FROM paises WHERE id_pais = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_pais);
$stmt->execute();
$resultado = $stmt->get_result();
$pais = $resultado->fetch_assoc();
$stmt->close();

if (!$pais) {
    header("Location: ../index.php?mensagem=" . urlencode("País não encontrado."));
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar País</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Editar País: <?php echo htmlspecialchars($pais['nome']); ?></h1>
            <nav>
                <a href="../index.php">Voltar para Países</a>
            </nav>
        </header>

        <form action="processa_pais.php" method="POST">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id_pais" value="<?php echo $pais['id_pais']; ?>">

            <label for="nome">Nome Oficial:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($pais['nome']); ?>" required>

            <label for="continente">Continente:</label>
            <select id="continente" name="continente" required>
                <?php
                $continentes = ['África', 'América do Norte', 'América do Sul', 'Ásia', 'Europa', 'Oceania'];
                foreach ($continentes as $c) {
                    $selected = ($c == $pais['continente']) ? 'selected' : '';
                    echo "<option value=\"$c\" $selected>$c</option>";
                }
                ?>
            </select>

            <label for="populacao">População:</label>
            <input type="number" id="populacao" name="populacao" value="<?php echo $pais['populacao']; ?>" required min="1">

            <label for="idioma">Idioma Principal:</label>
            <input type="text" id="idioma" name="idioma" value="<?php echo htmlspecialchars($pais['idioma']); ?>" required>

            <button type="submit">Salvar Alterações</button>
            <a href="../index.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>
</html>
<?php $conexao->close(); ?>
