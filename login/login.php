<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../crud_ingresso/assets/img/logo/letra-b.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="login.css">
        <title>Ingressos</title>
    </head>
    <body>
        
        <!-- Card com campos de e-mail, senha e botão de submit -->
        <div class="card card border-warning mb-3 card text-center position-absolute top-50 start-50 translate-middle" style="width: 18rem;">
            <div class="card-body">
                <img src="../assets/img/logo/logo (7).jpg" class="card-img-top" alt="...">
                <h6 class="card-subtitle p-2 text-muted">Faça seu login</h6>

              <form action="" class="validacao" novalidate>
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="validationCustom01" placeholder="name@example.com" required>
                    <label for="validationCustom01">E-mail</label>
                    <div class="invalid-feedback">Preencha com um e-mail válido.</div>

                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="validationCustom02" placeholder="Senha" required>
                    <label for="validationCustom02">Senha</label>
                    <div class="invalid-feedback">Preencha com uma senha válida.</div>
                    <button type="submit" class="btn btn-outline-warning btn-lg p-2 g-col-6">Entrar</button>
                    </div>

              </form>
              </div>
            </div>
          </div>

        <!-- Scripts de ações do Boostrap e validação dos campos digitados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script> 
    <script src="../assets/script/validacao.js"></script>
    </body>
</html>