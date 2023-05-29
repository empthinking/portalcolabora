<?php
// Inicia a sessão
session_start();

function isUserLoggedIn(): bool {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Cabeçalho
if(isUserLoggedIn()):
  require_once 'header_loggedin.php';
else:
  require_once 'header.php';
endif;

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
    $to = "colaboraequipe@gmail.com"; 
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
?>

<main>
  <section class="bg-gray-100 py-16">
    <div class="container mx-auto">
      <h2 class="text-3xl font-bold mb-8 text-center">Contato</h2>
      <div class="flex flex-wrap">
        <div class="w-full md:w-2/3 md:pr-8">
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="nome">
                Nome completo
              </label>
              <input
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="nome" name="nome" type="text" placeholder="Seu nome completo" value="<?php echo isset($nome) ? $nome : ''; ?>">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="email">
                E-mail
              </label>
              <input
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" name="email" type="email" placeholder="Seu e-mail" value="<?php echo isset($email) ? $email : ''; ?>">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="assunto">
                Assunto
              </label>
              <input
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="assunto" name="assunto" type="text" placeholder="Assunto da mensagem" value="<?php echo isset($assunto) ? $assunto : ''; ?>">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="mensagem">
                Mensagem
              </label>
              <textarea
                class="no-resize appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="mensagem" name="mensagem" placeholder="Digite sua mensagem"><?php echo isset($mensagem) ? $mensagem : ''; ?></textarea>
            </div>
            <div class="flex items-center justify-between">
              <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Enviar mensagem
              </button>
            </div>
          </form>
        </div>
        <div class="w-full md:w-1/3">
          <h4 class="text-xl font-bold mb-4">Informações de contato</h4>
          <p class="mb-2"><i class="fas fa-phone-alt mr-2"></i>(91) 9999-9999</p>
          <p class="mb-2"><i class="fas fa-envelope mr-2"></i>colaboraequipe@gmail.com</p>
          <p><i class="fas fa-map-marker-alt mr-2"></i>Rua  XXX_XXX, XXXXXXX-XX</p>
        </div>
      </div>
    </div>
  </section>
</main>
</body>
<?php
require_once "footer.php";
?>
