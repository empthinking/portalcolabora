<?php

require_once 'db.php';

session_start();

if(isUserLoggedIn()) header('Location: index.php');

$password = $email = $error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email     = validateData($_POST['email']);
    $password  = htmlspecialchars($_POST['password']);

    $getUserByEmail = function() use ($email, $db) : false | array {
        $stmt = $db->prepare("SELECT * FROM Users WHERE User_Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    };
        
    if(!($user = $getUserByEmail()) || !password_verify($password, $user[U_P])) {
        $error = 'Email ou Senha não encontrados';

    } else {
        $_SESSION['login']     = true;
        $_SESSION['username']  = $user[U_N];
        $_SESSION['id']        = $user[U_ID];
        
        header('Location: index.php');
    }

}

$url = htmlspecialchars(trim($_SERVER['PHP_SELF']));

echo  <<<FORM
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .bg-header {
      background-color: rgb(99, 242, 83);
    }
    body {
          min-height: 100vh;
          display: flex;
          flex-direction: column;
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4">Login</h2>
        <h4 class="text-danger">$error</h4>
        <form action="login.php" method="POST">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="$email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" id="password" name="password" value="$password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <a href="index.php" class="btn btn-link mt-3">Voltar</a>
      </div>
    </div>
  </div>
FORM;

$db->close();

require_once 'footer.php';
