<?php
require_once "register.php"
  ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>My Website</title>
</head>
<body>
<form>
  <label for="username">Username:</label>
  <input type="text" id="username" name="username"><br>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email"><br>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password"><br>

  <label for="confirm-password">Confirm Password:</label>
  <input type="password" id="confirm_password" name="confirm_password"><br>

  <label for="number">Number:</label>
  <input type="number" id="number" name="number"><br>

  <input type="submit" value="Submit">
</form>
</body>
</html>
