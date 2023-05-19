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

$id = $_GET['id'];
if (!$id) {
  header("Location: index.php");
  exit;
}

// Registra o histórico de acesso
if(isUserLoggedIn()) {
  $usuario_id = $_SESSION['id'];
  $produto_id = mysqli_real_escape_string($conn, $id);
  $query = "INSERT INTO historico (usuario_id, produto_id) VALUES ('$usuario_id', '$produto_id')";
  $result = mysqli_query($conn, $query);
  if (!$result) {
      throw new Exception("Erro ao registrar histórico: " . mysqli_error($conn));
  }
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
  
<?php
  $nome = htmlentities($produto['nome']);
  $imagem = htmlentities($produto['imagem']);
  $descricao = htmlentities($produto['descricao']);
  $preco = number_format($produto['preco'], 2, ',', '.');
  $nomeUsuario = htmlentities($produto['nome_usuario']);
?>

<div class="container  md:flex">
  <div class="m-5 md:w-1/2">
    <div id="slider">
      <div><img src="<?php echo $imagem ?>" alt="Imagem do Produto"></div>
      <div><img src="<?php echo $imagem ?>" alt="Imagem do Produto"></div>
      <div><img src="<?php echo $imagem ?>" alt="Imagem do Produto"></div>
    </div>
  </div>

  <div class="column is-6-desktop m-4 md:w-1/2">
    <h2 class="title is-2 text-8xl font-bold mb-2"><?= $nome ?></h2>
    <p class="subtitle is-4 text-4lg text-gray-600 mb-4"><?= $descricao ?></p>
    <p class="subtitle is-3 has-text-success text-6xl text-green-600 mb-4">R$ <?= $preco ?></p>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg mb-4"><a href="contato.php">Entrar em contato</a></button>
    <div class="flex items-center">
      <div class="w-10 h-10 rounded-full mr-4">
        <div class="flex items-center cursor-pointer" onclick="toggleDropdown()">
          <img src="<?php echo $caminho_imagem_prod; ?>" alt="Imagem de Perfil" class="w-10 h-10 rounded-full mr-2">
        </div>
      </div>
      <a href="#" class="text-blue-500 font-bold"><label for="perfil"><?= $nomeUsuario ?></label></a>
    </div>
  </div>
</div>

</main>  
<section class="bg-gray-100 py-8">
  <div class="container">
    <h2 class="text-2xl font-bold mb-6">Outros Produtos</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

    <?php
    // Abrindo a conexão com o banco de dados
//     $conn = mysqli_connect("127.0.0.1", "u871226378_colabora", "F7k|MYhYf>", "u871226378_portalcolabora");

    // Verificando se a conexão foi estabelecida com sucesso
    if (!$conn) {
        die("Não foi possível conectar ao banco de dados: " . mysqli_connect_error());
    }

    // Consultando outros produtos de forma aleatória
    $consulta = "SELECT * FROM produtos WHERE id != " . $produto['id'] . " ORDER BY RAND() LIMIT 4";

    // Verificando se a consulta foi executada com sucesso
    $resultado = mysqli_query($conn, $consulta);

    if (!$resultado) {
        die("Não foi possível consultar o banco de dados: " . mysqli_error($conn));
    }

    // Loop para exibir os produtos
    while ($produto = mysqli_fetch_array($resultado)) {
        ?>

        <!-- Card do Produto -->
        <div class="card">
            <div class="card-image">
                <figure class="w-full">
                    <img src="<?= htmlentities($produto['imagem']) ?>" alt="Product Image" class="object-cover w-full h-48">
                </figure>
            </div>
            <div class="card-content p-4">
                <p class="text-lg font-bold mb-2"><?= htmlentities($produto['nome']) ?></p>
                <p class="text-lg font-bold text-green-600 mb-2">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    <a href="produto.php?id=<?= $produto['id'] ?>">ver mais</a>
                </button>
            </div>
        </div>

    <?php
    }
    // Fechando a conexão com o banco de dados
    mysqli_close($conn);
    ?>

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

<?php require_once "footer.php"; ?>
