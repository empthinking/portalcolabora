<?php
// Define um tempo de expiração de 1 hora para o cookie da sessão
$hora = 3600; // 1 hora em segundos
session_set_cookie_params($hora);

// Inicia a sessão
session_start();
require_once "dbconn.php";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtém as credenciais do usuário do formulário
  $email = $_POST["email"];
  $senha = $_POST["senha"];

  // Constrói a consulta SQL para verificar se o usuário e senha existem no banco de dados
  $sql = "SELECT * FROM usuarios WHERE user_email = '$email' AND user_senha = '$senha'";

  // Executa a consulta
  $result = mysqli_query($conn, $sql);

  // Verifica se a consulta retornou algum registro
  if (mysqli_num_rows($result) == 1) {
    // Se houver registro, inicia a sessão do usuário
    $usuario = mysqli_fetch_assoc($result);
    $_SESSION["usuario_id"] = $usuario["user_id"];

    // Redireciona o usuário para a página de perfil
    header("Location: perfil.php");
    exit();
  } else {
    // Se não houver registro, exibe uma mensagem de erro
    $erro = "Nome de usuário ou senha incorretos";
  }
}
// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <h1>Login</h1>
  <?php if (isset($erro)): ?>
    <p style="color: red;"><?php echo $erro ?></p>
  <?php endif; ?>
  <form method="POST">
    <p>
      <label for="email">E-mail:</label>
      <input type="email" name="email">
    </p>
    <p>
      <label for="senha">Senha:</label>
      <input type="password" name="senha">
    </p>
    <p>
      <button type="submit">Entrar</button>
    </p>
  </form>
</body>
</html>