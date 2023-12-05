//Função para gerar mensagem de confirmação ao cadastrar/atualizar
let contentdiv = document.getElementById('messagee');
      setTimeout(() => {
         contentdiv.style.display = 'none';
      },3500);


//Mensagem para limite de 500 caracteres em URL de produtos 
function checkLength() {
   var texto = document.getElementById('texto').value;
   var mensagem = document.getElementById('mensagem');

   if (texto.length > 500) {
       mensagem.style.display = 'block';
   } else {
       mensagem.style.display = 'none';
   }
}