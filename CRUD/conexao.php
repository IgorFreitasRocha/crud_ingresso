<?php

    //Configurações do banco de dados

    $host = '144.22.157.228';  //Alterar aqui o servidor do banco de dados
    $db = 'Bravo';  // Nome do banco a ser usado 
    $user = 'Bravo';  //Usuario do banco de dados
    $pass = 'Bravo';  //Senha do banco de dados 
    $charset = 'utf8mb4';  // Conjunto de caracteres

    $dsn = "mysql:host=$host;dbname=$db;$charset";

    //Criando a conexão com o banco de dados através do PDO 
try{
    $pdo = new PDO($dsn, $user, $pass);

}catch(PDOException $erro){
        echo "Erro ao tentar conectar com o banco de dados <p> .$erro";
    };

?>