<?php
session_start();


if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="painelcss.css">
    <title>Produtos</title>
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
                    <ul class="dropdown">
                        <li class="product">
                            <div class="produtos">
                                <a href="cadastrar_produto.php">
                                    <button>Cadastra produto</button> </a>
                            </div>
                        </li>

                        <li>
                            <div>
                                <a href="listar_produto.php">
                                    <button>Listar produto</button> </a>
                            </div>
                        </li>
                    </ul>

                </li>
                <li><a href="../users/user.html"><i class="fa-solid fa-house"></i>Users </a></li>
                <li><a href="../register/register.html"><i class="fa-solid fa-house"></i>Register</a></li>
                <li><a href="#"><i class="fa-solid fa-house"></i>Relatorios</a></li>
                <hr>
            </ul>
            </nav>


        </div> <!--Fim sidebar-->

        <div class="content">


        </div>


    </section>







    <script src="https://kit.fontawesome.com/482af9f33c.js" crossorigin="anonymous"></script>
    <script src="js.js"></script>
</body>

</html>