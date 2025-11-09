<?php
require_once '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST['acao'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $populacao = $_POST['populacao'] ?? 0;
    $id_pais = $_POST['id_pais'] ?? null;
    $id_cidade = $_POST['id_cidade'] ?? null;

    $mensagem = "";

    switch ($acao) {
        case 'cadastrar':
            $sql = "INSERT INTO cidades (nome, populacao, id_pais) VALUES (?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sii", $nome, $populacao, $id_pais);

            if ($stmt->execute()) {
                $mensagem = "Cidade '{$nome}' cadastrada com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar cidade: " . $stmt->error;
            }
            $stmt->close();
            break;

        case 'editar':
            if ($id_cidade) {
                $sql = "UPDATE cidades SET nome = ?, populacao = ?, id_pais = ? WHERE id_cidade = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("siii", $nome, $populacao, $id_pais, $id_cidade);

                if ($stmt->execute()) {
                    $mensagem = "Cidade '{$nome}' atualizada com sucesso!";
                } else {
                    $mensagem = "Erro ao atualizar cidade: " . $stmt->error;
                }
                $stmt->close();
            }
            break;

        default:
            $mensagem = "Ação inválida.";
            break;
    }

    $conexao->close();
    header("Location: listar.php?mensagem=" . urlencode($mensagem));
    exit();
}

// Lógica para Excluir (GET request)
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $id_cidade = $_GET['id'];

    $sql_delete = "DELETE FROM cidades WHERE id_cidade = ?";
    $stmt_delete = $conexao->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_cidade);

    if ($stmt_delete->execute()) {
        $mensagem = "Cidade excluída com sucesso!";
    } else {
        $mensagem = "Erro ao excluir cidade: " . $stmt_delete->error;
    }
    $stmt_delete->close();

    $conexao->close();
    header("Location: listar.php?mensagem=" . urlencode($mensagem));
    exit();
}

// Redireciona para a página de listagem se acessado diretamente sem POST ou GET de exclusão
header("Location: listar.php");
exit();
?>
