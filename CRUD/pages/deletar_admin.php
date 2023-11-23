<?php
session_start();
require_once('../conexao.php');

//Varificação se o usuario está logado
require_once('../valida_login.php');


$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['ADM_ID'])) {
    $ADM_ID = $_GET['ADM_ID'];
    try {
        $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_ATIVO = 0 WHERE ADM_ID = :ADM_ID");
        $stmt->bindParam(':ADM_ID', $ADM_ID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Administrador desativado com sucesso!";
        } else {
            $mensagem = "Erro ao excluir o administrador";
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
    <title>Excluir administrador</title>
</head>

<body>
    <h2>Excluir administrador</h2>
    <p><?php echo $mensagem ?></p>
    <a href="listar_admin.php">Voltar a lista de administradores</a>

</body>

</html>