<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo '<script>alert("login necessario")</script>';
    header('Location: index.php');
    exit;
}
require_once 'dbconn.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$product_name = $mysqli->real_escape_string($_POST['product-name']);
	$product_description = $mysqli->real_escape_string($_POST['product-description']);
	$product_price = $mysqli->real_escape_string($_POST['product-price']);
	$product_category = $mysqli->real_escape_string($_POST['product-category']);

	$sql = "INSERT INTO products (produto_nome, produto_descricao, produto_preco, produto_category, user_id)
					VALUES ('$product_name', '$product_description', '$product_price', '$product_category', {$_SESSION['id']})";



	if ($mysqli->query($sql)) {
		echo "Produto adicionado com sucesso";
	} else {
		echo "Error: " . $sql . "<br>" . $mysqli->error;
	}
}

	$mysqli->close();
require_once "header.php"
  ?>

        <main>
          <section class="section ">
            <div class="container m-7">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Formulário de upload de imagem -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md p-6">
                  <h2 class="text-4xl font-medium mb-4">Carregar imagem</h2>
                  <div class="mt-4">
                    <label for="image-upload" class="cursor-pointer flex
                      items-center px-4 py-2 bg-blue-600 hover:bg-blue-700
                      text-white rounded-lg focus:outline-none focus:ring-2
                      focus:ring-blue-600 focus:ring-opacity-50">
                      <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 5H14V9H10V5ZM8 19V10H16V19H8ZM5
                          8V21H19V8H5Z" fill="currentColor" />
                        </svg>
                        <span>Escolher arquivo</span>
                      </label>
                      <input id="image-upload" type="file" class="hidden" />
                      <p id="selected-file" class="mt-2 text-lg text-gray-600">Nenhum
                        arquivo selecionado</p>
                    </div>
                  </div>

                  <!-- Formulário de anúncio do produto -->
                  <div class="bg-white rounded-lg overflow-hidden shadow-md
                    p-6">
                    <h2 class="text-4xl font-medium mb-4">Anunciar produto</h2>
                    <form class="space-y-4" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST'>
                      <div>
                        <label for="product-name" class="block text-lg
                          font-medium text-gray-700">Nome do produto</label>
                        <div class="mt-1">
                          <input type="text" name="product-name"
                            id="product-name" class="shadow-sm
                            focus:ring-blue-500 focus:border-blue-500 block
                            w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Digite o nome do produto">
                        </div>
                      </div>

                      <div>
                        <label for="product-description" class="block text-lg
                          font-medium text-gray-700">Descrição do produto</label>
                        <div class="mt-1">
                          <textarea id="product-description"
                            name="product-description" rows="3" class="shadow-sm
                            focus:ring-blue-500 focus:border-blue-500 block
                            w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Digite a descrição do produto"></textarea>
                        </div>
                      </div>

                      <div>
                        <label for="product-price" class="block text-lg
                          font-medium text-gray-700">Preço</label>
                        <div class="mt-1">
                          <div class="field">
                            <span class="inline-flex items-center px-3
                              rounded-l-md border border-r-0 border-gray-300
                              bg-gray-50 text-gray-500 text-sm">
                              R$
                            </span>
                            <input class="input" type="number" name="product-price"
                              placeholder="Preço" step="0.01" min="0"
                              max="10000" pattern="\d+(\.\d{2})?" required>
                          </div>

                        </div>
                      </div>


                      <div class="field">
                        <label class="text-lg label">Categoria</label>
                        <div class="control">
                          <div class="select">
                            <select name="product-category">
                              <option>tipo 1</option>
                              <option>tipo 2</option>
                              <option>tipo 3</option>
                              <option>tipo 4</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="flex field is-grouped justify-end gap-7">
                        <div class="control">
                          <button class="bg-green-400 hover:bg-green-700
                            text-white font-bold py-2 px-4 rounded-full ml-4">Anunciar</button>
                        </div>
                        <div class="control">
                          <button class="bg-white hover:bg-red-500 text-black
                            font-bold py-2 px-4 rounded-full ml-4">Cancelar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </main>
            </body>
          </html>
