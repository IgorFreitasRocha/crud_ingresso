<?php
session_start();


if(!isset($_SESSION['admin_logado'])){
    header("Location:login.php");
    exit();


}


require_once('conexao.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            $mensagem = "Produto excluido com sucesso!";
        }else {
            $mensagem = "Erro ao excluir o produto";
        }
    
    }catch (PDOException $erro) {
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
    <title>Excluir produtos</title>
</head>
<body>
    <h2>Excluir produto</h2>    
    <p><?php echo $mensagem ?></p>
    <a href="listar_produto.php">Voltar a lista de produtos</a>

</body>
</html>