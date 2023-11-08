<?php
session_start();

//Varificação se o usuario está logado
require_once('../valida_login.php');
//Conexão com banco de dados
require_once('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['PRODUTO_ID'])) {
    $PRODUTO_ID = $_GET['PRODUTO_ID'];
    try {
      $stmt_produto = $pdo->prepare(
      "SELECT
        PRODUTO_NOME,
        PRODUTO_DESC,
        PRODUTO_PRECO,
        PRODUTO_DESCONTO,
        CATEGORIA_ID,
        PRODUTO_ATIVO
      FROM produto
      WHERE PRODUTO_ID = :PRODUTO_ID
      "); 

      $stmt_produto->bindParam(':PRODUTO_ID', $PRODUTO_ID, PDO::PARAM_INT);
      $stmt_produto->execute();
      $produto = $stmt_produto->fetch(PDO::FETCH_ASSOC);

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

  try {
    $stmt_produto = $pdo->prepare("UPDATE produto
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
    $stmt_produto->bindParam(':PRODUTO_ATIVO', $PRODUTO_ATIVO);
    $stmt_produto->bindParam(':PRODUTO_ID', $PRODUTO_ID);
    $stmt_produto->execute();


    echo "<div id='messagee'>Cadastrado com sucesso</div>";
    header('Location: painel_admin.php');
    exit();
  } catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
  }
}




?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <link rel="stylesheet" href="../assets/css/mensagem.css">
  <script src="../js/javinha.js"></script>
  <title>
    Editar produto
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
        <img src="../assets/img/logobravo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Bravo Ticket</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link " href="../pages/dashboard.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/listar_prdoduto.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Produtos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/listar_admin.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Administradores</span>
          </a>
        </li>
      </ul>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Editar produto</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Editar prdouto</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Buscar Produto...">
            </div>
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
    <div class="card shadow-lg mx-4 card-profile-bottom">
      <div class="card-body p-3">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="../assets/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
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
                <form class="row" action="editar_produto.php" method="post" enctype="multipart/form-data">
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
                      <select class="form-control" type="text" name="CATEGORIA_NOME" id="CATEGORIA_NOME">
                        <?php foreach ($categoria as $categorias) { // Loop para preencher o dropdown de categorias. 
                        ?>
                          <option class="form-control" value="<?= $categorias['CATEGORIA_NOME'] ?>"><?= $categorias['CATEGORIA_NOME'] ?></option>
                        <?php }; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="PRODUTO_PRECO" class="form-control-label">Preço</label>
                      <input class="form-control" type="number" name="preco" id="preco" step="0.01" value="<?= $produto['PRODUTO_PRECO'] ?>" required>
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
                      <label for="IMAGEM_URL" class="form-control-label">URL da Imagem</label>
                      <div id="containerImagens">
                        <input class="form-control" type="text" name="IMAGEM_URL" required id="IMAGEM_URL" value="<?= $produto['IMAGEM_URL'] ?>" required>
                      </div>
                      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adicionarImagem()">Adicionar mais imagens</button>
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
                  <input class="btn btn-danger btn-sm ms-auto" type="submit" value="Cadastrar">
                </form>
              </div>
              <hr class="horizontal dark">
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="fixed-plugin">
      <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
      </a>
      <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3 ">
          <div class="float-start">
            <h5 class="mt-3 mb-0">Argon Configurator</h5>
            <p>See our dashboard options.</p>
          </div>
          <div class="float-end mt-4">
            <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
              <i class="fa fa-close"></i>
            </button>
          </div>
          <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body pt-sm-3 pt-0 overflow-auto">
          <!-- Sidebar Backgrounds -->
          <div>
            <h6 class="mb-0">Sidebar Colors</h6>
          </div>
          <a href="javascript:void(0)" class="switch-trigger background-color">
            <div class="badge-colors my-2 text-start">
              <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
              <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
              <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
              <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
              <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
              <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
            </div>
          </a>
          <!-- Navbar Fixed -->
          <hr class="horizontal dark my-sm-4">
          <div class="mt-2 mb-5 d-flex">
            <h6 class="mb-0">Light / Dark</h6>
            <div class="form-check form-switch ps-0 ms-auto my-auto">
              <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
            </div>
          </div>
        </div>
      </div>
    </div>
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