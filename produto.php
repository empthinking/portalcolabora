<?php
require_once "dbconn.php";

function isUserLoggedIn(): bool {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

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
  $sql = "SELECT produtos.id AS produto_id, produtos.imagem, produtos.nome, produtos.descricao, produtos.preco, produtos.visualizacoes, usuarios.user_tel
          FROM produtos
          INNER JOIN usuarios ON produtos.usuario_id = usuarios.id
          WHERE produtos.id = $produto_id";
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
    $user_tel = $row["user_tel"];

    // Incrementa o contador de visualizações
    $novas_visualizacoes = $visualizacoes + 1;
    $sql = "UPDATE produtos SET visualizacoes = $novas_visualizacoes WHERE id = $produto_id";
    $conn->query($sql);
    ?>

    <div class="max-w-md mx-auto bg-white shadow-md rounded-md p-6">
      <div class="flex">
        <img src="<?php echo $imagem; ?>" alt="Imagem do Produto" class="w-1/2 mr-4">
        <div class="w-1/2">
          <h2 class="text-2xl font-bold mb-2"><?php echo $nome; ?></h2>
          <p class="text-gray-600 mb-4"><?php echo $descricao; ?></p>
          <p class="text-lg font-bold">Preço: R$ <?php echo $preco; ?></p>
          <?php if (isUserLoggedIn()): ?>
            <p class="text-lg font-bold">entrar em contato: <?php echo $user_tel; ?></p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Entrar em contato</button>
          <?php else: ?>
            <span>Para realizar essa ação, é necessário estar logado.</span>
            <div class="mt-4">
              <a href="cadastro.php" class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Cadastre-se</a>
              <a href="login.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">Login</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
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
