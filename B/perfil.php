<?php
session_start();
ob_start();
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}
require_once "header_loggedin.php";
require_once "dbconn.php";


// Obtém as informações do usuário a partir do ID armazenado na sessão
$usuario_id = $_SESSION['id'] ?? null;
if ($usuario_id === null) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM usuarios WHERE user_id = $usuario_id";
$result = mysqli_query($conn, $query);

// Verifica se o usuário existe no banco de dados
if (mysqli_num_rows($result) != 1) {
    header("Location: logout.php");
    exit();
}

// Obtém as informações do usuário
$user = mysqli_fetch_assoc($result);

// Define as variáveis nome, email e número com as informações do usuário
$permissao_publicar = $user['permissao_publicar'];
$nome = $user['user_nome'];
$email = $user['user_email'];
$numero = $user['user_tel'];
if ($user['user_imagem'] == null) {
  $caminho_imagem = "img/perfil.png";
} else {
  $caminho_imagem = $user['user_imagem'];
}

?>
<body>
    <div class="flex items-center justify-centermt-  menu-overlay" >
        <div class="bg-white rounded-lg  m-64 mx-auto p-8">
          <h3 class="text-3xl font-bold">Perfil</h3>
        <figure class="mt-4">
        <img id="perfil" src="<?php echo $caminho_imagem; ?>" class="rounded-full w-32 h-32">
        </figure>
        <div class="mt-6">
          <h3 class="text-2xl font-bold">Nome</h3>
          <h3 class="text-3xl font-bold text-gray-500"><?php echo $nome ?></h3>
          <h3 class="text-2xl font-bold">Email</h3>
          <h3 class="
text-3xl font-bold text-gray-500"><?php echo $email ?></h3>
          <div id="btp" class="mt-4">
            <h3 class="text
-2xl font-bold">Número</h3>
            <h3 class="text-3xl font-bold text-gray-500"><?php echo $numero ?></h3>
                     </div>
                     <br>

<button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('historicoProdutos').style.display='block'">Historico de Compra</button>
<div id="historicoProdutos" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900" style="opacity: 0.9;">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Historico de Compra</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
              </div>
              <div class="border-t border-gray-200">
                <dl>
                  <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Data da Compra
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      01/01/2022
                    </dd>
                  </div>
                  <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Total
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      R$ 100,00
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
                <button type="button" onclick="document.getElementById('historicoProdutos').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                Cancelar
                </button>
            </div>
            </div>
        </div> 
   
       
        <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('editPerfil').style.display='block'">editar Perfil</button>
<div id="editPerfil" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
  
<?=require_once "editar_perifil.php";?>             

        </div>
        <?php if ($permissao_publicar == true): ?>
  <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('meusProdutos').style.display='block'">Meus Produtos</button>
  <div id="meusProdutos" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900" style="opacity: 0.9;">
      <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
        <?php
        // Consulta os produtos do usuário logado
        $sql = "SELECT * FROM produtos WHERE usuario_id = $usuario_id";
        $result = mysqli_query($conn, $sql);

        // Verifica se o usuário possui produtos cadastrados
        if (mysqli_num_rows($result) == 0) {
          echo "<h3 class='text-lg leading-6 font-medium text-gray-900'>Meus Produtos</h3>";
          echo "<p>Você ainda não cadastrou nenhum produto.</p>";
          echo "<a href='addproduto.php' class='bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full mt-4'>Adicionar Produto</a>";
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
          echo "<a href='addproduto.php' class='bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full mt-4'>Adicionar Produto</a>";
        }

        mysqli_close($conn);
        ?>
        <button type="button" onclick="document.getElementById('meusProdutos').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">Cancelar</button>
      </div>
    </div>
  </div>
<?php else: ?>
  <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('adicionarProduto').style.display='block'">Adicionar Produto</button>
  <div id="adicionarProduto" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
      <h3>Deseja anunciar um produto?</h3>
      <form action="perfil.php" method="POST">
  <button type="submit" name="sim" class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full mt-4">Sim</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verifica se o botão "Sim" foi clicado
  if (isset($_POST['sim'])) {
    // Realiza a atualização da permissão no banco de dados
    $valor = 1; // Valor para permissao_publicar = 1

    // Crie uma conexão
    // Verifique se a conexão foi estabelecida corretamente
    if ($conn->connect_error) {
      die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Execute a query para atualizar a permissão no banco de dados
    $usuario_id = $user['user_id']; // Substitua pelo ID do usuário atual
    $sql = "UPDATE usuarios SET permissao_publicar = $valor WHERE user_id = $usuario_id";

    if ($conn->query($sql) === TRUE) {

    } else {
      echo "Erro ao atualizar a permissão: " . $conn->error;
    }

    // Feche a conexão com o banco de dados
    $conn->close();
  }
}
?>
      <button onclick="document.getElementById('adicionarProduto').style.display='none'" class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full mt-4">Não</button>
    </div>
  </div>
<?php endif; ?>


</div>
</div>
</div>
</body> 

<?=require_once "footer.php";?>             


