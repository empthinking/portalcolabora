<?php
session_start();
ob_start();
require_once "header_loggedin.php";
require_once "dbconn.php";
require_once "funcoes.php";

// Verifica se o usuário está logado
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Inicializa as variáveis com valores vazios
$nome = $descricao = $preco = $imagem = '';
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processa os dados do formulário quando o mesmo for submetido
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $preco = isset($_POST['preco']) ? $_POST['preco'] : '';

    // Verifica se uma nova imagem foi selecionada
    $imagem_nome = $prod['imagem_nome'];
    $imagem = $prod['imagem'];
    if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_nome = basename($_FILES['imagem']['name']);
        $imagem = "uploads/$imagem_nome";
        move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
    }

    // Validação do nome
    if (empty($nome)) {
        $erros[] = 'O nome do produto é obrigatório.';
    } elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $nome)) {
        $erros[] = 'O nome do produto deve conter somente letras, números e espaços em branco.';
    }

    // Validação da descrição
    if (empty($descricao)) {
        $erros[] = 'A descrição do produto é obrigatória.';
    }

    // Validação do preço
    if (empty($preco)) {
        $erros[] = 'O preço do produto é obrigatório.';
    } elseif (!preg_match('/^\d+(\.\d{1,2})?$/', $preco)) {
        $erros[] = 'O preço do produto deve ser um valor numérico válido.';
    }

    if (empty($erros)) {
        // Cria um novo produto no banco de dados
        $sql = "INSERT INTO produtos (nome, descricao, preco, imagem, usuario_id, ativo) VALUES ('$nome', '$descricao', $preco, '$imagem', $usuario_id, true)";
        if (mysqli_query($conn, $sql)) {
            // Redireciona para a página de "Meus Produtos" com uma mensagem de sucesso
            $_SESSION['mensagem'] = 'Produto adicionado com sucesso!';
            header('Location: meus_produtos.php');
            exit;
        } else {
            $erros[] = 'Ocorreu um erro ao adicionar o produto. Por favor, tente novamente.';
        }
    }
}
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
      <input id="image-upload" type="file" class="hidden"
        onchange="addImage(event)" accept="image/*" multiple />
      <p id="selected-file" class="mt-2 text-lg text-gray-600">Nenhum
        arquivo selecionado</p>
      <div class="mt-4" id="selected-images"></div>
      <div class="mt-4">
        <button id="add-image-button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700
          text-white rounded-lg focus:outline-none focus:ring-2
          focus:ring-blue-600 focus:ring-opacity-50">
          Adicionar mais fotos
        </button>
      </div>
    </div>
  </div>
<script>
  let images = [];
  const addImageButton = document.getElementById('add-image-button');
  const selectedImages = document.getElementById('selected-images');

  function addImage(event) {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => {
        const image = document.createElement('img');
        image.src = reader.result;
        image.classList.add('max-w-full', 'mt-4', 'mr-4');
        images.push(image);
        displayImages();
      };
    }
  }

  function displayImages() {
    selectedImages.innerHTML = '';
    for (let i = 0; i < images.length; i++) {
      const image = images[i];
      selectedImages.appendChild(image);
    }
    document.getElementById('selected-file').innerHTML = `${images.length} arquivo(s) selecionado(s)`;
  }

  addImageButton.addEventListener('click', () => {
    document.getElementById('image-upload').click();
  });
</script>
                  <!-- Formulário de anúncio do produto -->
                  <div class="bg-white rounded-lg overflow-hidden shadow-md p-6">
  <h2 class="text-4xl font-medium mb-4">Anunciar produto</h2>
  <form class="space-y-4" method="POST" enctype="multipart/form-data">
    <div>
      <label for="product-name" class="block text-lg font-medium text-gray-700">Nome do produto</label>
      <div class="mt-1">
        <input type="text" name="product-name" id="product-name" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Digite o nome do produto" required>
      </div>
    </div>

    <div>
      <label for="product-description" class="block text-lg font-medium text-gray-700">Descrição do produto</label>
      <div class="mt-1">
        <textarea id="product-description" name="product-description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Digite a descrição do produto" required></textarea>
      </div>
    </div>

    <div>
      <label for="product-price" class="block text-lg font-medium text-gray-700">Preço</label>
      <div class="mt-1">
        <div class="field">
          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">R$</span>
          <input class="input" type="number" placeholder="Preço" step="0.01" min="0" max="10000" pattern="\d+(\.\d{2})?" name="product-price" required>
        </div>
      </div>
    </div>

    <!-- <div class="field">
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
    </div> -->
    <div class="flex field is-grouped justify-end gap-7">
      <div class="control">
        <button class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4" type="submit">Anunciar</button>
      </div>
      <div class="control">
        <button class="bg-white hover:bg-red-500 text-black font-bold py-2 px-4 rounded-full ml-4" type="reset">Cancelar</button>
      </div>
    </div>
  </form>
</div>
</div>
                </div>
              </main>
            </body>
          </html>
