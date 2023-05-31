<?php
session_start();
ob_start();
function isUserLoggedIn(): bool
{
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
    <div class="flex items-center justify-centermt-  menu-overlay">
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


                <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2"
                    onclick="document.getElementById('historicoProdutos').style.display='block'">mensagens</button>
                <div id="historicoProdutos" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900"
                        style="opacity: 0.9;">
                        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                </div>
                                <div class="border-t border-gray-200">
                                    <?= require_once "mensagem_recebidas.php"; ?>
                                </div>
                            </div>
                            <button type="button"
                                onclick="document.getElementById('historicoProdutos').style.display='none'"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>


                <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2"
                    onclick="document.getElementById('editarPerfil').style.display='block'">editar perfil</button>

                <div id="editarPerfil" style="display: none;" class="fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900"
                        style="opacity: 0.9;">
                        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">editar perfil</h3>
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                </div>
                                <div class="border-t border-gray-200">
                                    <?= require_once "editar_perifil.php"; ?>
                                </div>
                            </div>
                            <button type="button" onclick="document.getElementById('editarPerfil').style.display='none'"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>

                <button class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2"
                    onclick="document.getElementById('meusProdutos').style.display='block'">Meus Produtos</button>
                <div id="meusProdutos" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900"
                        style="opacity: 0.9;">
                        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">editar perfil</h3>
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                </div>
                                <div class="border-t border-gray-200">
                                    <?= require_once "meus_produtos.php"; ?>
                                </div>
                            </div>
                            <button type="button" onclick="document.getElementById('meusProdutos').style.display='none'"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

<?= require_once "footer.php"; ?>