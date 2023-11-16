<?php
session_start();

//Varificação se o usuario está logado
require_once('../valida_login.php');
//Conexão com banco de dados
require_once('../conexao.php');

// Bloco de consulta para buscar categorias.
try {
  $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
  $stmt_categoria->execute();
  $categoria = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
  echo "<div id='messagee'>Erro ao buscar categoria " . $erro->getMessage() . "</div>";
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['id'])) {
    $PRODUTO_ID = $_GET['id'];

    try {
      $stmt_produto = $pdo->prepare(
        "SELECT
        p.PRODUTO_ID,
        p.PRODUTO_NOME, 
        p.PRODUTO_DESC, 
        p.PRODUTO_PRECO,
        p.PRODUTO_DESCONTO,
        p.CATEGORIA_ID,
        p.PRODUTO_ATIVO,
        p.CATEGORIA_ID,
        c.CATEGORIA_NOME,
        pe.PRODUTO_QTD
      FROM PRODUTO AS p
      INNER JOIN CATEGORIA AS c ON c.CATEGORIA_ID = p.CATEGORIA_ID
      INNER JOIN PRODUTO_ESTOQUE as pe ON pe.PRODUTO_ID = p.PRODUTO_ID
      WHERE p.PRODUTO_ID = :PRODUTO_ID
      "
      );

      $stmt_produto->bindParam(':PRODUTO_ID', $PRODUTO_ID, PDO::PARAM_INT);
      $stmt_produto->execute();
      $produto = $stmt_produto->fetch(PDO::FETCH_ASSOC);

      $sql_imagem = "SELECT
        IMAGEM_ID,
        IMAGEM_URL
        FROM PRODUTO_IMAGEM 
        WHERE PRODUTO_ID = :PRODUTO_ID
      ";

      $stmt_imagem = $pdo->prepare($sql_imagem);
      $stmt_imagem->bindParam(':PRODUTO_ID', $PRODUTO_ID, PDO::PARAM_INT);
      $stmt_imagem->execute();

      $imagens = $stmt_imagem->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
      echo "Erro: " . $erro->getMessage();
    }
  } else {
    header('Location: listar_produto.php');
    exit();
  }
}

// Se o formulário de edição foi submetido, a página é acessada via método POST, e o script tenta atualizar os detalhes do produto no banco de dados com as informações fornecidas no formulário.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $PRODUTO_NOME = $_POST['PRODUTO_NOME'];
  $PRODUTO_DESC = $_POST['PRODUTO_DESC'];
  $PRODUTO_PRECO = $_POST['PRODUTO_PRECO'];
  $PRODUTO_DESCONTO = $_POST['PRODUTO_DESCONTO'];
  $CATEGORIA_ID = $_POST['CATEGORIA_ID'];
  $PRODUTO_ATIVO = $_POST['PRODUTO_ATIVO'];
  $PRODUTO_ID = $_POST['PRODUTO_ID'];

  try {
    $stmt_produto = $pdo->prepare("UPDATE PRODUTO
      SET PRODUTO_NOME = :PRODUTO_NOME,
          PRODUTO_DESC = :PRODUTO_DESC,
          PRODUTO_PRECO = :PRODUTO_PRECO,
          PRODUTO_DESCONTO = :PRODUTO_DESCONTO,
          CATEGORIA_ID = :CATEGORIA_ID,
          PRODUTO_ATIVO = :PRODUTO_ATIVO
      WHERE PRODUTO_ID = :PRODUTO_ID
      ");
    $stmt_produto->bindParam(':PRODUTO_NOME', $PRODUTO_NOME);
    $stmt_produto->bindParam(':PRODUTO_DESC', $PRODUTO_DESC);
    $stmt_produto->bindParam(':PRODUTO_PRECO', $PRODUTO_PRECO);
    $stmt_produto->bindParam(':PRODUTO_DESCONTO', $PRODUTO_DESCONTO);
    $stmt_produto->bindParam(':CATEGORIA_ID', $CATEGORIA_ID);
    $stmt_produto->bindParam(':PRODUTO_ATIVO', $PRODUTO_ATIVO, PDO::PARAM_INT);
    $stmt_produto->bindParam(':PRODUTO_ID', $PRODUTO_ID, PDO::PARAM_INT);
    $stmt_produto->execute();

    echo "<div id='messagee'>Editado com sucesso </div>";
    header('Location: listar_produto.php');
    exit();
  } catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
  }
}


require_once('../layouts/inicio.php');
?>

<div class="card shadow-lg mx-4 card-profile-bottom">
  <div class="card-body p-3">
    <div class="row gx-4">
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img src= "<?php $imagem['IMAGEM_URL']?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
        </div>
      </div>
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1">
            Nome do Produto
          </h5>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0">Editar Produto</p>
            <button class="btn btn-danger btn-sm ms-auto">Delete</button>
          </div>
        </div>
        <div class="card-body">
          <div>
            <form class="row" action="editar_produto.php" method="POST" enctype="multipart/form-data">
              <div class="col-md-12 d-none">
                <div class="form-group">
                  <label for="PRODUTO_ID" class="form-control-label"> Id do Produto</label>
                  <input class="form-control" type="text" name="PRODUTO_ID" id="PRODUTO_ID" value="<?= $produto['PRODUTO_ID'] ?>" required readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="PRODUTO_NOME" class="form-control-label"> Nome do Produto</label>
                  <input class="form-control" type="text" name="PRODUTO_NOME" id="PRODUTO_NOME" value="<?= $produto['PRODUTO_NOME'] ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="PRODUTO_DESC" class="form-control-label">Descrição</label>
                  <textarea class="form-control" name="PRODUTO_DESC" id="PRODUTO_DESC" required><?= $produto['PRODUTO_DESC'] ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="PRODUTO_QTD" class="form-control-label">Quantidade</label>
                  <input class="form-control" type="number" name="PRODUTO_QTD" id="PRODUTO_QTD" value="<?= $produto['PRODUTO_QTD'] ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="CATEGORIA_NOME" class="form-control-label">Categoria</label>
                  <select class="form-control" type="text" name="CATEGORIA_ID" id="CATEGORIA_NOME">
                    <?php foreach ($categoria as $categorias) { // Loop para preencher o dropdown de categorias. 
                    ?>
                      <option class="form-control" value="<?= $categorias['CATEGORIA_ID'] ?>"><?= $categorias['CATEGORIA_NOME'] ?></option>
                    <?php }; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="PRODUTO_PRECO" class="form-control-label">Preço</label>
                  <input class="form-control" type="number" name="PRODUTO_PRECO" id="preco" step="0.01" value="<?= $produto['PRODUTO_PRECO'] ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="PRODUTO_DESCONTO" class="form-control-label">Desconto</label>
                  <input class="form-control" type="number" name="PRODUTO_DESCONTO" id="PRODUTO_DESCONTO" step="0.01" value="<?= $produto['PRODUTO_DESCONTO'] ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="PRODUTO_ATIVO">Status</label>
                  <select class="form-control" name="PRODUTO_ATIVO" id="PRODUTO_ATIVO" value="<?= $produto['PRODUTO_ATIVO'] ?>" required>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="IMAGEM_URL" class="form-control-label">URL da Imagem</label>
                  <input class="form-control" type="file" id="addImagem">


                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <div id="containerImagens">
                    <?php foreach ($imagens as $imagem) { ?>
                      <div class="input-group mb-3">
                        <input class="form-control" type="text" name="IMAGEM_URL" id="IMAGEM_URL_<?php echo $imagem['IMAGEM_ID'] ?>" value="<?= $imagem['IMAGEM_URL'] ?>" readonly>
                        <button class="btn mb-0" type="button" id="remover" onclick="removerInputImagem(this)">Remover</button>
                      </div>

                    <?php } ?>
                  </div>
                </div>
              </div>

              <input class="btn btn-danger btn-sm ms-auto" type="submit" value="Editar">
            </form>
          </div>
          <hr class="horizontal dark">
        </div>
      </div>
    </div>
  </div>
</div>
<!--Ativar a class de ativo no menu de navegação-->
<script>
  let navegaa = document.getElementById('nevega2');
  navegaa.classList.add('active');
</script>

<script>
  document.querySelector("#CATEGORIA_NOME").value = <?php echo $produto['CATEGORIA_ID']  ?>;

  document.querySelector("#PRODUTO_ATIVO").value = <?php echo $produto['PRODUTO_ATIVO']  ?>;

  const addImagem = document.getElementById("addImagem");

  function adicionarImagem(url) {
    const containerImagens = document.getElementById('containerImagens');

    const inputgroup = document.createElement('div');
    inputgroup.className = "input-group mb-3"

    const imagem = document.createElement('input');
    imagem.readOnly = true;
    imagem.type = 'text';
    imagem.name = 'imagem_url[]';
    imagem.className = 'form-control';
    imagem.value = url; //alterar para a url do imgur

    const remover = document.createElement('button');
    remover.className = "btn mb-0"
    remover.innerText = 'Remover'
    remover.onclick = function() {
      removerInputImagem(remover);
    };

    inputgroup.appendChild(imagem);
    inputgroup.appendChild(remover);

    containerImagens.appendChild(inputgroup);

    addImagem.value = "";
  }

  function removerInputImagem(remover) {
    remover.parentNode.remove();
  }
</script>

<?php require_once('../layouts/fim.php'); ?>