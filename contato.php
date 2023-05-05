<?php
function isUserLoggedIn(): bool {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

//Inicia a sessao
session_start();

//Checa se o formulaio de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') :
    require_once "login.php"; 
    //executa login de usuario
endif;

// Cabeçalho
if(isUserLoggedIn()):
	require_once 'header_loggedin.php';
else:
	require_once 'header.php';
endif;

?>

<main>
  <section class="bg-gray-100 py-16">
    <div class="container mx-auto">
      <h2 class="text-3xl font-bold mb-8 text-center">Contato</h2>
      <div class="flex flex-wrap">
        <div class="w-full md:w-2/3 md:pr-8">
          <form>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="nome">
                Nome completo
              </label>
              <input
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="nome" type="text" placeholder="Seu nome completo">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="email">
                E-mail
              </label>
              <input
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" type="email" placeholder="Seu e-mail">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="assunto">
                Assunto
              </label>
              <input
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="assunto" type="text" placeholder="Assunto da mensagem">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="mensagem">
                Mensagem
              </label>
              <textarea
                class="no-resize appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="mensagem" placeholder="Digite sua mensagem"></textarea>
            </div>
            <div class="flex items-center justify-between">
              <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="button">
                Enviar mensagem
              </button>
            </div>
          </form>
        </div>
        <div class="w-full md:w-1/3">
          <h4 class="text-xl font-bold mb-4">Informações de contato</h4>
          <p class="mb-2"><i class="fas fa-phone-alt mr-2"></i>(11) 9999-9999</p>
          <p class="mb-2"><i class="fas fa-envelope mr-2"></i>contato@meusite.com</p>
          <p><i class="fas fa-map-marker-alt mr-2"></i>Rua do Comércio, 123</p>
        </div>
      </div>
    </div>
  </section>

</main>
</body>
<?php
require_once "footer.php";
?>