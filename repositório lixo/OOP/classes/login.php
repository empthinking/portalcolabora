<?php
require_once 'UserTable.php';
require_once 'User.php';

$username = $password = $email = $number = '';
$redirect = htmlspecialchars($_SERVER['PHP_SELF']);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = htmlspecialchars($_POST[U_N]);
    $password = htmlspecialchars($_POST[U_P]);
    $email    = htmlspecialchars($_POST[U_E]);
    $number   = htmlspecialchars($_POST[U_NUM]);
    $user = new User();
    
    if(!$user->setName($username) || !$user->setPassword($password) || !$user->setEmail($email) || !$user->setNumber($number)) {
        echo $user->error;
        exit();
    }
    
    $table = new UserTable($mysqli);
    if(!$table->register($user)){
        echo "Error $table->error";
        exit();
    }
    echo "Success";
    exit();
}

echo <<<EOL
<!DOCTYPE html>
<html>
<head>
  <title>User Registration Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2>User Registration Form</h2>
    <form action="$redirect" method="POST">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="{U_N}" pattern="^[a-zA-Z]+$" required placeholder="$username">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="{U_E}" required placeholder="$email">
      </div>
      <div class="form-group">
        <label for="password">Password (at least 8 characters):</label>
        <input type="password" class="form-control" id="password" name="{U_P}" pattern=".{8,}" required placeholder="$password">
      </div>
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" class="form-control" id="phone" name="{U_NUM}" required placeholder="$number">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
EOL;
