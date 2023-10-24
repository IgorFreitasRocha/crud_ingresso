<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
  <h2>Tela de login adm</h2>

  <form action="CRUD/processa_login.php" method="post">
    <label for="nome">Nome : </label>
    <input type="text" name="nome" required>
    <br>
    <label for="senha">Senha : </label>
    <input type="text" name="senha" id="senha" required>
    <i class="fa-solid fa-eye"></i>
    <br>
    <input type="submit" value="entrar">
     <?php

          if(isset($_GET['erro'])){
            echo '<p style = "color:red;" > Nome de usuario ou senha incorretos</p>';       
          }

     ?>
  </form>


  <script src="https://kit.fontawesome.com/482af9f33c.js" crossorigin="anonymous"></script>
</body>
</html>