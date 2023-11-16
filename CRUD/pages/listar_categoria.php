<?php
session_start();

//Conexão com banco de dados
require_once('../conexao.php');
//Varificação se o usuario está logado
require_once('../valida_login.php');

if (isset($_GET['update']) && $_GET['update'] === 'success') {
  echo "<div id='messagee'>Categoria atualizada com sucesso!</div>";
}

try {
  $stmt = $pdo->prepare("SELECT 
    CATEGORIA_ID,
    CATEGORIA_NOME,
    CATEGORIA_DESC,
    CATEGORIA_ATIVO 
    FROM CATEGORIA
    ");
  $stmt->execute();
  $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
  echo "Erro " . $erro->getMessage();
}

?>
<?php require_once('../layouts/inicio.php'); ?>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Categoria</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">Categoria</h6>
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
    </div>
</nav>
<!-- End Navbar -->
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-body d-flex justify-content-between">
          <div>
            <h6 class="card-link">Categoria</h6>
          </div>
          <a href="cadastrar_categoria.php" class="card-link btn btn-danger btn-sm ms-auto">Cadastrar Categorias</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">ID</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Nome</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Descrição</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-middle">Status</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($categorias as $categoria) { ?>
                  <tr>
                    <td class="align-middle text-center">
                      <?php echo $categoria['CATEGORIA_ID']; ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php echo $categoria['CATEGORIA_NOME']; ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php echo $categoria['CATEGORIA_DESC']; ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php
                      if ($categoria['CATEGORIA_ATIVO'] == 0) {
                        echo '<span class="statusUser badge badge-sm bg-gradient-secondary">Inativo</span>';
                      } else {
                        echo '<span class="statusUser badge badge-sm bg-gradient-success">Ativo</span>';
                      };
                      ?>
                    </td>
                    <td class="align-middle text-center">
                      <a href="editar_categoria.php?CATEGORIA_ID=<?php echo $categoria['CATEGORIA_ID']; ?>" class="btn badge badge-sm bg-gradient-primary" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
                    </td>
                    <td class="align-middle text-center">
                      <a href="deletar_categoria.php?CATEGORIA_ID=<?php echo $categoria['CATEGORIA_ID']; ?>" class="btn badge badge-sm bg-gradient-danger" data-toggle="tooltip" data-original-title="Edit user">
                        Delete
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
    <!--Ativar a class de ativo no menu de navegação-->
    <script>
      let navegaa = document.getElementById('nevega4');
      navegaa.classList.add('active');
    </script>
    <?php require_once('../layouts/fim.php'); ?>