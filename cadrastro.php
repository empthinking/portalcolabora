<?php
require_once "header.php"
  ?>
<main>
        <section class="bg-gray-100 py-8">
            <div class="container mx-auto">
              <div class="max-w-lg mx-auto">
                <h2 class="text-3xl font-semibold text-center mb-8">Cadastre-se</h2>
                <form class="bg-white shadow-md  rounded-lg w-full max-w-md mx-auto p-8" method="POST" action="register">
                  <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="nome">
                        Nome completo
                      </label>
                      <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" type="text" placeholder="Seu nome completo">
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="email">
                        Email
                      </label>
                      <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Seu endereço de email">
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="senha">
                        Senha
                      </label>
                      <input class="password-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="senha" type="password" placeholder="Sua senha">
                      <p class="text-gray-600 text-xs italic">Sua senha deve ter pelo menos 8 caracteres.</p>
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="confirma-senha">
                        Confirme sua senha
                      </label>
                      <input class="password-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="confirma-senha" type="password" placeholder="Confirme sua senha">
                    </div>
                    <button type="button" id="showPassword">Mostrar senha</button>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="telefone">
                        Telefone
                      </label>
                      <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telefone" type="text" placeholder="Seu número de telefone">
                    </div>
                    <div class="flex items-center justify-between">
                      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                        Cadastrar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </section>
        </main>
      </body>
      <script>
      var showPasswordBtn = document.querySelector('.show-password-btn');
var passwordInput = document.querySelector('.password-input');

showPasswordBtn.addEventListener('click', function() {
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    showPasswordBtn.textContent = 'Ocultar senha';
  } else {
    passwordInput.type = 'password';
    showPasswordBtn.textContent = 'Mostrar senha';
  }
});

</script>
</html>                  