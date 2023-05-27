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
  // Verifica se o formulário foi enviado
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['produto_id'])) {


  // Consulta os produtos do usuário logado
  $produtos = listar_produtos_por_usuario($_SESSION['usuario_id']);
  }
?>
<div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
  <?php
    // Consulta os produtos do usuário logado
    $sql = "SELECT * FROM produtos WHERE usuario_id = $usuario_id";
    $result = mysqli_query($conn, $sql);

    // Verifica se o usuário possui produtos cadastrados
    if (mysqli_num_rows($result) == 0) {
        echo "<h3 class='text-lg leading-6 font-medium text-gray-900'>Meus Produtos</h3>";
        echo "<p>Você ainda não cadastrou nenhum produto.</p>";
        echo "<p><button type='button' onclick=\"location.href='addproduto.php'\">Adicionar Produto</button></p>";
    } else {
      echo "<h3 class='text-lg leading-6 font-medium text-gray-900'>Meus Produtos</h3>";
      echo "<table>";
      echo "<tr><th>Nome</th><th>Descrição</th><th>Preço</th><th>Imagem</th><th>Opções</th></tr>";
      while ($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          echo "<td>" . $row['nome'] . "</td>";
          echo "<td>" . $row['descricao'] . "</td>";
          echo "<td>" . $row['preco'] . "</td>";
          if (!empty($row['imagem'])) {
              echo "<td><img src='" . $row['imagem'] . "' width='100'></td>";
          } else {
              echo "<td>N/A</td>";
          }
          echo "<td><a href='editar_produto.php?id=" . $row['id'] . "'><img src='https://www.gstatic.com/images/icons/material/system_gm/1x/create_black_24dp.png' alt='Editar'></a> | <a href='excluir_produto.php?id=" . $row['id'] . "' onclick=\"return confirm('Tem certeza que deseja excluir esse produto?')\">Excluir</a></td>";
          echo "</tr>";
      }
      echo "</table>";
    }

    mysqli_close($conn);
  ?>
  <a href="addProduto.php">
    <button class='bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2' type='button'>Adicionar Produto </button>
  </a>
  <button type="button" onclick="document.getElementById('meusProdutos').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">Cancelar</button>
</div>
