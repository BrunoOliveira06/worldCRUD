<?php
require_once '../includes/conexao.php';

// Lógica para listar cidades
$sql = "SELECT c.*, p.nome AS nome_pais FROM cidades c JOIN paises p ON c.id_pais = p.id_pais ORDER BY c.nome";
$resultado = $conexao->query($sql);

// Verifica se há mensagem de status (sucesso/erro)
$mensagem = isset($_GET['mensagem']) ? htmlspecialchars($_GET['mensagem']) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mundo - Cidades</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gerenciamento de Países e Cidades</h1>
            <nav>
                <a href="../index.php">Países</a>
                <a href="listar.php">Cidades</a>
            </nav>
        </header>

        <h2>Lista de Cidades</h2>

        <?php if ($mensagem): ?>
            <div class="alerta"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <p>
            <a href="cadastrar.php" class="btn btn-primary">Cadastrar Nova Cidade</a>
        </p>

        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>População</th>
                        <th>País</th>
                        <th>Ações</th>
                        <th>Clima API</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($cidade = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $cidade['id_cidade']; ?></td>
                            <td><?php echo htmlspecialchars($cidade['nome']); ?></td>
                            <td><?php echo number_format($cidade['populacao'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($cidade['nome_pais']); ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $cidade['id_cidade']; ?>" class="btn">Editar</a>
                                <a href="excluir.php?id=<?php echo $cidade['id_cidade']; ?>" class="btn btn-danger" onclick="return confirmarExclusao('a cidade <?php echo htmlspecialchars($cidade['nome']); ?>')">Excluir</a>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-clima" data-nome="<?php echo htmlspecialchars($cidade['nome']); ?>">Ver Clima</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhuma cidade cadastrada.</p>
        <?php endif; ?>
    </div>
    <script src="../js/script.js"></script>
    <script src="../js/api_cidades.js"></script>

    <!-- Modal para Clima da Cidade -->
    <div id="modalClima" class="modal" style="display:none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; border-radius: 8px;">
            <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2>Clima em <span id="cidadeNomeModal"></span></h2>
            <div id="climaConteudo">
                <!-- Conteúdo da API será injetado aqui -->
            </div>
        </div>
    </div>
</body>
</html>
<?php $conexao->close(); ?>
