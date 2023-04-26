<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'):
	require_once "login.php";
endif;
require_once "message_functions.php";
require_once "header.php";
?>

<main>
        <?php
        if(isset($_SESSION['error'])):
		echo errorMsg($_SESSION['error']);
            unset($_SESSION['error']);
        endif;
?>

<div class="flex items-center justify-centermt-  menu-overlay" >
        <div class="bg-white rounded-lg  m-64 mx-auto p-8">
          <h3 class="text-3xl font-bold">Perfil</h3>
        <figure class="mt-4">
          <img id="perfil" src="img/perfil.png" class="rounded-full w-32 h-32">
        </figure>
        <div class="mt-6">
          <h3 class="text-2xl font-bold">Nome</h3>
          <h3 class="text-3xl font-bold text-gray-500"><?php echo isUserLoggedIn() ? $_SESSION['username'] : '.'; ?></h3>
          <h3 class="text-2xl font-bold">Email</h3>
          <h3 class="text-3xl font-bold text-gray-500"><?php echo isUserLoggedIn() ? $_SESSION['email'] : '.'; ?></h3>
          <div id="btp" class="mt-4">
            <h3 class="text-2xl font-bold">Número</h3>
            <h3 class="text-3xl font-bold text-gray-500"><?php echo isUserLoggedIn() ? $_SESSION['number'] : '.'; ?></h3>
                     </div>
                     <br>

<button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('historicoProdutos').style.display='block'">Historico de Compra</button>
<div id="historicoProdutos" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900" style="opacity: 0.9;">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Historico de Compra</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
              </div>
              <div class="border-t border-gray-200">
                <dl>
                  <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Data da Compra
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      01/01/2022
                    </dd>
                  </div>
                  <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Total
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      R$ 100,00
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
                <button type="button" onclick="document.getElementById('historicoProdutos').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                Cancelar
                </button>
            </div>
            </div>
        </div> 
   
        <a href="/addProduto.php" class="mt-6">
  <button class="bg-green-400 text-white py-2 px-6 rounded-lg">Adiciona<br>produtos</button>
</a>



<button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('meusProdutos').style.display='block'">Meus Produtos</button>
<div id="meusProdutos" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900" style="opacity: 0.9;">
      <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Meus Produtos</h3>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
              </div>
              <div class="border-t border-gray-200">
                <dl>
                  <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Nome do Produto
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      Produto A
                    </dd>
                  </div>
                  <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Preço
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      R$ </dd>
        </div>
      </dl>
    </div>
  </div>
                <button type="button" onclick="document.getElementById('meusProdutos').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                Cancelar
                </button>
            </div>
            </div>
        </div>

</div>
</div>
</div>
    
      </main>
    </body>
</html>                
