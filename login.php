<?php

session_start();

require_once 'dbconn.php';

$email = $password = '';
$email_err = $password_err = $login_err = '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && (!isset($_SESSION['login'] || $_SESSION['login'] !== false)){
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
/*
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		$email_err = 'Formato inválido';
	}
	
	if(strlen($password) < 8){
		$password_err = 'Senha deve conter no mínimo 8 caracteres';
	}
*/
	if(empty($email_err) && empty($password_err)){
		$stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE user_email = ?');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$id = $row['user_id'];
		$username_stored = $row['user_nome'];
		$password_stored = $row['user_senha'];
		$email_stored = $row['user_email'];
		$number_stored = $row['user_tel'];

			
		if($password == $password_stored){


			$_SESSION['login'] = true;
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $username_stored;
			$_SESSION['email'] = $email_stored;
			$_SESSION['number'] = $number_stored;
			$stmt->close();
			$result->free_result();

			header('location: index.php');
		} else {
		    $login_err = 'Nome de usuário ou senha inválidos.';
		}

	}
	
}
echo "$email_err\n$password_err\n$login_err\n" . $mysqli->error;
$mysqli->close();
?>
