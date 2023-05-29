<?php
session_start();
ob_start();
function isUserLoggedIn(): bool {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
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
    <div class="max-w-md mx-auto bg-white shadow-md rounded-md p-6">
      <div class="flex">
        <img src="<?php echo $imagem; ?>" alt="Imagem do Produto" class="w-1/2 mr-4">
        <div class="w-1/2">
          <h2 class="text-2xl font-bold mb-2"><?php echo $nome; ?></h2>
          <p class="text-gray-600 mb-4"><?php echo $descricao; ?></p>
          <p class="text-lg font-bold">Preço: R$ <?php echo $preco; ?></p>
          <?php if (isUserLoggedIn()): ?>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4" onclick="showContactForm()">Entrar em contato</button>
          <?php else: ?>
            <span class="text-red-500">Para entrar em contato com o vendedor, você precisa estar logado.</span>
            <div class="mt-4">
              <a href="cadastro.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cadastrar</a>
              <a href="login.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Login</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div id="contactForm" class="max-w-md mx-auto bg-white shadow-md rounded-md p-6 mt-4 hidden">
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
    </div>

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

<script>
  function showContactForm() {
    const contactForm = document.getElementById('contactForm');
    contactForm.style.display = 'block';
  }
</script>
