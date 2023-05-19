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
// Função para atualizar um produto no banco de dados
function updateProduto($conn, $id, $nome, $descricao, $preco, $imagem, $imagem_nome): bool {
  $sql = "UPDATE produtos SET nome = '$nome', descricao = '$descricao', preco = $preco, imagem_nome = '$imagem_nome', imagem = '$imagem' WHERE id = $id";
  return mysqli_query($conn, $sql);
}

// Função para buscar um produto pelo ID no banco de dados
function getProdutoById($conn, $id) {
  $sql = "SELECT * FROM produtos WHERE id = $id";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
      return mysqli_fetch_assoc($result);
  }

  return false;
}

// Verifica se o ID do produto foi informado na URL
if (!isset($_GET['id'])) {
    header("Location: perfil.php");
    exit();
}

// Busca os dados do produto com o ID informado
$id = mysqli_real_escape_string($conn, $_GET['id']);
$prod = getProdutoById($conn, $id);

// // Verifica se o produto foi encontrado
// if (!$prod) {
//     header("Location: perfil.php");
//     exit();
// }

// // Verifica se o usuário tem permissão para editar o produto
// if ($prod['usuario_id'] !== $_SESSION['user_id']) {
//     header("Location: perfil.php");
//     exit();
// }

// Processa o formulário de edição do produto
if (isset($_POST['submit'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $preco = mysqli_real_escape_string($conn, $_POST['preco']);

    // Verifica se uma nova imagem foi selecionada
    $imagem_nome = $prod['imagem_nome'];
    $imagem = $prod['imagem'];
    if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_nome = basename($_FILES['imagem']['name']);
        $imagem = "uploads/$imagem_nome";
        move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
    }

    // Atualiza os dados do produto no banco de dados
    if (updateProduto($conn, $id, $nome, $descricao, $preco, $imagem, $imagem_nome)) {
        header("Location: meus_produtos.php");
        exit();
    } else {
        $erro = "Erro ao atualizar produto.";
    }
}

// Exibe o formulário de edição do produto
?>
<div class="flex justify-center m-20">
  <h1 class="text-2xl font-bold mt-10">Edite seu produto</h1>
</div>
<div class="flex justify-center mt-10 menu-overlay">
  <div class="bg-white rounded-lg mx-auto p-8">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <label for="nome" class="block text-gray-700 font-bold mb-2">Nome:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  id="nome" name="nome" value="<?= $prod['nome'] ?>" required>
                </div>
                <div class="mb-4 form-group">
                <label for="descricao" class="block text-gray-700 font-bold mb-2">Descrição:</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="descricao" name="descricao" required><?= $prod['descricao'] ?></textarea>
                </div>
                <div class="form-group">
                <label for="preco" class="block text-gray-700 font-bold mb-2">Preço:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="preco" name="preco" value="<?= $prod['preco'] ?>" required>
                </div>
                <div class="form-group">
                <label for="imagem" class="block text-gray-700 font-bold mb-2">Imagem:</label>
                <div class="flex items-center mb-2">
                    <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"id="inputFile" name="imagem">
                    <img src="<?= $prod['imagem'] ?>" id="imagePreview" alt="Imagem do produto" width="200">
                </div>
                <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded btn btn-primary">Atualizar Produto</button>
</form>

<!-- Exibição de mensagens de erro -->
<?php if (isset($erro)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $erro; ?>
    </div>
<?php endif; ?>

<script>
  const inputFile = document.getElementById('inputFile');
const imagePreview = document.getElementById('imagePreview');

inputFile.addEventListener('change', () => {
  const file = inputFile.files[0];
  const reader = new FileReader();

  reader.addEventListener('load', () => {
    imagePreview.src = reader.result;
  });

  if (file) {
    reader.readAsDataURL(file);
  }
});

</script>