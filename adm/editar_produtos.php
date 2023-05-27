<?php
session_start();
require_once "dbconn.php";
require_once "funcoes.php";

// Verifica se o usuário está logado
if (!isUserLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
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
    header("Location: listar_produtos.php");
    exit();
}

// Busca os dados do produto com o ID informado
$id = mysqli_real_escape_string($conn, $_GET['id']);
$prod = getProdutoById($conn, $id);

// Verifica se o produto foi encontrado
if (!$prod) {
    header("Location: listar_produtos.php");
    exit();
}

// Processa o formulário de edição do produto
if (isset($_POST['submit'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $preco = mysqli_real_escape_string($conn, $_POST['preco']);

    // Verifica se uma nova imagem foi selecionada
    $imagem_nome = $prod['imagem_nome'];
    $imagem = $prod['imagem'];

    if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        // Remove a imagem atual, se existir
        if (!empty($imagem_nome) && file_exists($imagem)) {
            unlink($imagem);
        }

        $imagem_nome = basename($_FILES['imagem']['name']);
        $imagem = "uploads/$imagem_nome";
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../$imagem");
    }

    // Atualiza os dados do produto no banco de dados
    if (updateProduto($conn, $id, $nome, $descricao, $preco, $imagem, $imagem_nome)) {
        header("Location: listar_produtos.php");
        exit();
    } else {
        $erro = "Erro ao atualizar produto.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Listar Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div class="flex justify-center m-20">
    <img src="../img/logo G (2).png" alt="Descrição da imagem">
</div>
<div class="flex justify-center mt-10 menu-overlay">
    <div class="bg-white rounded-lg mx-auto p-8">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id" class="block text-gray-700 font-bold mb-2">ID do Produto:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="id" name="id" value="<?= $prod['id'] ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="nome" class="block text-gray-700 font-bold mb-2">Nome:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" name="nome" value="<?= $prod['nome'] ?>" required>
            </div>
            <div class="form-group">
                <label for="descricao" class="block text-gray-700 font-bold mb-2">Descrição:</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="descricao" name="descricao" required><?= $prod['descricao'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="preco" class="block text-gray-700 font-bold mb-2">Preço:</label>
                <input type="number" step="0.01" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="preco" name="preco" value="<?= $prod['preco'] ?>" required>
            </div>
            <div class="form-group">
                <label for="imagem" class="block text-gray-700 font-bold mb-2">Imagem:</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="imagem" name="imagem">
            </div>
            <div class="form-group">
                <input type="hidden" name="imagem_nome" value="<?= $prod['imagem_nome'] ?>">
                <input type="hidden" name="imagem" value="<?= $prod['imagem'] ?>">
                <input type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="submit" value="Atualizar">
            </div>
        </form>
        <a href="#" onclick="history.back()" class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-9 rounded focus:outline-none focus:shadow-outline">
        Voltar
    </a>
    </div>
</div>
</body>
</html>
