<?php
require_once "register.php"
  ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Teste de cadastro</title>
</head>
<body>
<form>
  <label for="username">Username:</label>
  <input type="text" id="username" name="username"><br>
  <?php if(!empty($username_err)){ echo "<p> $username_err </p>";} ?>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email"><br>
  <?php if(!empty($email_err)){ echo "<p> $email_err </p>";} ?>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password"><br>
  <?php if(!empty($password_err)){ echo "<p> $password_err </p>";} ?>

  <label for="confirm-password">Confirm Password:</label>
  <input type="password" id="confirm_password" name="confirm_password"><br>

  <label for="number">Number:</label>
  <input type="number" id="number" name="number"><br>
  <?php if(!empty($number_err)){ echo "<p> $number_err </p>";} ?>

  <input type="submit" value="Submit">
</form>
</body>
</html>
