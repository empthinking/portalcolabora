<?php
session_start();

require_once "dbconn.php";
require_once "funcoes.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Verifica se a conexão foi estabelecida corretamente
  if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
  }

  // Obtém os valores do formulário
  $email = isset($_POST["email"]) ? $_POST["email"] : "";
  $password = isset($_POST["password"]) ? $_POST["password"] : "";

  // Validação dos dados (exemplo)
  // Aqui você pode adicionar suas próprias regras de validação
  $errors = array();

  if (empty($email)) {
    $errors[] = "O campo 'Email' é obrigatório.";
  }

  if (empty($password)) {
    $errors[] = "O campo 'Senha' é obrigatório.";
  }

  // Verifica se há erros de validação
  if (count($errors) == 0) {
    // Busca o usuário no banco de dados pelo email
    $sql = "SELECT * FROM usuarios WHERE user_email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

      // Verifica se a senha está correta
      if (password_verify($password, $row['user_senha'])) {
        // Sucesso ao fazer login
        $_SESSION['login'] = true;
        $_SESSION['id'] = $row['user_id'];
        $_SESSION['username'] = $row['user_nome'];
        $_SESSION['email'] = $row['user_email'];
        $_SESSION['number'] = $row['user_tel'];

        // Redireciona para a página inicial (index.php, por exemplo)
        header("Location: index.php");
        exit();
      } else {
        $errors[] = "Senha incorreta.";
      }
    } else {
      $errors[] = "Usuário não encontrado.";
    }
  }

  // Exibe os erros de validação
  foreach ($errors as $error) {
    echo $error . "<br>";
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
}
?>
