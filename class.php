<?php
declare(strict_types=1);
class User {
	private $username;
	private $password;
	private $email;
	private $number;

	function __construct(string $name, string $pwd, string $email, string $num){
		if(empty($name) || empty($email) || empty($pwd) || empty($num))
			throw new Exception('Todos os campos devem ser preenchidos');

		if(!preg_match('/^[a-zA-Z ]+$/', $name))
			throw new Exception('Nome deve conter apenas letras, números ou sublinhado apenas');

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)
			thow new Exception('Email inválido');

		if(strlen($password) < 8 )
			throw new Exception('Senha deve conter 8 ou mais caracteres');

		if(!preg_match('/^[0-9]+$/', $num){
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
?>
