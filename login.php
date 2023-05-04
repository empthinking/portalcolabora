<?php
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}
//estabelece a conexao com o banco de dados
//objeto $mysqli
require_once 'database.php';

//caso o usuario nao esteja logado, realiza o login e redireciona para a pagina principal
if(!isUserLoggedIn()):
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    
    //Prepara uma declaracao SQL
    $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE user_email = ?');

    //Adiciona a string de email na variavel '?'
    $stmt->bind_param('s', $email);

    //Executa a declaracao e checa se foi executada com sucesso
    if ($stmt->execute()):

        //cria um objeto contendo os resultados da requisicao
        $result = $stmt->get_result();
        
        //cria um array associativo contendo as informacoes obtidas
        $row = $result->fetch_assoc();

        //limpa os resultados do objeto
        $result->free_result();
    else: 
        //Em caso de falha, envia o respectivo erro
        $_SESSION['login_error'] = 'Email ou senha não encontrado';
        throw new Exception($mysqli->error);
    endif;

    //Verifica se o usuario esta cadastrado e realiza o login
    if (password_verify($password, $row['user_senha'])):
        $_SESSION['login'] = true;
        $_SESSION['id'] = $row['user_id'];
        $_SESSION['username'] = $row['user_nome'];
        $_SESSION['email'] = $row['user_email'];
        $_SESSION['number'] = $row['user_tel'];

        //tempo limite ate a sessao expirar
        session_set_cookie_params(3600);

        //fecha a conexao com o banco de dados
        $stmt->close();
        $mysqli->close();

        //limpa o array
        $row = [];
        $_SESSION['login_success'] = 'Login realizado com sucesso!';
    else:
        $_SESSION['login_error'] = 'Email ou senha não encontrado';
    endif;

    #Falta colocar a condição para fechar o banco, caso o contrario, ele fecha 2x.
    //$mysqli->close();
    //header('location: index.php');

endif;

//fecha a conexao com o banco de dados
$mysqli->close();
?>
<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="#" method="POST">
      <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
          <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
      Not a member?
      <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Start a 14 day free trial</a>
    </p>
  </div>
</div>
</body>
</html>