<?php

session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:logout.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ADM_NOME = $_POST['ADM_NOME'];
    $ADM_SENHA = $_POST['ADM_SENHA'];
    $ADM_ATIVO = $_POST['ADM_ATIVO'];

    try {
        $sql = "INSERT INTO administrador (ADM_NOME, ADM_SENHA, ADM_ATIVO) VALUES (:ADM_NOME, :ADM_SENHA, :ADM_ATIVO)";
        $stmt = $pdo->prepare($sql); // Preparação para não conter injeção de sql
        $stmt->bindParam(':ADM_NOME', $ADM_NOME, PDO::PARAM_STR);
        $stmt->bindParam(':ADM_SENHA', $ADM_SENHA, PDO::PARAM_STR);
        $stmt->bindParam(':ADM_ATIVO', $ADM_ATIVO, PDO::PARAM_STR);
        $stmt->execute(); //execulta os comando á cima

        echo "<p style='color:green;'> Administrador cadastrado com sucesso</p>";
    } catch (PDOException $erro) {
        echo "<p style='color:red;'>Erro ao cadastrar o administrador: </p>" . $erro->getMessage() . "</p>";
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
    <title>Cadastrar administrador</title>

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
                    <hr>
                </ul>
            </nav>


        </div> <!--FIM SIDEBAR-->

        <div class="content">
            <div class="container_cad_produto">
                <div class="return_cad"> <!-- LINK DE RETORNO -->
                    <a href="adms.php">Retornar</a>
                </div>

                <div class="cadas_produto">
                    <h2>Cadastrar Adiministrador</h2>

                    <form action="" method="post" enctype="multipart/form-data">

                        <label for="ADM_NOME">Nome do administrador: </label>
                        <input type="text" name="ADM_NOME" id="ADM_NOME" required>
                        <p></p>

                        <label for="ADM_SENHA">Senha do administrador</label>
                        <input type="text" name="ADM_SENHA" id="ADM_SENHA" required></input>
                        <p></p>

                        <label for="ADM_ATIVO">Administrador ativo</label>
                        <input type="text" name="ADM_ATIVO" id="ADM_ATIVO" required>
                        <p></p>

                        <input type="submit" value="Cadastrar">
                        <p></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://kit.fontawesome.com/482af9f33c.js" crossorigin="anonymous"></script>
        <script src="js/javinha.js"></script>

</body>

</html>