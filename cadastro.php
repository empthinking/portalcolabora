<?php
require_once "dbconn.php";
require_once "funcoes.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Verifica se a conexão foi estabelecida corretamente
  if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
  }

  // Obtém os valores do formulário
  $user_nome = isset($_POST["user_nome"]) ? $_POST["user_nome"] : "";
  $user_email = isset($_POST["user_email"]) ? $_POST["user_email"] : "";
  $user_senha = isset($_POST["user_senha"]) ? $_POST["user_senha"] : "";
  $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";
  $user_tel = isset($_POST["user_tel"]) ? $_POST["user_tel"] : "";
  $permissao_publicar = isset($_POST["permissao_publicar"]) ? $_POST["permissao_publicar"] : "";

  // Validação dos dados (exemplo)
  // Aqui você pode adicionar suas próprias regras de validação
  $errors = array();

  if (empty($user_nome)) {
    $errors[] = "O campo 'Nome completo' é obrigatório.";
  }

  if (empty($user_email)) {
    $errors[] = "O campo 'Email' é obrigatório.";
  } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "O campo 'Email' não possui um formato válido.";
  }

  if (empty($user_senha)) {
    $errors[] = "O campo 'Senha' é obrigatório.";
  } elseif (strlen($user_senha) < 8) {
    $errors[] = "A senha deve ter pelo menos 8 caracteres.";
  }

  if ($user_senha !== $confirm_password) {
    $errors[] = "As senhas não correspondem.";
  }

  // Verifica se há erros de validação
  if (count($errors) == 0) {
    // Verifica se o email já está em uso
    $sql_check_email = "SELECT * FROM usuarios WHERE user_email = '$user_email'";
    $result_check_email = $conn->query($sql_check_email);

    if ($result_check_email->num_rows > 0) {
      $errors[] = "Este email já está em uso. Por favor, escolha outro email.";
    } else {
      // Criptografa a senha
      $hashed_password = password_hash($user_senha, PASSWORD_DEFAULT);

      // Insere os dados no banco de dados
      $sql = "INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel, permissao_publicar)
              VALUES ('$user_nome', '$user_email', '$hashed_password', '$user_tel', '$permissao_publicar')";

      if ($conn->query($sql) === TRUE) {
        // Sucesso ao inserir os dados
        echo "Cadastro realizado com sucesso!";
      } else {
        // Erro ao inserir os dados
        echo "Erro ao cadastrar: " . $conn->error;
      }
    }
  } else {
    // Exibe os erros de validação
    foreach ($errors as $error) {
      echo $error . "<br>";
    }
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Colabora</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/main.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,300,0,0" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
</head>

<body>
  <div class="flex justify-center">
    <img src="./img/logo G (2).png" alt="Descrição da imagem">
  </div>

  <main>
    <section class="bg-gray-100 py-8">
      <div class="container mx-auto">
        <div class="max-w-lg mx-auto">
          <h2 class="text-3xl font-semibold text-center mb-8">Cadastre-se</h2>
          <form class="bg-white shadow-md rounded-lg w-full max-w-md mx-auto p-8" method="POST"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="nome">
                Nome completo
              </label>
              <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="nome" name="user_nome" type="text" value="" placeholder="Seu nome completo">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="user_email"
                value="<?php echo htmlspecialchars($user_email); ?>">
                <?php if (isset($erro_email)) {
                  echo '<div class="erro">' . $erro_email . '</div>';
                } ?>
                Email
              </label>
              <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="user_email" name="user_email" type="email" placeholder="Seu endereço de email">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="senha">
                Senha
              </label>
              <div class="relative">
                <input class="user_senha-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  id="senha" name="user_senha" type="password" value="" placeholder="Sua senha">
                <span class="absolute top-0 right-0 mr-4 mt-5">
                  <button type="button" id="showPassword" class="text-gray-500 font-semibold focus:outline-none">
                    <i class="fas fa-eye"></i>
                  </button>
                </span>
              </div>
              <p class="text-gray-600 text-xs italic">Sua senha deve ter pelo menos 8 caracteres.</p>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="confirma-senha">
                Confirme sua senha
              </label>
              <div class="relative">
                <input class="user_senha-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  id="confirma-senha" name="confirm_password" type="password" value="" placeholder="Confirme sua senha">
                <span class="absolute top-0 right-0 mr-4 mt-5">
                  <button type="button" id="showConfirmPassword" class="text-gray-500 font-semibold focus:outline-none">
                    <i class="fas fa-eye"></i>
                  </button>
                </span>
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="telefone">
                Telefone
              </label>
              <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="telefone" name="user_tel" type="text" placeholder="Seu número de telefone">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="radio-comprador">
                Comprador
                <input class="mr-2" type="radio" id="radio-comprador" name="permissao_publicar" value="0" checked>
              </label>
              <label class="block text-gray-700 font-bold mb-2" for="radio-produtor">
                Produtor
                <input class="mr-2" type="radio" id="radio-produtor" name="permissao_publicar" value="1">
              </label>

              <div class="flex items-center">
                <input type="checkbox" id="termos" name="termos" class="form-checkbox mr-2">
                <label for="termos" class="text-gray-700 font-bold mb-2">
                  Eu concordo com os Termos e Condições
                </label>
              </div>
              <a href="temospublica.php">
                <p class="text-blue-600 text-xs italic">termos.</p>
              </a>
            </div>
            <div class="flex justify-between">
              <button class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Cadastrar
              </button>
              <a href="index.php"
                class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Voltar
              </a>
            </div>
          </form>
        </div>
      </div>
      </section>
  </main>

  <script src="https://kit.fontawesome.com/xxxxxxxxxx.js" crossorigin="anonymous"></script> <!-- Substitua xxxxxxxxxx pelo seu kit ID do FontAwesome -->
  <script>
    var showPasswordBtn = document.querySelector('#showPassword');
    var showConfirmPasswordBtn = document.querySelector('#showConfirmPassword');
    var passwordInput = document.querySelector('#senha');
    var confirmPasswordInput = document.querySelector('#confirma-senha');

    showPasswordBtn.addEventListener('click', function () {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        passwordInput.type = 'password';
        showPasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });

    showConfirmPasswordBtn.addEventListener('click', function () {
      if (confirmPasswordInput.type === 'password') {
        confirmPasswordInput.type = 'text';
        showConfirmPasswordBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        confirmPasswordInput.type = 'password';
        showConfirmPasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });
  </script>
  <?= require_once "footer.php"; ?>
</body>
