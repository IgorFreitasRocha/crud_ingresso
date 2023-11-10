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
function buscarImagens($pdo, $produto_id){
  $sql = "SELECT
    IMAGEM_ID,
    IMAGEM_URL
    FROM PRODUTO_IMAGEM 
    WHERE PRODUTO_ID = :PRODUTO_ID
  ";
  $stmt = $pdo->prepare($sql); 
  $stmt->bindParam(':PRODUTO_ID', $produto_id, PDO::PARAM_INT);
  $stmt->execute();
  $imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $imagens;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Listar Produtos
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

<body class="g-sidenav-show   bg-gray-100">
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
          <a class="nav-link active" href="../pages/listar_produto.php">
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
        <li class="nav-item">
          <a class="nav-link" href="../pages/editar_produto.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Editar produto</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/cadastrar_produto.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Cadastrar produto</span>
          </a>
        </li>
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Produto</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Produtos</h6>
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
                    <?php foreach ($produtos as $produto) {
                    ?>
                      <tr>
                        <td class="align-middle text-center">
                          <?php echo $produto['PRODUTO_NOME']; ?>
                        <td class="align-middle text-center">
                          <?php echo $produto['PRODUTO_DESC']; ?>
                        </td>
                        </td>
                        <td class="align-middle text-center">
                          <?php echo $produto['CATEGORIA_NOME']; ?>
                        </td>
                        <td class="align-middle text-center">
                          <?php echo $produto['PRODUTO_QTD']; ?>
                        </td>
                        <td class="align-middle text-center">
                          <?php echo "R$ " . $produto['PRODUTO_PRECO']; ?>
                        </td>
                        <td class="align-middle text-center">
                          <?php echo "R$ " . ($produto['PRODUTO_PRECO'] - $produto['PRODUTO_DESCONTO']); ?>
                        </td>
                        <td class="align-middle text-center">
                          <?php 
                          $imagens = buscarImagens($pdo, $produto['PRODUTO_ID']); 
                          foreach($imagens as $imagem){
                          ?>
                            <img src="<?php echo $imagem['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" width="50">
                          <?php } ?>
                        </td>
                        <td class="align-middle text-center">
                        <?php
                          if($produto['PRODUTO_ATIVO']) {
                            echo'<span class="statusUser badge badge-sm bg-gradient-success">Ativo</span>';
                          }else{
                            echo'<span class="statusUser badge badge-sm bg-gradient-secondary">Inativo</span>';
                          };
                          ?>
                        </td>
                        <td class="align-middle text-center">
                          <a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID'];?>" class="btn badge badge-sm bg-gradient-primary" data-toggle="tooltip" data-original-title="Edit user">
                            Editar
                          </a>
                        </td>
                        <td class="align-middle text-center">
                        <a href="deletar_produto.php?PRODUTO_ID=<?php echo $produto['PRODUTO_ID'];?>" class="btn badge badge-sm bg-gradient-danger" data-toggle="tooltip" data-original-title="Edit user">
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
        <div class="d-flex my-3">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
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