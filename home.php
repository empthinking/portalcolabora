 <main>
    <!-- Produtos -->

    <button id="botaoFiltro" style="margin-top: 100px;" class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4 mt-48 md:fixed left-10">
      Abrir filtro
    </button>
    <div id="divFilt" class="menu-container fixed inset-0 overflow-hidden
      z-40 hidden">
      <div class="menu-container fixed inset-0 overflow-hidden z-50">
        <div class="menu-overlay absolute inset-0 bg-gray-900 opacity-50"></div>
        <div class="menu-content fixed inset-y-0 right-0 flex flex-col
          w-full max-w-xs bg-white overflow-y-auto">
          <div class="px-4 py-3 border-b">
            <h2 class="text-lg font-bold mb-4">Filtros</h2>
      
          </div>
          <div class="px-4 py-3 border-b">
            <h3 class="text-base font-bold mb-2">Categoria</h3>
            <div class="relative">
              <select class="block appearance-none w-full bg-white border
                border-gray-300 hover:border-gray-500 px-4 py-2 pr-8
                rounded shadow leading-tight focus:outline-none
                focus:shadow-outline">
                <option>Todos</option>
                <option>Categoria 1</option>
                <option>Categoria 2</option>
                <option>Categoria 3</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0
                flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path
                    d="M14.95 7.95a1 1 0 01-1.41 0L10 4.91 6.46 8.46a1 1 0
                    01-1.41-1.41l4-4a1 1 0 011.41 0l4 4a1 1 0 010 1.41z"/></svg>
                </div>
              </div>
              <br>
              <h3 class="text-base font-bold mb-2">Preço</h3>
              <div class="flex flex-wrap">
                <button class="bg-gray-200 text-gray-700 font-bold py-2
                px-4 rounded-full mr-2 mb-2 ">Até R$ 50</button>
                <button class="bg-gray-200 text-gray-700 font-bold py-2
                  px-4 rounded-full mr-2 mb-2">R$ 50 - R$ 100</button>
                <button class="bg-gray-200 text-gray-700 font-bold py-2
                  px-4 rounded-full mr-2 mb-2">R$ 100 - R$ 200</button>
                <button class="bg-gray-200 text-gray-700 font-bold py-2
                  px-4 rounded-full mr-2 mb-2">Mais de R$ 200</button>
                  
              </div>
            </div>
            <button id="filtroBack"  class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4 mt-48 md:fixed left-10">
                Feichar filtro
            </button>
          </div>
        </div>
      </div>
      <div class="menu-overlay fixed inset-0 bg-gray-400 opacity-50 z-30
        hidden"></div>



      <div>
        <section class="bg-gray-100 sm:m-4 md:m-10 py-12">

          <div class="container sm:m-4">
            <h2 class="text-2xl font-bold mb-8">Nossos Produtos</h2>
            <!-- produtxo 1 -->
            <a href="<%= posts[0].slug %>">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3
                gap-6">
       <?php
require_once "dbconn.php";

// Executa a consulta SQL para selecionar todos os produtos
$sql = "SELECT * FROM products;";
$resultado = mysqli_query($conn, $sql);

// Verifica se a consulta retornou algum resultado
if (mysqli_num_rows($resultado) > 0) {
    // Loop pelos resultados e exibe os dados
    while ($linha = mysqli_fetch_assoc($resultado)) {
        echo '<div class="bg-white rounded-lg overflow-hidden shadow-md">';
        echo '<div class="relative">';
        echo '<img src="#" alt="' . $linha["produto_nome"] . '" class="w-full h-64 object-cover">';
        echo '</div>';
        echo '<div class="p-6">';
        echo '<h3 class="text-lg font-semibold mb-2">' . $linha["produto_nome"] . '</h3>';
        echo '<p class="text-gray-700 font-medium mb-2">R$ ' . $linha["produto_preco"] . '</p>';
        echo '<p class="text-gray-700 mb-4">' . $linha["produto_descricao"] . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "Nenhum produto encontrado.";
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>

                      </div>
                    </a>
                <!-- fim do produto 1 -->
                        </div></div>
                        </div>
                      </div>
                    </section>
                
                
                <script> 
var botaoFiltro = document.querySelector('#botaoFiltro');

botaoFiltro.addEventListener('click',()=>{
let divFiltro = document.querySelector('#divFilt')

if(divFiltro.getAttribute('class') == 'menu-container fixed inset-0 overflow-hidden z-40 hidden'){
divFiltro.setAttribute('class', '0')
} else {
divFiltro.setAttribute('class','menu-container fixed inset-0 overflow-hidden z-40 hidden')
}
});


var filtroBack = document.querySelector('#filtroBack');
filtroBack.addEventListener('click',()=>{  
let filtroBack = document.querySelector('#divFilt')
if(filtroBack.getAttribute('class') == 'menu-container fixed inset-0 overflow-hidden z-40 hidden'){
filtroBack.setAttribute('class','menu-container fixed inset-0 overflow-hidden z-40 hidden')
} else {
filtroBack.setAttribute('class','menu-container fixed inset-0 overflow-hidden z-40 hidden')
}
});


</script>

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
