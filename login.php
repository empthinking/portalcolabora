<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') header('location: index.php');

session_start();

require_once 'login_functions.php';
require_once 'dbconn.php';


$email = $password = '';

if(!isUserLoggedIn()){
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	
	userLogin($email, $password, $mysqli);
		header('location: index.php');
} else {
    throw new Exception('Nome de usuário ou senha inválidos.');
}
		

$mysqli->close();
?>
