<?php
// Função para verificar se o usuário está logado
function isUserLoggedIn(): bool {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Inicia a sessão
session_start();

// Cabeçalho
if (isUserLoggedIn()) {
  require_once 'header_loggedin.php';
} else {
  require_once 'header.php';
}

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
<body class="bg-gray-100">
  <div class="container mx-auto py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Imagem do produto -->
      <div class="max-w-xs mx-auto">
        <img src="<?php echo $produto['imagem']; ?>" alt="Imagem do Produto" class="w-full">
      </div>

      <!-- Detalhes do produto -->
      <div>
        <h2 class="text-2xl font-bold"><?php echo $produto['nome']; ?></h2>
        <p class="text-gray-500">Por: <?php echo $produto['criador']; ?></p>
        <button onclick="mostrarContato()" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Entrar em Contato</button>

        <!-- Informações de contato (inicialmente ocultas) -->
        <div id="contato" class="hidden mt-4">
          <p>Número de telefone: <?php echo $produto['contato']; ?></p>
        </div>

        <h3 class="text-lg font-bold mt-6">Descrição</h3>
        <p class="mt-2"><?php echo $produto['descricao']; ?></p>
      </div>
    </div>

    <!-- Produtos recomendados -->
    <h3 class="text-2xl font-bold mt-12 mb-4">Produtos Recomendados</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php foreach ($produtosRecomendados as $produtoRecomendado) { ?>
        <!-- Card de produto recomendado -->
        <div class="bg-white rounded shadow p-4">
          <img src="<?php echo $produtoRecomendado['imagem']; ?>" alt="Imagem do Produto Recomendado" class="w-full mb-4">
          <h4 class="text-lg font-bold"><?php echo $produtoRecomendado['nome']; ?></h4>
          <p class="text-gray-500">Por: <?php echo $produtoRecomendado['criador']; ?></p>
          <button onclick="mostrarContato()" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Entrar em Contato</button>
        </div>
      <?php } ?>
    </div>
  </div>

  <script>
    function mostrarContato() {
      var contato = document.getElementById("contato");
      contato.classList.toggle("hidden");
    }
  </script>
</body>

</html>
