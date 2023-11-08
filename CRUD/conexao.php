<?php

    //Configurações do banco de dados

    $host = 'localhost';  //Alterar aqui o servidor do banco de dados
    $db = 'crud';  // Nome do banco a ser usado 
    $user = 'root';  //Usuario do banco de dados
    $pass = '';  //Senha do banco de dados 
    $charset = 'utf8mb4';  // Conjunto de caracteres

    $dsn = "mysql:host=$host;dbname=$db;$charset";

    //Criando a conexão com o banco de dados através do PDO 
try{
    $pdo = new PDO($dsn, $user, $pass);

}catch(PDOException $erro){
        echo "Erro ao tentar conectar com o banco de dados <p> .$erro";
    };

/*fUNÇÃO PARA GERAR IMAGENS */
function buscarImagens($pdo, $produto_id){
    $sql = "SELECT
      IMAGEM_URL
      FROM produto_imagem 
      WHERE PRODUTO_ID = :PRODUTO_ID
    ";
    $stmt = $pdo->prepare($sql); 
    $stmt->bindParam(':PRODUTO_ID', $produto_id, PDO::PARAM_INT);
    $stmt->execute();
    $imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    return $imagens;
  }
?>