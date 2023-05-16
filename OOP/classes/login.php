<?php
require_once 'UserTable.php';
require_once 'User.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user = new User();
    if(!$user->setName($_POST[U_N]) || !$user->setPassword($_POST[U_P]) || !$user->setEmail($_POST[U_E]) || !$user->setNumber($_POST[U_NUM])) {
        echo $user->error;
        exit();
    }
    
    $table = new UserTable($db);
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
    <form action="registration.php" method="POST">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="{U_N}" pattern="^[a-zA-Z]+$" required placeholder="{isset($_POST[U_N]) ? $_POST[U_N] : ''}">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="{U_E}" required placeholder="{isset($_POST[U_E]) ? $_POST[U_E] : ''}">
      </div>
      <div class="form-group">
        <label for="password">Password (at least 8 characters):</label>
        <input type="password" class="form-control" id="password" name="{U_P}" pattern=".{8,}" required placeholder="{isset($_POST[U_P]) ? $_POST[U_P] : ''}">
      </div>
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" class="form-control" id="phone" name="{U_NUM}" required placeholder="{isset($_POST[U_NUM]) ? $_POST[U_NUM] : ''}">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
EOL;
