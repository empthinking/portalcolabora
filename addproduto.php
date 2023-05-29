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

    // Verifica se foi enviado um arquivo de imagem
  //   if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
  //     $imagem = salvar_imagem($_FILES['imagem'], 'produtos');
  //     if ($imagem === false) {
  //         $erros[] = 'Ocorreu um erro ao fazer upload da imagem.';
  //     }
  // }
  

    if (empty($erros)) {
        // Cria um novo produto no banco de dados
    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem, usuario_id, ativo) VALUES ('$nome', '$descricao', $preco, '$imagem', $usuario_id, 1)";
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
<div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
  <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Adicionar Produto</h3>
  <form method="post" action="addproduto.php" enctype="multipart/form-data" class="space-y-4">
    <div>
      <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
      <div class="mt-1">
        <input type="text" name="nome" id="nome" autocomplete="off" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
      </div>
    </div>
    <div>
      <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
      <div class="mt-1">
        <textarea name="descricao" id="descricao" rows="3" autocomplete="off" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
      </div>
    </div>
    <div>
      <label for="preco" class="block text-sm font-medium text-gray-700">Preço</label>
      <div class="mt-1">
        <input type="number" name="preco" id="preco" autocomplete="off" min="0" step="0.01" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
      </div>
    </div>
    <div>
      <label for="imagem" class="block text-sm font-medium text-gray-700">Imagem</label>
      <div class="mt-1">
        <input type="file" name="imagem" id="imagem" accept="image/*" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
      </div>
    </div>
    <div class="flex justify-end space-x-2">
      <button type="button" onclick="window.history.back()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full">Cancelar</button>
      <button type="submit" class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full">Adicionar</button>
    </div>
  </form>
</div>
