<?php
	require_once "dbconn.php";

	$username = $password = $number = $confirm_password = $number = "";
	$username_err = $email_err = $password_err = $number_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
    
		$name = $_POST["username"]));
		$email = $_POST["email"]));
		$password = $_POST["password"]);
		$number = $_POST["number"];
		$confirm_password = $_POST["confirm_password"];

		//regex para validar os dados
		$username_reg = "/^[a-zA-Z ]+$/";
		$number_reg = "/^[0-9]+$/";

		if(!preg_match($username_reg, $username) || empty($username)){ //Validacao do nome de usuario
			$username_err = "Preencha o campo com letras, números ou sublinhado apenas";
		} 
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){ //Validacao de email
			$email_err = "Insira um email válido";
		} elseif($mysqli->num_rows("SELECT user_email FROM usuarios WHERE user_email = '$email'") > 0){
			$email_err = "Email já cadastrado"; //Verificacao de registro do email
		}
		if(!preg_match($number_reg, $number) || strlen($number) != 11){ //Validacao do telefone
			$number_err = "Insira um número válido";
		} 
		if(strlen($password) > 8){ //Validacao do tamanho da senha
			$password_err = "Senha precisa conter no mínimo 8 caracteres";
		} elseif($passsword !== $confirm_password){ //Confirmação da senha
			$password_err = "Insira corretamente a confirmação";
		}


		if(empty($username_err) && empty($email_err) && empty($password_err) && empty($number_err)){

			$password_secure = password_hash($pass, PASSWORD_BCRYPT);
			//Preparacao de declaracao SQL 
			$stmt = $mysqli->prepare("INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES (?, ?, ?, ?)");
			//Insercao das variaveis
			$stmt->bind_param("ssss", $name, $email, $password_secure, $number);
			//Envio dos dados
			$stmt->execute();
			//Encerramento da conexao
			$stmt->close();

			//Redirecionamento para a home page
			header("location: index.php");

		}
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Teste de cadastro</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
