<?php
session_start();
require_once "db.php";
require_once "header.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header("Location: index.php");
  exit();
}

// Obtém o ID do usuário da sessão
$usuario_id = $_SESSION['id'] ?? '';
if ($usuario_id === '') {
  header("Location: index.php");
  exit();
}

$query = "SELECT * FROM Users WHERE User_Id = $usuario_id";
$result = mysqli_query($db, $query);

// Verifica se o usuário existe no banco de dados
if (mysqli_num_rows($result) != 1) {
  header("Location: logout.php");
  exit();
}

// Obtém as informações do usuário
$user = mysqli_fetch_assoc($result);

// Define as variáveis nome, email e número com as informações do usuário
$permissao_publicar = $user['permissao_publicar'];
$nome = $user['User_Name'];
$email = $user['User_Email'];
$numero = $user['User_Number'];

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>

<body>
  <div class="flex items-center justify-center mt-8">
    <div class="bg-white rounded-lg p-8">
      <h3 class="text-3xl font-bold">Perfil</h3>
      <div class="mt-6">
        <h3 class="text-2xl font-bold">Nome</h3>
        <h3 class="text-3xl font-bold text-gray-500"><?php echo $nome ?></h3>
        <h3 class="text-2xl font-bold">Email</h3>
        <h3 class="text-3xl font-bold text-gray-500"><?php echo $email ?></h3>
        <div id="btp" class="mt-4">
          <h3 class="text-2xl font-bold">Número</h3>
          <h3 class="text-3xl font-bold text-gray-500"><?php echo $numero ?></h3>
        </div>
        <br>

        <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2"
          onclick="document.getElementById('historicoProdutos').style.display='block'">mensagens</button>
        <div id="historicoProdutos" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
          <div class="flex items-center justify-center min-h-screen absolute inset-0 bg-gray-900 opacity-90">
            <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
              <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                  <!-- Conteúdo do modal -->
                </div>
                <div class="border-t border-gray-200">
                  <!-- Conteúdo do modal -->
                </div>
              </div>
              <button type="button" onclick="document.getElementById('historicoProdutos').style.display='none'"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                Cancelar
              </button>
            </div>
          </div>
        </div>

        <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2"
          onclick="document.getElementById('modaleditarPerfil').style.display='block'">editar perfil</button>
        <div id="modaleditarPerfil" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
          <div class="flex items-center justify-center min-h-screen absolute inset-0 bg-gray-900 opacity-90">
            <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Editar Perfil</h3>
              <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                  <!-- Conteúdo do modal -->
                </div>
                <div class="border-t border-gray-200">
                  <!-- Conteúdo do modal -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <a href="meus_produtos.php">
          <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2">
            Meus Produtos
          </button>
        </a>
      </div>
    </div>
  </div>  
</body>
<?php require_once 'footer.php'; ?>