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
  $sql = "SELECT imagem, nome, descricao, preco FROM produtos WHERE id = $produto_id";
  $result = $conn->query($sql);

  // Verifica se existe um registro correspondente ao ID
  if ($result->num_rows > 0) {
    // Obtém os detalhes do produto
    $row = $result->fetch_assoc();
    $imagem = $row["imagem"];
    $nome = $row["nome"];
    $descricao = $row["descricao"];
    $preco = $row["preco"];
    ?>

<div class="max-w-md mx-auto bg-white shadow-md rounded-md p-6">
  <div class="flex">
    <img src="<?php echo $imagem; ?>" alt="Imagem do Produto" class="w-1/2 mr-4">
    <div class="w-1/2">
      <h2 class="text-2xl font-bold mb-2"><?php echo $nome; ?></h2>
      <p class="text-gray-600 mb-4"><?php echo $descricao; ?></p>
      <p class="text-lg font-bold">Preço: R$ <?php echo $preco; ?></p>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Entrar em contato</button>
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
