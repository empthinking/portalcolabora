<?php

// Função de validação de número de telefone (expressão regular)
function validatePhone($phone)
{
  // Remove tudo exceto números do telefone
  $phone = preg_replace("/[^0-9]/", "", $phone);
  // Verifica se o telefone tem o formato correto
  return preg_match("/^\d{11}$/", $phone);
}
//check de usuário logado
function usuario_logado(): bool
{
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

//requisitando a conexão com o banco de dados.
require_once 'database.php';

//função para chekar email existente
function checar_email(mysqli $mysqli, string $email): bool
{
  $stmt = $mysqli->prepare('SELECT user_email FROM usuarios WHERE user_email = ?');
  $stmt->bind_param('s', $email);
  if (!$stmt->execute())
    return FALSE;
  $result = $stmt->get_result();
  return $result->num_rows > 0;
}
//Criando um novo usuário no banco de dados
$username = $email = $password = $confirm_password = $cellphone = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") :
  $username          = $_POST['username'];
  $email             = $_POST['email'];
  $password          = $_POST['password'];
  $confirm_password  = $_POST['confirm_password'];
  $cellphone         = $_POST['number'];
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  //Validação local das senha no fomulário.

  //Confirmação do email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
    // Se o e-mail não for válido, definir uma mensagem de erro
    echo '<script>alert("O endereço de e-mail não é válido")</script>';
  //checa se o email já está registrado
  elseif (checar_email($mysqli, $email)) :
    echo '<script>alert("Endereço de email já cadastrado")</script>';
  //Confirmação da senha
  elseif ($password !== $confirm_password) :
    echo '<script>alert("Insira corretamente a confirmação")</script>';
  //validação do senha com menos de 8 dígitos
  elseif (strlen($password) < 8) :
    echo '<script>alert("A senha é muito curta!")</script>';
  //confirmação de telefone
  elseif (!validatePhone($cellphone)) :
    echo '<script>alert("O número de telefone não é válido")</script>';
  else :
    // Inclusão no Banco de Dados
    $stmt = $mysqli->prepare('INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES(?, ?, ?, ?)');
    $stmt->bind_param('sssi', $username, $email, $password_hash, $cellphone);
    $stmt->execute();
    if ($mysqli->error)
      throw new Exception($this->mysqli->error);
    $stmt->close();
    $mysqli->close();

    //Alerta de registro efetuado
    session_start();
    $_SESSION['success_msg'] = 'Registro completado com sucesso';
    // echo '<script>alert("' . htmlspecialchars($_SESSION['success_msg']) . '")</script>';

    //inicialização de uma nova sessão.

    header('location: index.php');
  endif;

endif;
?>

<?php
// Cabeçalho
require_once 'header.php';
?>

<main>
  <section class="bg-gray-100 py-8">
    <div class="container mx-auto">
      <div class="max-w-lg mx-auto">
        <h2 class="text-3xl font-semibold text-center mb-8">Cadastre-se</h2>

        <!-- Formulário de cadastro -->
        <form class="bg-white shadow-md  rounded-lg w-full max-w-md mx-auto p-8" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="mb-4">
            <!-- Nome -->
            <label class="block text-gray-700 font-bold mb-2" for="nome">
              Nome completo
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" name="username" type="text" value="" placeholder="Seu nome completo">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="email" value="<?php echo htmlspecialchars($email); ?>">
              <?php if (isset($erro_email)) {
                echo '<div class="erro">' . $erro_email . '</div>';
              } ?>
              Email
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" placeholder="Seu endereço de email">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="senha">
              Senha
            </label>
            <input class="password-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="senha" name="password" type="password" value="" placeholder="Sua senha">
            <p class="text-gray-600 text-xs italic">Sua senha deve ter pelo menos 8 caracteres.</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="confirma-senha">
              Confirme sua senha
            </label>
            <input class="password-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="confirma-senha" name="confirm_password" type="password" value="" placeholder="Confirme sua senha">
          </div>
          <button type="button" id="showPassword">Mostrar senha</button>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="telefone">
              Telefone
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telefone" name="number" type="text" placeholder="(DDD) 9XXXX-XXXX">
          </div>
          <div class="flex justify-between">
            <button class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
              Cadastrar
            </button>
            <a href="index.php" class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
              Voltar
            </a>
          </div>


        </form>
      </div>
    </div>
    </div>
  </section>
</main>
</body>
<script>
  var showPasswordBtn = document.querySelector('.show-password-btn');
  var passwordInput = document.querySelector('.password-input');

  showPasswordBtn.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      showPasswordBtn.textContent = 'Ocultar senha';
    } else {
      passwordInput.type = 'password';
      showPasswordBtn.textContent = 'Mostrar senha';
    }
  });
</script>

</html>