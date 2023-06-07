<?php
session_start();
require_once 'db.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtém os valores do formulário
  $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
  $email = isset($_POST["email"]) ? $_POST["email"] : "";
  $assunto = isset($_POST["assunto"]) ? $_POST["assunto"] : "";
  $mensagem = isset($_POST["mensagem"]) ? $_POST["mensagem"] : "";

  // Validação dos dados (exemplo)
  // Aqui você pode adicionar suas próprias regras de validação
  $errors = array();

  if (empty($nome)) {
    $errors[] = "O campo 'Nome completo' é obrigatório.";
  }

  if (empty($email)) {
    $errors[] = "O campo 'E-mail' é obrigatório.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "O campo 'E-mail' não possui um formato válido.";
  }

  if (empty($assunto)) {
    $errors[] = "O campo 'Assunto' é obrigatório.";
  }

  if (empty($mensagem)) {
    $errors[] = "O campo 'Mensagem' é obrigatório.";
  }

  // Verifica se há erros de validação
  if (count($errors) == 0) {
    // Configurações do e-mail
    $to = "suporte@portalcolabora.com.br"; 
    $subject = "Contato do Site - $assunto";
    $message = "Nome: $nome\n\n";
    $message .= "E-mail: $email\n\n";
    $message .= "Mensagem:\n$mensagem";

    // Envia o e-mail
    $headers = "From: $nome <$email>";
    if (mail($to, $subject, $message, $headers)) {
      // E-mail enviado com sucesso
      echo "<span class='text-green-500'>Sua mensagem foi enviada com sucesso!</span>";
    } else {
      // Erro ao enviar o e-mail
      echo "<span class='text-red-500'>Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente mais tarde.</span>";
    }
  }else {
    // Exibe os erros de validação
    foreach ($errors as $error) {
      echo "<p class='text-red-500'>$error</p>";
    }
  }
}

require_once 'header.php';
?>

<div class="container m-3"> 
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
      <label for="nome">Nome completo</label>
      <input class="form-control" type="text" id="nome" name="nome" placeholder="Seu nome completo" value="<?php echo isset($nome) ? $nome : ''; ?>">
    </div>
    <div class="form-group">
      <label for="email">E-mail</label>
      <input class="form-control" type="email" id="email" name="email" placeholder="Seu e-mail" value="<?php echo isset($email) ? $email : ''; ?>">
    </div>
    <div class="form-group">
      <label for="assunto">Assunto</label>
      <input class="form-control" type="text" id="assunto" name="assunto" placeholder="Assunto da mensagem" value="<?php echo isset($assunto) ? $assunto : ''; ?>">
    </div>
    <div class="form-group">
      <label for="mensagem">Mensagem</label>
      <textarea class="form-control" id="mensagem" name="mensagem" placeholder="Digite sua mensagem"><?php echo isset($mensagem) ? $mensagem : ''; ?></textarea>
    </div>
    <button class="btn btn-primary" type="submit">Enviar mensagem</button>
  </form>
</div>

<?php require_once 'footer.php'; ?>
