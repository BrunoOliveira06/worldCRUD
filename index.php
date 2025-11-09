<?php
require_once 'includes/conexao.php';

// Lógica para listar países
$sql = "SELECT * FROM paises ORDER BY nome";
$resultado = $conexao->query($sql);

$mensagem = isset($_GET['mensagem']) ? htmlspecialchars($_GET['mensagem']) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mundo - Países</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gerenciamento de Países e Cidades</h1>
            <nav>
                <a href="index.php">Países</a>
                <a href="cidades/listar.php">Cidades</a>
            </nav>
        </header>

        <h2>Lista de Países</h2>

        <?php if ($mensagem): ?>
            <div class="alerta"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <p>
            <a href="paises/cadastrar.php" class="btn btn-primary">Cadastrar Novo País</a>
        </p>

        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Oficial</th>
                        <th>Continente</th>
                        <th>População</th>
                        <th>Idioma Principal</th>
                        <th>Ações</th>
                        <th>Detalhes API</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($pais = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $pais['id_pais']; ?></td>
                            <td><?php echo htmlspecialchars($pais['nome']); ?></td>
                            <td><?php echo htmlspecialchars($pais['continente']); ?></td>
                            <td><?php echo number_format($pais['populacao'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($pais['idioma']); ?></td>
                            <td>
                                <a href="paises/editar.php?id=<?php echo $pais['id_pais']; ?>" class="btn">Editar</a>
                                <a href="paises/excluir.php?id=<?php echo $pais['id_pais']; ?>" class="btn btn-danger" onclick="return confirmarExclusao('o país <?php echo htmlspecialchars($pais['nome']); ?>')">Excluir</a>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-detalhes" data-nome="<?php echo htmlspecialchars($pais['nome']); ?>">Ver Detalhes</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum país cadastrado.</p>
        <?php endif; ?>
    </div>
    <script src="js/script.js"></script>
    <script src="js/api_paises.js"></script>

    <!-- Modal para Detalhes do País -->
    <div id="modalDetalhes" class="modal" style="display:none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; border-radius: 8px;">
            <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2>Detalhes do País: <span id="paisNomeModal"></span></h2>
            <div id="detalhesConteudo">
                <!-- Conteúdo da API será injetado aqui -->
            </div>
        </div>
    </div>
</body>
</html>
<?php $conexao->close(); ?>
