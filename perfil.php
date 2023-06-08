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
$nome = $user['User_Name'];
$email = $user['User_Email'];
$numero = $user['User_Number'];

// Fecha a conexão com o banco de dados
mysqli_close($db);
?>

<main class="align-items-center justify-content-center mt-5">
  <fieldset class="bg-light opacity-60 p-4 rounded">
    <h2 class="text-center mb-5">PERFIL DE USUÁRIO</h2>
    <div class="d-flex justify-content-center align-items-start mt-5">
      <div class="text-start">
        <h3>NOME: <?php echo $nome; ?></h3>
        <h3>EMAIL: <?php echo $email; ?></h3>
        <h3>NÚMERO: <?php echo $numero; ?></h3>
      </div>
    </div>
  </fieldset>
  <div class="profile-actions justify-content-between mt-3 text-center">
    <a href="editar_perfil.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-success">Editar Perfil</a>
    <a href="mensagens.php" class="btn btn-primary">Mensagens</a>
  </div>
</main>

<?php require_once 'footer.php'; ?>