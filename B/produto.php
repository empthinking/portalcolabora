<?php

function isUserLoggedIn(): bool {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

//Inicia a sessao
session_start();

// Cabeçalho
if(isUserLoggedIn()):
	require_once 'header_loggedin.php';
else:
	require_once 'header.php';
endif;
  ?>

    <!-- Conteúdo principal -->
<main class="bg-white">
  
      <div class="container  md:flex">
        <div class="m-5 md:w-1/2">
            <div id="slider">
                <div><img src="https://via.placeholder.com/800x600" alt="Product Image"></div>
                <div><img src="https://via.placeholder.com/800x600" alt="Product Image"></div>
                <div><img src="https://via.placeholder.com/800x600" alt="Product Image"></div>
              </div>
              
        </div>

        <div class="column is-6-desktop m-4 md:w-1/2">
          <h2 class="title is-2 text-8xl font-bold mb-2">Nome do Produto</h2>
          <p class="subtitle is-4 text-4lg text-gray-600 mb-4">Descrição do Produto</p>
          <p class="subtitle is-3 has-text-success text-6xl text-green-600 mb-4">R$ 129,00</p>
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg mb-4">Entrar em contato</button>
           <div class="flex items-center">
            <div class="w-10 h-10 rounded-full mr-4">
              <img src="img/perfil.png" alt="Perfil">
            </div>
            <a href="#" class="text-blue-500 font-bold"><label for="perfil">Nome</label></a>
          </div>
        </div>
    
    </div>
  
  </main>  
  <section class="bg-gray-100 py-8">
    <div class="container">
      <h2 class="text-2xl font-bold mb-6">Outros Produtos</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
  
        <!-- Product 1 -->
        <div class="card">
          <div class="card-image">
            <figure class="w-full">
              <img src="https://via.placeholder.com/500x500" alt="Product Image" class="object-cover w-full h-48">
            </figure>
          </div>
          <div class="card-content p-4">
            <p class="text-lg font-bold mb-2">Nome do Produto</p>
            <p class="text-lg font-bold text-green-600 mb-2">R$ 99,00</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">ver mais</button>
          </div>
        </div>
        <!-- End of Product 1 -->
  
        <!-- Product 2 -->
        <div class="card">
          <div class="card-image">
            <figure class="w-full">
              <img src="https://via.placeholder.com/500x500" alt="Product Image" class="object-cover w-full h-48">
            </figure>
          </div>
          <div class="card-content p-4">
            <p class="text-lg font-bold mb-2">Nome do Produto</p>
            <p class="text-lg font-bold text-green-600 mb-2">R$ 99,00</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">ver mais</button>
          </div>
        </div>
        <!-- End of Product 2 -->
        
        <!-- Product 3 -->
        <div class="card">
          <div class="card-image">
            <figure class="w-full">
              <img src="https://via.placeholder.com/500x500" alt="Product Image" class="object-cover w-full h-48">
            </figure>
          </div>
          <div class="card-content p-4">
            <p class="text-lg font-bold mb-2">Nome do Produto</p>
            <p class="text-lg font-bold text-green-600 mb-2">R$ 99,00</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">ver mais</button>
          </div>
        </div>
        <!-- End of Product 3 -->
  
        <!-- Product 4 -->
        <div class="card">
          <div class="card-image">
            <figure class="w-full">
              <img src="https://via.placeholder.com/500x500" alt="Product Image" class="object-cover w-full h-48">
            </figure>
          </div>
          <div class="card-content p-4">
            <p class="text-lg font-bold mb-2">Nome do Produto</p>
            <p class="text-lg font-bold text-green-600 mb-2">R$ 99,00</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">ver mais</button>
          </div>
        </div>
        <!-- End of Product 4 -->
                <!-- Product 4 -->
        <div class="card">
          <div class="card-image">
            <figure class="w-full">
              <img src="https://via.placeholder.com/500x500" alt="Product Image" class="object-cover w-full h-48">
            </figure>
          </div>
          <div class="card-content p-4">
            <p class="text-lg font-bold mb-2">Nome do Produto</p>
            <p class="text-lg font-bold text-green-600 mb-2">R$ 99,00</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">ver mais</button>
          </div>
        </div>
        <!-- End of Product 4 -->
  
      </div></div></section>
  
  <style>
    /* Slick Carousel styles */
    .slick-slide {
      margin: 0 10px;
    }
  
    .slick-prev:before,
    .slick-next:before {
        color: #999;
    }
    
    .slick-dots li button:before {
        color: #999;
    }
  
    .slick-dots li.slick-active button:before {
      color: #3273dc;
    }
    
    /* Custom styles */
    .related-products {
        margin: 0
    }
    </style>
  </body>
    <script>
   
     $(document).ready(function(){
      $('#slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true
      });
    });
    
    </script>
  </html>
