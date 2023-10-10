<?php

    //Configurações do banco de dados

    $host = 'localhost';
    $db = 'crud';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;$charset";

    //Criando a conexão com o banco de dados através do PDO 
try{
    $pdo = new PDO($dsn, $user, $pass);

}catch(PDOException $erro){
        echo "Erro ao tentar conectar com o banco de dados <p> .$erro";
    };
    echo "Conexão funcionando";
?>