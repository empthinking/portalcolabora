<?php 
require_once "register.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Teste de cadastro</title>
</head>
<body>
 <?php if(isset($msg)){ echo "<p>$msg</p>";} else { echo "Cadastro em pendência";} ?>
<form action="teste_de_cadastro.php" method="post">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username" value="<?php if(isset($username)){ echo htmlspecialchars($username);}?>"><br>
  <?php if(isset($username_err)){ echo "<p> $username_err </p>";} ?>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="<?php if(isset($email)){ echo htmlspecialchars($email);}?>"><br>
  <?php if(isset($email_err)){ echo "<p> $email_err </p>";} ?>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" value="<?php if(isset($password)){ echo htmlspecialchars($password);}?>"><br>
  <?php if(isset($password_err)){ echo "<p> $password_err </p>";} ?>

  <label for="confirm-password">Confirm Password:</label>
  <input type="password" id="confirm_password" name="confirm_password" value="<?php if(isset($confirm_password)){ echo htmlspecialchars($confirm_password);}?>"><br>

  <label for="number">Number:</label>
  <input type="tel" id="number" name="number" value="<?php if(isset($number)){ echo htmlspecialchars($number);}?>"><br>
  <?php if(isset($number_err)){ echo "<p> $number_err </p>";} ?>

  <input type="submit" value="Submit">
  <?php 
  if(isset($msg)){
  $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE user_nome = ?");
  $stmt->execute();
  $result = $mysqli->get_result();
  $row = $result->fetch_assoc();
 
echo "
<table>
  <thead>
    <tr>
      <th>Column Name</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>";
    foreach($row as $column => $value){
      echo"
      <tr>
        <td>$column</td>
        <td>$value</td>
      </tr>";
    }
  echo "
  </tbody>
</table>
";

  }
  ?>
</form>
</body>
</html>
