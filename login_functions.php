<?php
function isUserLoggedIn() : bool{
	return isset($_SESSION['login']) && $_SESSION['login'] === true);
}
function userLogin(string $email, string $pwd, mysqli $conn) : void {
  if(!isset($conn))
    throw new Exception('Ausencia do objeto mysqli como parametro');
  
	$stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE user_email = ?');
		$stmt->bind_param('s', $email);
		if($stmt->execute()){
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
			$result->free_result();
    } else {
      throw new Exception($conn->error);
    }

		$id = $row['user_id'];
		if(verify_password($pwd, $row['user_senha'])){
			$_SESSION['login'] = true;
			$_SESSION['id'] = $row['user_id'];
			$_SESSION['username'] = $row['user_nome'];
			$_SESSION['email'] = $row['user_email'];
			$_SESSION['number'] = $row['user_tel'];
			session_regenerate_id(true);

      $timeout = 1800; // 30 minutow
      session_set_cookie_params($timeout);
			$stmt->close();
      $$row = array();

} else {
      throw new Exception('Nome de usuario ou senha não encontrado');
    }
  $conn->close();
}
function userLogout() : void {
// unset all session variables
$_SESSION = array();
session_destroy();
header("Location: index.php");
exit;
}
?>
