<?php 

$servername = "localhost";
$user = "u871226378_colabora";
$password = 'F7k|MYhYf>';
$db_name = "u871226378_portalcolabora";

$conn = mysqli_connect($servername, $user, $password, $db_name);



// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$username = $password = $tel = $confirm_password = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $tel = $_POST["tel"];
    $confirm_password = $_POST["confirm_password"];
  
    $sql = "INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password, $tel);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  
       
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,300,0,0" />    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
</head>
<main>
        <section class="bg-gray-100 py-8">
            <div class="container mx-auto">
              <div class="max-w-lg mx-auto">
                <h2 class="text-3xl font-semibold text-center mb-8">Cadastre-se</h2>
                <form class="bg-white shadow-md  rounded-lg w-full max-w-md mx-auto p-8" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="nome">
                        Nome completo
                      </label>
                      <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" name="username" type="text" value="<?php echo $username; ?>" placeholder="Seu nome completo">
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="email">
                        Email
                      </label>
                      <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" placeholder="Seu endereço de email">
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="senha">
                        Senha
                      </label>
                      <input class="password-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="senha" name="password" type="password" value="<?php echo $password; ?>" placeholder="Sua senha">
                      <p class="text-gray-600 text-xs italic">Sua senha deve ter pelo menos 8 caracteres.</p>
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="confirma-senha">
                        Confirme sua senha
                      </label>
                      <input class="password-input appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="confirma-senha" name="confirm_password" type="password" value="<?php echo $confirm_password; ?>" placeholder="Confirme sua senha">
                    </div>
                    <button type="button" id="showPassword">Mostrar senha</button>
                    <div class="mb-4">
                      <label class="block text-gray-700 font-bold mb-2" for="telefone">
                        Telefone
                      </label>
                      <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telefone" name="tel" type="text" placeholder="Seu número de telefone">
                    </div>
                    <div class="flex items-center justify-between">
                      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submmit">
                        Cadastrar
                      </button>
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
