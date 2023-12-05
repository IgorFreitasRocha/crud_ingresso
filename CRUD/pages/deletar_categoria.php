<?php
session_start();
require_once('../conexao.php');


//Varificação se o usuario está logado
require_once('../valida_login.php');


$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['CATEGORIA_ID'])) {
    $id = $_GET['CATEGORIA_ID'];
    try { 
        $stmt = $pdo->prepare("UPDATE
         CATEGORIA
         SET CATEGORIA_ATIVO = 0
         WHERE CATEGORIA_ID = :CATEGORIA_ID"); 
        $stmt->bindParam(':CATEGORIA_ID', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Categoria desativada com sucesso!";
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
    <title>Inativar Categoria</title>
</head>

<body>
    <h2>Inativar Categoria</h2>
    <p><?php echo $mensagem ?></p>
    <a href="listar_categoria.php">Voltar a lista de categorias</a>

</body>

</html>