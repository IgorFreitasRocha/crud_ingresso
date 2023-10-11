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
                    <li><a class="active nav-prod product" href="painel_admin.php"><i class="fa-solid fa-house "></i>Produtos</a></li>
                    <li><a href="../users/user.html"><i class="fa-solid fa-house"></i>Users </a></li>
                    <li><a href="../register/register.html"><i class="fa-solid fa-house"></i>Register</a></li>
                    <li><a href="#"><i class="fa-solid fa-house"></i>Relatorios</a></li>
                    <hr>
                </ul>
            </nav>


        </div> <!--Fim sidebar-->

        <div class="content">
            <div>
                <?php

                require_once('conexao.php');

                try {
                    $stmt = $pdo->prepare("SELECT * FROM produtos");
                    $stmt->execute();
                    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $erro) {
                    echo "Erro " . $erro->getMessage();
                }

                ?>
                <div class="cad_produtos">
                    <a href="cadastrar_produto.php"> <button class="btn_cad">Cadastra produto</button> </a>
                </div>
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
                                <td><?php echo $produto['id']; ?></td>
                                <td><?php echo $produto['nome']; ?></td>
                                <td><?php echo $produto['descricao']; ?></td>
                                <td><?php echo $produto['preco']; ?></td>
                                <td><?php echo $produto['imagem']; ?></td>
                                <td><img src="<?php echo $produto['url_imagem']; ?>" alt="Imagem do produto" width="50"></td>
                                <td>
                                    <a href="editar_produto.php?id=<?php echo $produto['id']; ?>">Editar</a>
                                    <a href="excluir_produto.php?id=<?php echo $produto['id']; ?>">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


    </section>



    <script src="https://kit.fontawesome.com/482af9f33c.js" crossorigin="anonymous"></script>
    <script src="javinha.js"></script>
</body>

</html>