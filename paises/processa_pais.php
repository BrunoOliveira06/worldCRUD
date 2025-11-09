<?php
require_once '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST['acao'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $continente = $_POST['continente'] ?? '';
    $populacao = $_POST['populacao'] ?? 0;
    $idioma = $_POST['idioma'] ?? '';
    $id_pais = $_POST['id_pais'] ?? null;

    $mensagem = "";

    switch ($acao) {
        case 'cadastrar':
            $sql = "INSERT INTO paises (nome, continente, populacao, idioma) VALUES (?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssis", $nome, $continente, $populacao, $idioma);

            if ($stmt->execute()) {
                $mensagem = "País '{$nome}' cadastrado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar país: " . $stmt->error;
            }
            $stmt->close();
            break;

        case 'editar':
            if ($id_pais) {
                $sql = "UPDATE paises SET nome = ?, continente = ?, populacao = ?, idioma = ? WHERE id_pais = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("ssisi", $nome, $continente, $populacao, $idioma, $id_pais);

                if ($stmt->execute()) {
                    $mensagem = "País '{$nome}' atualizado com sucesso!";
                } else {
                    $mensagem = "Erro ao atualizar país: " . $stmt->error;
                }
                $stmt->close();
            }
            break;

        default:
            $mensagem = "Ação inválida.";
            break;
    }

    $conexao->close();
    header("Location: ../index.php?mensagem=" . urlencode($mensagem));
    exit();
}

// Lógica para Excluir (GET request)
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $id_pais = $_GET['id'];

    // 1. Verificar se existem cidades associadas (ON DELETE RESTRICT)
    $sql_check = "SELECT COUNT(*) FROM cidades WHERE id_pais = ?";
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->bind_param("i", $id_pais);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        $mensagem = "Não foi possível excluir o país. Existem {$count} cidade(s) associada(s) a ele. Exclua as cidades primeiro.";
    } else {
        // 2. Excluir o país
        $sql_delete = "DELETE FROM paises WHERE id_pais = ?";
        $stmt_delete = $conexao->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id_pais);

        if ($stmt_delete->execute()) {
            $mensagem = "País excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir país: " . $stmt_delete->error;
        }
        $stmt_delete->close();
    }

    $conexao->close();
    header("Location: ../index.php?mensagem=" . urlencode($mensagem));
    exit();
}

// Redireciona para a página principal se acessado diretamente sem POST ou GET de exclusão
header("Location: ../index.php");
exit();
?>
