<?php
session_start();
require_once "dbconn.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  // Redireciona para a página de login se o usuário não estiver logado
  header("Location: login.php");
  exit;
}

$erros = array();
$erro = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtém os dados do formulário
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $confirmaSenha = $_POST['confirma_senha'];

  // Validação dos campos
  if (empty($nome) || empty($email) || empty($senha) || empty($confirmaSenha)) {
    $erros[] = "Todos os campos devem ser preenchidos.";
  }

  if ($senha !== $confirmaSenha) {
    $erros[] = "As senhas não coincidem.";
  }

  // Verifica se houve erros de validação
  if (empty($erros)) {
    // Atualiza os dados do usuário no banco de dados
    $id = $_SESSION['id'];
    $nome = mysqli_real_escape_string($conn, $nome);
    $email = mysqli_real_escape_string($conn, $email);
    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET user_nome = '$nome', user_email = '$email', user_senha = '$senha' WHERE id = $id";

    if ($conn->query($sql) === true) {
      echo "Perfil atualizado com sucesso.";
    } else {
      echo "Erro ao atualizar perfil: " . $conn->error;
    }
  }
}

// Obtém os dados do usuário do banco de dados
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
  $sql = "SELECT id, user_nome, user_email FROM usuarios WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
  } else {
    echo "Usuário não encontrado.";
  }
} else {
  echo "ID do usuário não fornecido.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!-- HTML -->
<div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900">
  <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8" style="max-height: 90vh; overflow-y: auto;">
    <h1 class="text-2xl font-bold mb-4">Editar perfil</h1>

    <?php if (!empty($erros)) : ?>
      <ul class="list-disc list-inside mb-4">
        <?php foreach ($erros as $erro) : ?>
          <li><?php echo $erro; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if (!empty($erro)) : ?>
      <p class="text-red-500 mb-4"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="post">
      <div class="mb-4">
        <label for="nome" class="block font-medium mb-2">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $row['user_nome']; ?>" class="border rounded py-2 px-3 w-full">
      </div>
      <div class="mb-4">
        <label for="email" class="block font-medium mb-2">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $row['user_email']; ?>" class="border rounded py-2 px-3 w-full">
      </div>
      <div class="mb-4">
        <label for="senha" class="block font-medium mb-2">Senha:</label>
        <input type="password" name="senha" id="senha" class="border rounded py-2 px-3 w-full">
      </div>
      <div class="mb-4">
        <label for="confirma_senha" class="block font-medium mb-2">Confirmar senha:</label>
        <input type="password" name="confirma_senha" id="confirma_senha" class="border rounded py-2 px-3 w-full">
      </div>
      <div>
        <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Salvar alterações</button>
      </div>
    </form>

    <button type="button" onclick="document.getElementById('modaleditarPerfil').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
      Cancelar
    </button>
  </div>
</div>
