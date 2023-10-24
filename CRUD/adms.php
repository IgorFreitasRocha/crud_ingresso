<?php
session_start();

//Varificação se o usuario está logado
if (!isset($_SESSION['admin_logado'])) {
    header("Location:logout.php");
    exit();
}


//Banco de dados

require_once('conexao.php');

try {
    $stmt = $pdo->prepare("SELECT * FROM administrador");
    $stmt->execute();
    $administrador = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    echo "Erro " . $erro->getMessage();
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

            <i class="drop fa-solid fa-caret-up"></i>
            <div class="logout">
                <a href="logout.php">Sair</a>
            </div>
        </div>


    </header>


    <section class="main">
        <div class="sidebar">
            <h3>Home</h3>
            <nav>
                <ul>
                    <li><a class="nav-prod product" href="painel_admin.php"><i class="fa-solid fa-house "></i>Produtos</a></li>
                    <li><a class="active" href="adms.php"><i class="fa-solid fa-house"></i>Users </a></li>
                    <li><a href="../register/register.html"><i class="fa-solid fa-house"></i>Register</a></li>
                    <li><a href="#"><i class="fa-solid fa-house"></i>Relatorios</a></li>
                    <hr>
                </ul>
            </nav>


        </div> <!--Fim sidebar-->

        <div class="content">
            <div class="container_center">
                <div class="cad_produtos">
                    <a href="cadastrar_produto.php"> <button class="btn_cad">Cadastrar produto</button> </a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Senha</th>
                            <th>ADM Ativo</th>
                            <th>Ações</th> <!-- Adicionando uma coluna para as ações -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($administrador as $adms) { ?>
                            <tr>
                                <td><?php echo $adms['id']; ?></td>
                                <td><?php echo $adms['ADM_NOME']; ?></td>
                                <td><?php echo $adms['ADM_SENHA']; ?></td>
                                <td><?php echo $adms['ADM_ATIVO']; ?></td>
                                <td>
                                    <a class="btn_edit" href="editar_produto.php?id=<?php echo $adms['id']; ?>">Editar</a>
                                    <a class="btn_exc" href="excluir_produto.php?id=<?php echo $adms['id']; ?>">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


    </section>



    <script src="https://kit.fontawesome.com/482af9f33c.js" crossorigin="anonymous"></script>
    <script src="js/javinha.js"></script>