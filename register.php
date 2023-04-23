<?php 
	require_once "dbconn.php";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
    
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$number = $_POST["number"];
		$confirm_password = $_POST["confirm_password"];

		//regex para validar os dados
		$username_reg = "/^[a-zA-Z ]+$/";
		$number_reg = "/^[0-9]+$/";
		//Verificacao de registro do email
		$email_check->$mysqli->prepare("SELECT user_email FROM usuarios WHERE user_email = ?");
		$email_check->bind_param('s', $email);
		$email_check->execute();
		
		if(!preg_match($username_reg, $username) || empty($username)){ //Validacao do nome de usuario
			$username_err = "Preencha o campo com letras, números ou sublinhado apenas";
		} 
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){ //Validacao de email
			$email_err = "Insira um email válido";
		} elseif($email_check->num_rows > 0){
			$email_err = "Email já cadastrado"; //Verificacao de registro do email
		}
		if(!preg_match($number_reg, $number) || strlen($number) != 11){ //Validacao do telefone
			$number_err = "Insira um número válido";
		} 
		if(strlen($password) > 8){ //Validacao do tamanho da senha
			$password_err = "Senha precisa conter no mínimo 8 caracteres";
		} elseif($password !== $confirm_password){ //Confirmação da senha
			$password_err = "Insira corretamente a confirmação";
		}


		if(!isset($username_err) && !isset($email_err) && !isset($password_err) && !isset($number_err)){

			$password_secure = password_hash($password, PASSWORD_BCRYPT);
			//Preparacao de declaracao SQL 
			$stmt = $mysqli->prepare("INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES (?, ?, ?, ?)");
			//Insercao das variaveis
			$stmt->bind_param("ssss", $name, $email, $password_secure, $number);
			//Envio dos dados
			$stmt->execute();
			//Encerramento da conexao
			$stmt->close();
			$msg = "Registro completado com sucesso";

		}
}
?>

