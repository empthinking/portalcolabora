<?php
session_start();
require_once "dbconn.php";

function isUserLoggedIn(): bool {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

//Inicia a sessao

// Cabeçalho
if(isUserLoggedIn()):
  require_once 'header_loggedin.php';
else:
  require_once 'header.php';
endif;

$id = $_GET['id'];
if (!$id) {
  header("Location: index.php");
  exit;
}

// Função para obter as informações do produto do banco de dados
function obter_produto($conn, $id) {
  $query = "SELECT p.*, u.user_nome as nome_usuario, u.user_imagem FROM produtos p JOIN usuarios u ON p.usuario_id = u.user_id WHERE p.id = " . mysqli_real_escape_string($conn, $id);
  $result = mysqli_query($conn, $query);
  if (!$result) {
      throw new Exception("Erro na consulta: " . mysqli_error($conn));
  }
  $produto = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $produto;
}

// Abrindo a conexão com o banco de dados
$conn = mysqli_connect("127.0.0.1", "seu_usuario", "sua_senha", "seu_banco_de_dados");

// Verificando se a conexão foi estabelecida com sucesso
if (!$conn) {
    die("Não foi possível conectar ao banco de dados: " . mysqli_connect_error());
}

$produto = obter_produto($conn, $id);
mysqli_close($conn);

// Verifica se a foto de perfil do usuário está vazia
if ($produto['user_imagem'] == null) {
  $caminho_imagem_prod = "img/perfil.png";
} else {
  $caminho_imagem_prod = $produto['user_imagem'];
}
?>

<!-- Conteúdo principal -->
<main class="bg-white">
  
  <div class="container  md:flex">
    <div class="m-5 md:w-1/2">
      <div id="slider">
        <div><img src="<?php echo $produto['imagem']; ?>" alt="Imagem do Produto"></div>
        <div><img src="<?php echo $produto['imagem']; ?>" alt="Imagem do Produto"></div>
        <div><img src="<?php echo $produto['imagem']; ?>" alt="Imagem do Produto"></div>
      </div>
    </div>

    <div class="column is-6-desktop m-4 md:w-1/2">
      <h2 class="title is-2 text-8xl font-bold mb-2"><?php echo htmlentities($produto['nome']); ?></h2>
      <p class="subtitle is-4 text-4lg text-gray-600 mb-4"><?php echo htmlentities($produto['descricao']); ?></p>
      <p class="subtitle is-3 has-text-success text-6xl text-green-600 mb-4">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg mb-4"><a href="contato.php">Entrar em contato</a></button>
      <div class="flex items-center">
        <div class="w-10 h-10 rounded-full mr-4">
          <div class="flex items-center cursor-pointer" onclick="toggleDropdown()">
            <img src="<?php echo $caminho_imagem_prod; ?>" alt="Perfil" class="w-10 h-10 rounded-full">
          </div>
        </div>
        <a href="#" class="text-blue-500 font-bold"><label for="perfil"><?php echo $produto['nome_usuario']; ?></label></a>
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

    </div>
  </div>
</section>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick.min.js"></script>
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
</body>
</html>
