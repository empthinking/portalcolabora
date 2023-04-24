<?php
declare(strict_types=1);
class User {
	public $username;
	public $password;
	public $email;
	public $number;

	function __construct(string $name, string $pwd, string $email, string $num){
		if(empty($name) || empty($email) || empty($pwd) || empty($num))
			throw new Exception('Todos os campos devem ser preenchidos');

		if(!preg_match('/^[a-zA-Z _]+$/', $name))
			throw new Exception('Nome deve conter apenas letras, números ou sublinhado apenas');

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			throw new Exception('Email inválido');

		if(strlen($pwd) < 8 )
			throw new Exception('Senha deve conter 8 ou mais caracteres');

		if(!preg_match('/^[0-9]+$/', $num))
			throw new Exception('Número Inválido');

		$this->username = htmlspecialchars(trim($name));
		$this->password = htmlspecialchars($pwd);
		$this->email    = htmlspecialchars(trim($email));
		$this->number   = htmlspecialchars(trim($num));

	}
	function get_name() : string {
			return $this->username; 
	}
	function get_num() : string {
			return $this->number;
	}
	function get_email() : string {
			return $this->email;
	}
	function get_password() : string {
			return $this->password;
	}
	function get_password_hash() : string {
			return password_hash($this->password, PASSWORD_DEFAULT);
	}

}

$servername = '127.0.0.1';
$user = 'u871226378_colabora';
$password = 'F7k|MYhYf>';
$db_name = 'u871226378_portalcolabora';
$port = 3306;

$mysqli = new mysqli($servername, $user, $password, $db_name, $port);
#Verificação de conexão
if ($mysqli -> connect_errno) {
  echo "Falha na conexão com o banco de dados ${mysqli->connect_error}";
  exit();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
	try{
		$user = new User($_POST["username"], $_POST["password"], $_POST["email"], $_POST["number"]);
		$confirm_password = htmlspecialchars($_POST["confirm_password"]);


		//Verificacao de registro do email
		if($email_check = $mysqli->prepare("SELECT user_email FROM usuarios WHERE user_email = ?")){;
			$email_check->bind_param('s', $user->get_email());
			$email_check->execute();
		} else {
			throw new Exception("Erro de checagem de email");
		}
		if($user->get_password() != $confirm_password){ //Confirmação da senha
			$error_msg = "Insira corretamente a confirmação";
			throw new Exception("Erro de confirmação de senha");

		} elseif($stmt = $mysqli->prepare("INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES (?, ?, ?, ?)")){
			//Insercao das variaveis
			$stmt->bind_param("ssss", $user->username, $user->email, $user->password, $user->number);
			//Envio dos dados
			$stmt->execute();
			//Encerramento da conexao
			$stmt->close();
			$mysqli->close();														     
																	     
			$msg = "Registro completado com sucesso";

		} else {
			throw new Exception ("Erro de insercao no banco de dados.");
		}
	} catch(Exception $error) {
	echo $error->getMessage();
	} 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Teste de cadastro</title>
  <style>
	/* Global styles */
body {
  background-color: #E6F5E7; /* light green background */
  color: #333; /* dark text color */
  font-family: Arial, sans-serif; /* default font */
}

/* Header styles */
header {
  background-color: #5DB75D; /* dark green header background */
  color: #fff; /* light text color */
  padding: 20px; /* add some padding for spacing */
}

h1 {
  margin: 0; /* remove default margin */
  font-size: 32px; /* large font size */
}

/* Form styles */
form {
  background-color: #fff; /* white form background */
  border-radius: 10px; /* rounded corners */
  padding: 20px; /* add some padding for spacing */
  margin: 20px auto; /* center the form */
  max-width: 500px; /* limit the width of the form */
  box-shadow: 0 0 10px rgba(0,0,0,0.2); /* add a subtle shadow */
}

label {
  display: block; /* make each label a block element */
  margin-bottom: 10px; /* add some spacing between labels */
  font-size: 18px; /* large font size for labels */
  font-weight: bold; /* bold label text */
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"] {
  display: block; /* make each input field a block element */
  width: 100%; /* set the width to fill the container */
  padding: 10px; /* add some padding for spacing */
  font-size: 16px; /* default font size */
  border-radius: 5px; /* rounded corners */
  border: none; /* remove the default border */
  box-shadow: 0 0 5px rgba(0,0,0,0.2); /* add a subtle shadow */
  margin-bottom: 20px; /* add some spacing between input fields */
}

input[type="submit"] {
  background-color: #5DB75D; /* dark green submit button background */
  color: #fff; /* light text color */
  padding: 10px 20px; /* add some padding for spacing */
  border: none; /* remove the default border */
  border-radius: 5px; /* rounded corners */
  font-size: 18px; /* large font size */
  cursor: pointer; /* add a pointer cursor */
}

input[type="submit"]:hover {
  background-color: #3C883C; /* hover color for submit button */
}
</style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username" value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']);?>"><br>
 

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']);?>"><br>
  

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" value="<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password']);?>"><br>
  

  <label for="confirm-password">Confirm Password:</label value="<?php if(isset($_POST['confirm_password'])) echo htmlspecialchars($_POST['confirm_password']);?>">
  <input type="password" id="confirm_password" name="confirm_password"><br>

  <label for="number">Number:</label>
  <input type="tel" id="number" name="number" value="<?php if(isset($_POST['number'])) echo htmlspecialchars($_POST['number']);?>"><br>

  <input type="submit" value="Submit">
</form>
</body>
</html>
