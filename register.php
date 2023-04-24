<?php 
	#require_once "class.php";
	require_once "dbconn.php";
	$error_msg = "";

	if($_SERVER["REQUEST_METHOD"] === "POST"){
		try{
			$user = new User($_POST["username"], $_POST["password"], $_POST["email"], $_POST["number"]);
			$confirm_password = htmlspecialchars($_POST["confirm_password"]);
		} catch(Exception $error) {
			$error_msg = $error->getMessage();
		}

		//Verificacao de registro do email
		$email_check = $mysqli->prepare("SELECT user_email FROM usuarios WHERE user_email = ?");
		$email_check->bind_param('s', $user->get_email());
		$email_check->execute();

		if($user->get_password() !== $confirm_password) //Confirmação da senha
			$error_msg = "Insira corretamente a confirmação";

		$stmt = $mysqli->prepare("INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES (?, ?, ?, ?)");
		//Insercao das variaveis
		$stmt->bind_param("ssss", $name, $email, $password_secure, $number);
		//Envio dos dados
		$stmt->execute();
		//Encerramento da conexao
		$stmt->close();
		$msg = "Registro completado com sucesso";

	}

?>

