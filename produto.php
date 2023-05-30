<?php
session_start();
ob_start();
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
       // Redireciona o usuário de volta para o produto
   $produto_id = $_SESSION['id'];
   header("Location: produto.php?id=$pid");
   exit;
}
require_once "dbconn.php";
// Cabeçalho
if(isUserLoggedIn()):
  require_once 'header_loggedin.php';
else:
  require_once 'header.php';
endif;


   
// Verifica se o parâmetro "id" está presente na URL
if (isset($_GET['id'])) {
  // Obtém o ID do produto da URL
  $produto_id = $_GET['id'];

  // Faz a requisição ao banco de dados para obter as informações do produto com o ID correspondente
  $sql = "SELECT imagem, nome, descricao, preco, visualizacoes FROM produtos WHERE id = $produto_id";
  $result = $conn->query($sql);

  // Verifica se existe um registro correspondente ao ID
  if ($result->num_rows > 0) {
    // Obtém os detalhes do produto
    $row = $result->fetch_assoc();
    $imagem = $row["imagem"];
    $nome = $row["nome"];
    $descricao = $row["descricao"];
    $preco = $row["preco"];
    $visualizacoes = $row["visualizacoes"];

    // Incrementa o contador de visualizações
    $novas_visualizacoes = $visualizacoes + 1;
    $sql = "UPDATE produtos SET visualizacoes = $novas_visualizacoes WHERE id = $produto_id";
    $conn->query($sql);

    // Registra o histórico de acesso
    if (isUserLoggedIn()) {
      $usuario_id = $_SESSION['id'];
      $produto_id = mysqli_real_escape_string($conn, $id);
      $query = "INSERT INTO historico (usuario_id, produto_id) VALUES ('$usuario_id', '$produto_id')";
      $result = mysqli_query($conn, $query);
      if (!$result) {
        throw new Exception("Erro ao registrar histórico: " . mysqli_error($conn));
      }
    }

    ?>

    <br>
    <br>
    <br>
    <div class="product-card">
  <div class="image-container">
    <img src="<?php echo $imagem; ?>" alt="Imagem do Produto">
  </div>
  <div class="product-details">
    <h2 class="product-title"><?php echo $nome; ?></h2>
    <p class="product-description"><?php echo $descricao; ?></p>
    <p class="product-price">Preço: R$ <?php echo $preco; ?></p>
    <button class="contact-button" onclick="showContactOptions()">Entrar em contato</button>
  </div>
</div>



    <div id="contactOptions" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900" style="opacity: 1;">
    <?php if (!isUserLoggedIn()): ?>    
    <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <span class="text-red-500">Para entrar em contato com o vendedor, você precisa estar logado.</span>
        <div class="mt-4">
          <a href="cadastro.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cadastrar</a>
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4" onclick="document.getElementById('singIn').style.display='block'; document.getElementById('contactOptions').style.display='none'">Login</button>
        </div>
            </div>
            <button type="button" onclick="document.getElementById('contactOptions').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                Cancelar
                </button>
            </div>
            </div>
        </div> 
      <?php else: ?>
        <h2 class="text-2xl font-bold mb-4">Enviar mensagem para o vendedor</h2>
        <form action="enviar_mensagem.php" method="POST">
          <input type="hidden" name="destinatario" value="<?php echo $usuario_id; ?>">
          <input type="hidden" name="remetente" value="<?php echo $_SESSION['id']; ?>">
          <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="mensagem">
              Mensagem
            </label>
            <textarea class="no-resize appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mensagem" name="mensagem" placeholder="Digite sua mensagem"></textarea>
          </div>
          <div class="flex items-center justify-between">
  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
    Enviar mensagem
  </button>

          </div>
        </form>
      <?php endif; ?>     
    </div>
    
<style>.product-card {
  width: 820px;
  height: 500px;
  margin: 0 auto;
  background-color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 0.5rem;
  padding: 20px;
  display: flex;
}

.image-container {
  width: 60%;
  text-align: center;
  padding-right: 20px;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 0.5rem;
}

.product-details {
  width: 40%;
}

.product-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.product-description {
  font-size: 16px;
  color: #666666;
  margin-bottom: 20px;
}

.product-price {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 20px;
}

.contact-button {
  background-color: #a2d9aa;
  color: #ffffff;
  font-weight: bold;
  font-size: 20px;
  padding: 16px 24px;
  border-radius: 0.5rem;
  cursor: pointer;
  align-self: flex-start;
}

  </style>

    <script>
      function showContactOptions() {
        const contactOptions = document.getElementById('contactOptions');
        contactOptions.style.display = 'block';
      }
    </script>

    <?php
  } else {
    echo "Produto não encontrado.";
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
} else {
  echo "ID do produto não fornecido na URL.";
}
?>
<!-- Loop para exibir os cards dos produtos -->
<?php
// Consulta para obter os produtos do banco de dados (você precisa ajustar isso de acordo com sua estrutura de banco de dados)
$sql = "SELECT id, imagem, nome, descricao, preco FROM produtos LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $produto_id = $row["id"];
    $imagem = $row["imagem"];
    $nome = $row["nome"];
    $descricao = $row["descricao"];
    $preco = $row["preco"];
    ?>

    <div class="product-card">
      <div class="image-container">
        <img src="<?php echo $imagem; ?>" alt="Imagem do Produto">
      </div>
      <div class="product-details">
        <h2 class="product-title"><?php echo $nome; ?></h2>
        <p class="product-description"><?php echo $descricao; ?></p>
        <p class="product-price">Preço: R$ <?php echo $preco; ?></p>
        <a href="produto.php?id=<?php echo $produto_id; ?>" class="view-details">Ver detalhes</a>
      </div>
    </div>

    <?php
  }
} else {
  echo "Nenhum produto encontrado.";
}
?>

</body></html>

