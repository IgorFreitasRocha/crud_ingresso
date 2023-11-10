<?php 
    session_start(); //inicia a sessão


    require_once('conexao.php'); //requisição do arquivo 


    $nome = $_POST['nome']; // busca no arquivo requerido
    $senha = $_POST['senha']; // busca no arquivo requerido

    $sql = "SELECT * FROM administrador WHERE ADM_NOME = :nome AND
    ADM_SENHA  = :senha AND ADM_ATIVO = 1";  //Comando sql para buscar na tabela ADMINISTRADOR o ADM_NOME e ADM_SENHA  e ADM_ATIVO



    $query = $pdo->prepare($sql);
    $query->bindParam(':nome', $nome, PDO::PARAM_STR);
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);

    $query->execute();  //PREPARAÇÃO DE SEGURANÇA


    if ($query->rowCount() > 0) {    //rowCount() = quantidade de linhas 
        $_SESSION['admin_logado'] = true;
        //direcione (header) o usuario para ../pages/dashboard.html
        header('Location: pages/dashboard.php');
    }else {
        header('Location: logout.php'); //Se não retorne para a pagina de login 
    }



    //Função para deslogar 

    function logout(){
        session_start();
        session_unset();
        session_destroy();
        header("location: ../login/index.php");
    }   


?>