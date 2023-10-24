<?php
//uma sessão é iniciada e verifica-se se um administrador está logado. Se não estiver, ele é redirecionado para a página de login.
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: logout.php');
    exit();
}

//o script faz uma conexão com o banco de dados, usando os detalhes de configuração especificados em conexao.php
require_once('conexao.php');

// Se a página foi acessada via método GET, o script tenta recuperar os detalhes do adms com base no ID passado na URL.
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM administrador WHERE id = :id");//Quando você executa uma consulta SELECT no banco de dados usando PDO e utiliza o método fetch(PDO::FETCH_ASSOC), o resultado é um array associativo, onde cada chave do array é o nome de uma coluna da tabela no banco de dados, e o valor associado a essa chave é o valor correspondente daquela coluna para o registro selecionado
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $adms = $stmt->fetch(PDO::FETCH_ASSOC);//$adms é um array associativo que contém os detalhes do adms que foi recuperado do banco de dados. Por exemplo, se a tabela de admss tem colunas como ID, NOME, DESCRICAO, PRECO, e URL_IMAGEM, então o array $adms terá essas chaves, e você pode acessar os valores correspondentes usando a sintaxe de colchetes, 
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    } else {
        header('Location: listar_adms.php');
        exit();
    }
}

// Se o formulário de edição foi submetido, a página é acessada via método POST, e o script tenta atualizar os detalhes do adms no banco de dados com as informações fornecidas no formulário.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['ADM_NOME'];
    $descricao = $_POST['ADM_SENHA'];
    $preco = $_POST['ADM_ATIVO'];

    try {
        $stmt = $pdo->prepare("UPDATE administrador SET ADM_NOME = :ADM_NOME, ADM_SENHA = :ADM_SENHA, ADM_ATIVO = :ADM_ATIVO, WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':ADM_NOME', $ADM_NOME, PDO::PARAM_STR);
        $stmt->bindParam(':ADM_SENHA', $ADM_SENHA, PDO::PARAM_STR);
        $stmt->bindParam(':ADM_ATIVO', $ADM_ATIVO, PDO::PARAM_STR);
        $stmt->execute();

        header('Location: painel_admin.php');
        exit();
    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }
}
?>
<!-- Um formulário de edição é apresentado ao administrador, preenchido com os detalhes atuais do adms, permitindo que ele faça modificações e submeta o formulário para atualizar os detalhes do adms -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar administrador</title>
</head>
<body>
<h2>Editar administrador</h2>
<form action="editar_adms.php" method="post">
    <input type="hidden" name="id" value="<?php echo $adms['id']; ?>"> 
    <!-- Essa linha cria um campo de entrada (input) oculto no formulário. Um campo de entrada oculto é usado quando você quer incluir um dado no formulário que não precisa ser visível ou editável pelo usuário, mas que precisa ser enviado junto com os outros dados quando o formulário é submetido. -->
    <label for="ADM_NOME">Adiministrador Nome:</label>
    <input type="text" name="ADM_NOME" id="ADM_NOME" value="<?php echo $adms['ADM_NOME']; ?>"><br>
    <label for="ADM_SENHA">Senha do administrador:</label>
    <input name="ADM_SENHA" id="ADM_SENHA"><?php echo $adms['ADM_SENHA']; ?></input><br>
    <label for="ADM_ATIVO">Adiministrador Ativo/inativo:</label>
    <input type="text" name="ADM_ATIVO" id="ADM_ATIVO" value="<?php echo $adms['ADM_ATIVO']; ?>"><br>
    <input type="submit" value="Atualizar administrador">
</form>
<a href="adms.php">Voltar à Lista de administradores</a>



<script src="js/javinha.js"></script>
</body>
</html>