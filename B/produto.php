<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Detalhes do Produto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css">
</head>

<body class="bg-gray-100">
  <div class="container mx-auto py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Imagem do produto -->
      <div class="max-w-xs mx-auto">
        <img src="caminho_da_imagem_do_produto" alt="Imagem do Produto" class="w-full">
      </div>

      <!-- Detalhes do produto -->
      <div>
        <h2 class="text-2xl font-bold">Nome do Produto</h2>
        <p class="text-gray-500">Por: Nome do Criador</p>
        <button onclick="mostrarContato()" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Entrar em Contato</button>

        <!-- Informações de contato (inicialmente ocultas) -->
        <div id="contato" class="hidden mt-4">
          <p>Número de telefone: XXXXXXXXX</p>
        </div>

        <h3 class="text-lg font-bold mt-6">Descrição</h3>
        <p class="mt-2">Descrição do produto...</p>
      </div>
    </div>

    <!-- Produtos recomendados -->
    <h3 class="text-2xl font-bold mt-12 mb-4">Produtos Recomendados</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Card de produto recomendado -->
      <div class="bg-white rounded shadow p-4">
        <img src="caminho_da_imagem_do_produto_recomendado" alt="Imagem do Produto Recomendado" class="w-full mb-4">
        <h4 class="text-lg font-bold">Nome do Produto Recomendado</h4>
        <p class="text-gray-500">Por: Nome do Criador</p>
        <button onclick="mostrarContato()" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Entrar em Contato</button>
      </div>

      <!-- Repita os cards de produto recomendado aqui -->
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
