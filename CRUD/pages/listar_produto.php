<?php
session_start();
//Requisiçao com banco de dados 
require_once('../conexao.php');
//Valida se o usuario está logado 
require_once('../valida_login.php');

try {
  $stmt = $pdo->prepare("SELECT
    p.PRODUTO_ID,
    p.PRODUTO_NOME, 
    p.PRODUTO_DESC, 
    p.PRODUTO_PRECO,
    p.PRODUTO_DESCONTO,
    p.CATEGORIA_ID,
    p.PRODUTO_ATIVO,
    c.CATEGORIA_NOME,
    pe.PRODUTO_QTD
    FROM PRODUTO AS p
    LEFT JOIN CATEGORIA AS c ON c.CATEGORIA_ID = p.CATEGORIA_ID
    LEFT JOIN PRODUTO_ESTOQUE as pe ON pe.PRODUTO_ID = p.PRODUTO_ID
  ");
  $stmt->execute();
  $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
  echo "Erro " . $erro->getMessage();
}

/*FUNÇÃO PARA GERAR IMAGENS */
function buscarImagens($pdo, $produto_id)
{
  $sql = "SELECT
    IMAGEM_ID,
    IMAGEM_URL,
    IMAGEM_ORDEM
    FROM PRODUTO_IMAGEM 
    WHERE PRODUTO_ID = :PRODUTO_ID AND IMAGEM_ORDEM >= 0
  ";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':PRODUTO_ID', $produto_id, PDO::PARAM_INT);
  $stmt->execute();
  $imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $imagens;
}

//Trazer buscas feitas em produto pelo usuario
if (isset($_GET['busca'])){
  try {
    $pesquisa = $_GET['busca'];
    $stmt_busca = $pdo->prepare("SELECT
    p.PRODUTO_ID,
    p.PRODUTO_NOME, 
    p.PRODUTO_DESC, 
    p.PRODUTO_PRECO,
    p.PRODUTO_DESCONTO,
    p.CATEGORIA_ID,
    p.PRODUTO_ATIVO,
    c.CATEGORIA_NOME,
    pe.PRODUTO_QTD
    FROM PRODUTO AS p
    LEFT JOIN CATEGORIA AS c ON c.CATEGORIA_ID = p.CATEGORIA_ID
    LEFT JOIN PRODUTO_ESTOQUE as pe ON pe.PRODUTO_ID = p.PRODUTO_ID
    WHERE p.PRODUTO_NOME LIKE '%$pesquisa%'");
    // Executa a consulta preparada
    $stmt_busca->execute();
    // Obtém todos os resultados da consulta como um array de arrays associativos
    $resultados_busca = $stmt_busca->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $erro) {
    echo "Erro " . $erro->getMessage(); // Exibe a mensagem de erro caso ocorra uma exceção
  }
}
?>
<?php require_once('../layouts/inicio.php'); ?>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Produto</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">Produtos</h6>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <form action="">
            <div class="input-group">
              <input name="busca" class="form-control" placeholder="Buscar Produto..." type="text"> 
              <button type="submit" class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></button>
            </div>
          </form>
      </div>
      <ul class="navbar-nav  justify-content-end">
        <li class="nav-item d-flex align-items-center">
          <a href="../logout.php" class="nav-link text-white font-weight-bold px-0">
            <i class="fa fa-user me-sm-1"></i>
            <span class="d-sm-inline d-none">Logout</span>
          </a>
        </li>
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-body d-flex justify-content-between">
          <div>
            <h6 class="card-link">Produtos</h6>
          </div>
          <a href="cadastrar_produto.php" class="card-link btn btn-danger btn-sm ms-auto">Cadastrar Produtos</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Nome</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Descrição</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Categoria</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Qtd</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Preço</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Preço com desconto</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Imagem</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Status</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Editar</th>

                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Remover</th>

                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($_GET['busca'])){
                  $produtos = $resultados_busca;
                } ?>
                <?php foreach ($produtos as $produto) {
                ?>
                  <tr>
                    <td class="align-middle text-center">
                      <?php echo $produto['PRODUTO_NOME']; ?>
                    </td>
                      <td style="font-size: 0.8rem;" class="align-middle text-center">
                      <?php 
                        $texto = $produto['PRODUTO_DESC'];
                        $limiteCaracteres = 30;
                        if (strlen($texto) > $limiteCaracteres) {
                          $texto = substr($texto, 0, $limiteCaracteres) . "...";
                        }
                        echo $texto;
                      ?>
                    </td>
                    <td style="font-size: 0.8rem;" class="align-middle text-center">
                      <?php echo $produto['CATEGORIA_NOME']; ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php echo $produto['PRODUTO_QTD']; ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php echo "R$" . $produto['PRODUTO_PRECO']; ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php echo "R$" . ($produto['PRODUTO_PRECO'] - $produto['PRODUTO_DESCONTO']); ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php
                      $imagens = buscarImagens($pdo, $produto['PRODUTO_ID']);
                        foreach ($imagens as $imagem) {
                          ?>
                          <img src="<?php echo $imagem['IMAGEM_URL']; ?>" alt="<?php echo htmlspecialchars($produto['PRODUTO_NOME']); ?>" width="60" onerror="this.onerror=null;this.src='https://alumfer.com.br/assets/alumfer/imagens/not-available.png';this.alt='Img erro'">
                          <?php
                        }
                      ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php
                      if ($produto['PRODUTO_ATIVO']) {
                        echo '<span class="statusUser badge badge-sm bg-gradient-success">Ativo</span>';
                      } else {
                        echo '<span class="statusUser badge badge-sm bg-gradient-secondary">Inativo</span>';
                      };
                      ?>
                    </td>
                    <td class="align-middle text-center">
                      <a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="btn badge badge-sm bg-gradient-primary" data-toggle="tooltip" data-original-title="Edit user">
                        Editar
                      </a>
                    </td>
                    <td class="align-middle text-center">
                      <a href="deletar_produto.php?PRODUTO_ID=<?php echo $produto['PRODUTO_ID']; ?>" class="btn badge badge-sm bg-gradient-danger" data-toggle="tooltip" data-original-title="Edit user">
                        Remover
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
  <!--Ativar a class de ativo no menu de navegação-->
  <script>
    let navegaa = document.getElementById('nevega2');
    navegaa.classList.add('active');
  </script>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  </body>

  </html>