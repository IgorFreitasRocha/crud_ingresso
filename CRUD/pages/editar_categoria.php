<?php
session_start();
require_once('../conexao.php');

//Varificação se o usuario está logado
require_once('../valida_login.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['CATEGORIA_ID'])) {
        $CATEGORIA_ID = $_GET['CATEGORIA_ID'];
        try {
            $stmt = $pdo->prepare(
                "SELECT *
            FROM CATEGORIA
            WHERE CATEGORIA_ID = :CATEGORIA_ID"
            );
            $stmt->bindParam(':CATEGORIA_ID', $CATEGORIA_ID, PDO::PARAM_INT);
            $stmt->execute();
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    } else {
        header('Location: listar_categoria.php');
        exit();
    }
}

// Se o formulário de edição foi submetido, a página é acessada via método POST, e o script tenta atualizar os detalhes do categoria no banco de dados com as informações fornecidas no formulário.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CATEGORIA_ID = $_POST['CATEGORIA_ID'];
    $CATEGORIA_NOME = $_POST['CATEGORIA_NOME'];
    $CATEGORIA_DESC = $_POST['CATEGORIA_DESC'];
    $CATEGORIA_ATIVO = $_POST['CATEGORIA_ATIVO'];

    try {
        $stmt = $pdo->prepare(
            "UPDATE CATEGORIA
            SET CATEGORIA_NOME = :CATEGORIA_NOME,
                CATEGORIA_DESC = :CATEGORIA_DESC, 
                CATEGORIA_ATIVO = :CATEGORIA_ATIVO 
          WHERE CATEGORIA_ID = :CATEGORIA_ID"
        );
        $stmt->bindParam(':CATEGORIA_ID', $CATEGORIA_ID, PDO::PARAM_INT);
        $stmt->bindParam(':CATEGORIA_NOME', $CATEGORIA_NOME, PDO::PARAM_STR);
        $stmt->bindParam(':CATEGORIA_DESC', $CATEGORIA_DESC, PDO::PARAM_STR);
        $stmt->bindParam(':CATEGORIA_ATIVO', $CATEGORIA_ATIVO, PDO::PARAM_INT);
        $stmt->execute();

        /*Parametro para mensagem de sucesso através de GET */
        header('Location: listar_categoria.php?update=success');
        exit();
    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }
}
?>
<?php require_once('../layouts/inicio.php'); ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Editar Categoria</p>
                        <a href="deletar_categoria.php?CATEGORIA_ID=<?php echo $categoria['CATEGORIA_ID']; ?>" class="btn btn-danger btn-sm ms-auto">Delete</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <form action="editar_categoria.php" method="POST">
                            <input type="hidden" name="CATEGORIA_ID" value="<?php echo $categoria['CATEGORIA_ID']; ?>">
                            <!-- Essa linha cria um campo de entrada (input) oculto no formulário. Um campo de entrada oculto é usado quando você quer incluir um dado no formulário que não precisa ser visível ou editável pelo usuário, mas que precisa ser enviado junto com os outros dados quando o formulário é submetido. -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="CATEGORIA_NOME" class="form-control-label">Nome da categoria</label>
                                    <input class="form-control" type="text" name="CATEGORIA_NOME" id="CATEGORIA_NOME" value="<?php echo $categoria['CATEGORIA_NOME']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="CATEGORIA_DESC" class="form-control-label">Descrição da categoria</label>
                                    <input class="form-control" type="text" name="CATEGORIA_DESC" id="CATEGORIA_DESC" value="<?php echo $categoria['CATEGORIA_DESC']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="CATEGORIA_ATIVO">Status</label>
                                <select class="form-control" name="CATEGORIA_ATIVO" id="CATEGORIA_ATIVO" value="<?php $categoria['CATEGORIA_ATIVO'] ?>">
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                            <input class="btn btn-danger btn-sm ms-auto" type="submit" value="Atualizar">
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
    <script>
        document.querySelector("#CATEGORIA_ATIVO").value = <?php echo $categoria['CATEGORIA_ATIVO']  ?>;
    </script>
    <script>
        let navegaa = document.getElementById('nevega4');
        navegaa.classList.add('active');
    </script>
    <?php require_once('../layouts/fim.php'); ?>