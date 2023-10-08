<?php
    session_start(); 


    if(!isset($_SESSION['admin_logado'])){
        header('Location:login.php');
        exit();
    }

    require_once('conexao.php');

    try{
        $stmt = $pdo->prepare("SELECT * FROM produtos");
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $erro){
        echo "Erro ". $erro->getMessage();
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="listarcss.css">
    <title>Produtos</title>
</head>
<body>
    <h2>Tabela de produtos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Imagem</th>
                <th>URL_imagem</th>
                <th>Ações</th> <!-- Adicionando uma coluna para as ações -->
            </tr>
        </thead>

        <tbody>
        <?php foreach ($produtos as $produto) { ?>
            <tr>
                <td><?php echo $produto['id'];?></td>
                <td><?php echo $produto['nome'];?></td>
                <td><?php echo $produto['descricao'];?></td>
                <td><?php echo $produto['preco'];?></td>
                <td><?php echo $produto['imagem'];?></td>
                <td><img src="<?php echo $produto['url_imagem'];?>" alt="Imagem do produto" width="50"></td>
                <td>
                    <a href="editar_produto.php?id=<?php echo $produto['id'];?>">Editar</a>
                    <a href="excluir_produto.php?id=<?php echo $produto['id'];?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <a href="painel_admin.php">Voltar para o Painel</a>
</html>