<?php

session_start();
require_once 'login_functions.php';
require_once 'dbconn.php';


$email = $password = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && (!isUserLoggedIn()){
	$email = trim($_POST['email']);
	$password = $_POST['password'];
/*
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		$email_err = 'Formato inválido';
	}
	
	if(strlen($password) < 8){
		$password_err = 'Senha deve conter no mínimo 8 caracteres';
	}
*/
			userLogin($email, $password, $mysqli);
			header('location: index.php');
		} else {
		    throw new Exception('Nome de usuário ou senha inválidos.');
		}

	}
	
}
$mysqli->close();
?>
