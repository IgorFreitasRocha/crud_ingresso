//Função para gerar mensagem de confirmação ao cadastrar/atualizar
let contentdiv = document.getElementById('messagee');
      setTimeout(() => {
         contentdiv.style.display = 'none';
      },3500);




//Botão de ativo e intativo em exibir produtos
   let active = true;

  function toggleStatus() {
    const activeButton = document.querySelector('.btn-primary');
    const inactiveButton = document.querySelector('.btn-danger');

    if (active) {
      activeButton.classList.remove('active');
      inactiveButton.classList.add('active');
      active = false;
    } else {
      activeButton.classList.add('active');
      inactiveButton.classList.remove('active');
      active = true;
    }
  }