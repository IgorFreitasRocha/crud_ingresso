<?php

    session_start();
    require_once('conexao.php');

    if(!isset($_SESSION['admin_logado'])){
        header("Location:login.php");
        exit();
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $imagem = $_FILES['imagem']['name'];
        $url_image = $_POST['url_imagem'];
    
        //Diretorio onde a imagem será salva
        $target_dir = "upload/";
        $target_file = $target_dir . basename($imagem);

        //Gerar a URL da imagem
        $base_url = "http://localhost/CRUD/CRUD/";
        $url_imagem = $base_url . "upload/" . basename($imagem);

        //Mover o arquivo de imagem carregado para o diretorio de distino
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
            
        }else{
            echo "Falha ao carregar imagem";
        }


        try{
        $sql = "INSERT INTO produtos (nome, descricao, preco, imagem, url_imagem) VALUES (:nome,:descricao, :preco, :imagem, :url_imagem)";
        $stmt = $pdo->prepare($sql); // Preparação para não conter injeção de sql
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':imagem', $target_file, PDO::PARAM_STR);
        $stmt->bindParam(':url_imagem', $url_imagem, PDO::PARAM_STR);
        
        $stmt->execute(); //execulta os comando á cima

        echo "<p style='color:green;'> Produto cadastrado com sucesso</p>";
        }catch(PDOException $erro){
            echo "<p style='color:red;'>Erro ao cadastrar o produto: </p>" . $erro->getMessage()."</p>";
         }

    }





?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="painelcss.css">
    <script src="javinha.js"></script>
    <title>Cadastrar produto</title>

</head>
<body>
<header>
        <div class="topo">
            <div class="logo">
                <a href="painel_admin.php"><img src="img/logobravo.jpg" alt="Logo empresa bravo"></a>
            </div>

            <div class="saudacao">
                <h2>Bem vindo, Administrador</h2>
            </div>

            <div class="user">
                <img src="img/eu.jpg" alt="">
            </div>
        </div>

    </header>


    <section class="main">
        <div class="sidebar">
            <h3>Home</h3>
            <nav>
            <ul>
                <li class="product"><a class="active nav-prod product" href="painel_admin.php"><i class="fa-solid fa-house "></i>Produtos</a>
                </li>
                <li><a href="../users/user.html"><i class="fa-solid fa-house"></i>Users </a></li>
                <li><a href="../register/register.html"><i class="fa-solid fa-house"></i>Register</a></li>
                <li><a href="#"><i class="fa-solid fa-house"></i>Relatorios</a></li>
                <hr>
            </ul>
            </nav>


        </div> <!--Fim sidebar-->

        <div class="content">

        <section>
    <h2>Cadastrar Produto</h2>    

        <form action="" method="post" enctype="multipart/form-data">

        <label for="nome">Nome do Produto: </label>
        <input type="text" name="nome" id="nome" required>
        <p></p>

        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" required></textarea>
        <p></p>

        <label for="preco">Preço</label>
        <input type="number" name="preco" id="preco" step="0.01" required>
        <p></p>

        <label for="imagem">Imagem</label>
        <input type="file"  name="imagem" id="imagem">
        <p></p>

        <label for="url_imagem">URL da imagem</label>
        <input type="text" name="url_imagem" id="url_imagem">
        <p></p>

        <input type="submit" value="Cadastrar">
        <p></p>





    </form>

    </section>


        </div>
    

    </section> 
    
    <script src="https://kit.fontawesome.com/482af9f33c.js" crossorigin="anonymous"></script>


</body>
</html>