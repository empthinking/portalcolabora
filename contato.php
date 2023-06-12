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
    $errors['name'] = "O campo 'Nome completo' é obrigatório.";
  }

  if (empty($email)) {
    $errors['email'] = "O campo 'E-mail' é obrigatório.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "O campo 'E-mail' não possui um formato válido.";
  }

  if (empty($assunto)) {
    $errors['subject'] = "O campo 'Assunto' é obrigatório.";
  }

  if (empty($mensagem)) {
    $errors['message'] = "O campo 'Mensagem' é obrigatório.";
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
      $success = "Sua mensagem foi enviada com sucesso!";
    } else {
      // Erro ao enviar o e-mail
      $errors['send'] = "Ocorreu um erro ao enviar a mensagem.";
    }
  }
}

require_once 'header.php';

if(isset($success))
echo <<<MSG
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>$success</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
MSG;
?>

<div class="container d-flex justify-content-center align-items-center">
    <div class="w-75">
        <h1 class="text-center mt-3">Fale Conosco</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="nome">Nome completo</label>
                <input class="form-control" type="text" id="nome" name="nome" placeholder="Seu nome completo"
                    value="<?php echo isset($nome) ? $nome : ''; ?>">
                <span class="text-danger"><?php echo $errors['name']??''; ?></span>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Seu e-mail"
                    value="<?php echo isset($email) ? $email : ''; ?>">
                <span class="text-danger"><?php echo $errors['email']??''; ?></span>
            </div>
            <div class="form-group">
                <label for="assunto">Assunto</label>
                <input class="form-control" type="text" id="assunto" name="assunto" placeholder="Assunto da mensagem"
                    value="<?php echo isset($assunto) ? $assunto : ''; ?>">
                <span class="text-danger"><?php echo $errors['subject']??''; ?></span>
            </div>
            <div class="form-group">
                <label for="mensagem">Mensagem</label>
                <textarea class="form-control" id="mensagem" name="mensagem"
                    placeholder="Digite sua mensagem"><?php echo isset($mensagem) ? $mensagem : ''; ?></textarea>
                <span class="text-danger"><?php echo $errors['message']??''; ?></span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Enviar mensagem</button>
                <a class="btn btn-danger" href="index.php">Voltar</a>
                <span class="text-danger"><?php echo $errors['send']??''; ?></span>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
