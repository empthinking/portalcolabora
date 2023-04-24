<?php

session_start();

require_once 'dbconn.php';

$username = $password = '';
$username_err = $password_err = $login_err = '';

$username_reg = '/^[a-zA-Z ]+$/';

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['loggedin'] != true){
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if(empty(trim($username)) || !preg_match($username_reg, $username)){
		$username_err = 'Insira o nome de usuário válido.';

	} elseif($mysqli->num_rows("SELECT user_id FROM usuarios WHERE user_nome = '$username'") > 0) {
		$username_err = 'Nome já registrado';
	}	
	
	if(strlen($password) < 8){
		$password_err = 'Senha deve conter no mínimo 8 caracteres';
	}

	if(empty($username_err) && empty($password_err)){
		$stmt = $mysqli->prepare('SELECT user_id, user_nome, user_senha FROM usuarios WHERE user_nome = ?');
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if($result->num_rows === 1){
			$id = $row['user_id'];
			$username_stored = $row['user_nome'];
			$password_stored = $row['user_senha'];
			
			if(password_verify($password, $password_stored)){
				session_start();

				$_SESSION['loggedin'] = true;
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;

				header('location: ' . htmlspecialchars($_SERVER['PHP_SELF']));
                        } else {
                            $login_err = 'Nome de usuário ou senha inválidos.';
                        }

		}
		$stmt->close();
		$result->free_result();
	}	
}
$mysqli->close();
?>
