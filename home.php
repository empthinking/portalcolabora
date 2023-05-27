<?php
require_once "dbconn.php";
require_once "funcoes.php";

// Configurações da paginação
$produtosPorPagina = 10;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $produtosPorPagina;

// Função para buscar produtos ativos no banco de dados
function getProdutosAtivos($conn, $offset, $produtosPorPagina) {
    $sql = "SELECT * FROM produtos WHERE ativo = 1 LIMIT $offset, $produtosPorPagina";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Função para contar o total de produtos ativos no banco de dados
function countProdutosAtivos($conn) {
    $sql = "SELECT COUNT(*) AS total FROM produtos WHERE ativo = 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Busca os produtos ativos
$result = getProdutosAtivos($conn, $offset, $produtosPorPagina);

// Total de produtos ativos
$totalProdutos = countProdutosAtivos($conn);

// Número total de páginas
$totalPaginas = ceil($totalProdutos / $produtosPorPagina);
?>


<div>

<section class="bg-gray-100 sm:m-4 md:m-10 py-12">
<!-- <button id="botaoFiltro" style="z-index: 9999;" class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4 md:fixed left-10">
  Abrir filtro
</button>
<div id="divFilt" class="menu-container fixed inset-0 overflow-hidden z-40 hidden">
  <div class="menu-overlay absolute inset-0 bg-gray-900 opacity-50"></div>
  <div class="menu-content fixed inset-y-0 right-0 flex flex-col w-full max-w-xs bg-white overflow-y-auto">
    <div class="px-4 py-3 border-b">
      <h2 class="text-lg font-bold mb-4">Filtros</h2>
      <button id="filtroBack" class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4">
        Fechar filtro
      </button>
    </div>
    <div class="px-4 py-3 border-b">
      <br>
      <h3 class="text-base font-bold mb-2">Preço</h3>
      <div class="flex flex-wrap">
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">Até R$ 50</button>
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">R$ 50 - R$ 100</button>
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">R$ 100 - R$ 200</button>
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">Mais de R$ 200</button>
      </div>
    </div>
    <div class="px-4 py-3 border-b">
      <br>
      <h3 class="text-base font-bold mb-2">Ordem</h3>
      <div class="flex flex-wrap">
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">Alfabética Crescente</button>
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">Alfabética Decrescente</button>
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">Numérica Crescente</button>
        <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2 focus:bg-gray-400">Numérica Decrescente</button>
      </div>
    </div>
  </div>
</div> -->

<script>
  const botaoFiltro = document.getElementById('botaoFiltro');
  const divFilt = document.getElementById('divFilt');
  const filtroBack = document.getElementById('filtroBack');

  botaoFiltro.addEventListener('click', function() {
    divFilt.classList.remove('hidden');
  });

  filtroBack.addEventListener('click', function() {
    divFilt.classList.add('hidden');
  });
</script>
<div class="menu-overlay fixed inset-0 bg-gray-400 opacity-50 z-30
      hidden"></div>
      <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Produtos</h2>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <?php while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $nome = $row['nome'];
                    $preco = $row['preco'];
                    $descricao = $row['descricao'];
                    $imagem = $row['imagem'];
                ?>
                    <div class="w-full md:w-1/2 lg:w-1/4">
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75">
                                <img src="<?php echo $imagem; ?>" alt="Imagem do produto <?php echo $nome; ?>" class="h-full w-full object-cover object-center">
                            </div>

                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="produto.php?id=<?php echo $id; ?>">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <?php echo $nome; ?></a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500"><?php echo $descricao; ?></p>
                                </div>
                                <p class="text-sm font-medium text-gray-900">R$<?php echo $preco; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php if ($totalPaginas > 1) { ?>
                <div class="mt-8">
                    <nav class="flex justify-center" aria-label="Pagination">
                        <ul class="flex items-center">
                            <?php if ($paginaAtual > 1) { ?>
                                <li>
                                    <a href="?pagina=<?php echo $paginaAtual - 1; ?>" class="relative inline-flex items-center px-4 py-2 rounded-md bg-white border border-gray-300 text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        Anterior
                                    </a>
                                </li>
                            <?php } ?>

                            <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                                <li>
                                    <a href="?pagina=<?php echo $i; ?>" class="<?php echo ($i == $paginaAtual) ? 'bg-gray-100' : 'bg-white'; ?> relative inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        <?php echo $i ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($paginaAtual < $totalPaginas) { ?>
                                <li>
                                    <a href="?pagina=<?php echo $paginaAtual + 1; ?>" class="relative inline-flex items-center px-4 py-2 rounded-md bg-white border border-gray-300 text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        Próxima
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            <?php } ?>

        <?php } else { ?>
            <p>Nenhum produto encontrado.</p>
        <?php } ?>
    </div>
</div>
</section>


              

<style>
input[type="search"]::-webkit-search-cancel-button {
-webkit-appearance: none;
}

input[type="search"]::-webkit-search-decoration {
-webkit-appearance: none;
}

input[type="search"]::-webkit-search-results-button {
-webkit-appearance: none;
}

input[type="search"]::-webkit-search-results-decoration {
-webkit-appearance: none;
}

</style>
              </html>



            </main>
</body>
