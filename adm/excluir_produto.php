<?php
require_once "dbconn.php";

// Verifica se o parâmetro "id" está presente na URL
if (isset($_GET['id'])) {
  // Obtém o ID do produto da URL
  $produto_id = $_GET['id'];

  // Faz a requisição ao banco de dados para obter as informações do produto com o ID correspondente
  $sql = "SELECT nome FROM produtos WHERE id = $produto_id";
  $result = $conn->query($sql);

  // Verifica se existe um registro correspondente ao ID
  if ($result->num_rows > 0) {
    // Obtém o nome do produto
    $row = $result->fetch_assoc();
    $nome = $row["nome"];

    // Verifica se a confirmação de exclusão foi realizada
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Executa a exclusão do produto
      $sql_excluir = "DELETE FROM produtos WHERE id = $produto_id";

      if ($conn->query($sql_excluir) === TRUE) {
        // Redireciona para a página listar_produtos.php após a exclusão
        header("Location: listar_produtos.php");
        exit();
      } else {
        echo "Erro ao excluir o produto: " . $conn->error;
      }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Excluir Produto</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script>
            function confirmarExclusao() {
                return confirm("Tem certeza que deseja excluir esse produto?");
            }
        </script>
    </head>
    <body class="bg-gray-200">
        <div class="flex justify-center items-center min-h-screen">
            <div class="bg-white p-8 rounded shadow-md">
                <h2 class="text-2xl font-bold mb-4">Excluir Produto</h2>
                <p>Deseja realmente excluir o produto "<?php echo $nome; ?>"?</p>
                <form method="post">
                    <div class="flex justify-between mt-4">
                        <button type="submit" onclick="return confirmarExclusao()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Excluir</button>
                        <a href="listar_produtos.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancelar</a>
                    </div>
                </form>
                <a href="admin.php" class="block mt-4 text-blue-500 hover:text-blue-700">Voltar</a>
            </div>
        </div>
    </body>
    </html>

    <?php
  } else {
    echo "Produto não encontrado.";
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
} else {
  echo "ID do produto não fornecido na URL.";
}
?>

