<?php
session_start();
require_once('../conexao.php');


//Varificação se o usuario está logado
require_once('../valida_login.php');


$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['PRODUTO_ID'])) {
    $id = $_GET['PRODUTO_ID'];
    try { 
        // UPDATE produto SET PRODUTO_ATIVO = 0 WHERE PRODUTO_ID = :PRODUTO_ID
        $stmt = $pdo->prepare("UPDATE
         PRODUTO
         SET PRODUTO_ATIVO	= 0
         WHERE PRODUTO_ID = :PRODUTO_ID"); 
        $stmt->bindParam(':PRODUTO_ID', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Produto desativado com sucesso!";
        } else {
            $mensagem = "Erro ao desativar produto";
        }
    } catch (PDOException $erro) {
        $mensagem = "Erro: " . $erro->getMessage();
    }
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir produto</title>
</head>

<body>
    <h2>Excluir produto</h2>
    <p><?php echo $mensagem ?></p>
    <a href="listar_produto.php">Voltar a lista de produtos</a>

</body>

</html>