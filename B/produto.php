<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Detalhes do Produto</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="container">
    <?php
    // Verifica se o ID do produto foi fornecido na URL
    if (isset($_GET['id'])) {
      // Obtém o ID do produto da URL
      $produto_id = $_GET['id'];

      // Aqui você pode obter as informações do produto a partir do banco de dados ou de qualquer outra fonte de dados

      // Exemplo de informações do produto
      $nome = "Nome do Produto";
      $descricao = "Descrição do produto.";
      $preco = 99.99;
      $imagem = "caminho/para/imagem.jpg";

      // Exibindo as informações do produto
      echo "<h1>$nome</h1>";
      echo "<p>$descricao</p>";
      echo "<p>Preço: R$ $preco</p>";
      echo "<img src='$imagem' alt='Imagem do Produto'>";
    } else {
      // Se o ID do produto não foi fornecido na URL, exiba uma mensagem de erro
      echo "<p>Nenhum ID de produto fornecido.</p>";
    }
    ?>
  </div>
</body>
</html>
