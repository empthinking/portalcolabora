<?php
class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private $number;

    public $error; 
    public $logged_in;


    function __construct() {
        $this->$logged_in = self::isLoggedIn();
    }

    static function isLoggedIn(): bool {
        return isset($_SESSION['login']) && $_SESSION['login'] === TRUE;
    }

    function getName(): string {
        return $this->username;
    }

    function getNum(): string {
        return $this->number;
    }

    function getEmail(): string {
        return $this->email;
    }

    function getPassword(): string {
        return $this->password;
    }

    function setUsername($string name): bool {
        if ($this->logged_in) {
            $this->error = 'Usuario logado';
            return FALSE;
	    }

        if (!preg_match('/^[a-zA-Z]+$/', $name)) {
            $this->error = "Nome de usuário inválido";
            return FALSE;
	    }

        $this->username = $name;
        return TRUE;
    }

    function setNumber(string $num): bool {
        if ($this->logged_in) {
            $this->error = 'Usuario logado';
            return FALSE;
        }
  
        if (!preg_match("/^[0-9]{9}/", $num)) {
            $this->error = "Número em formato invalido";
            return FALSE;
	    }

        $this->number = $num;
	    return TRUE;	
    }

    function setPassword(string $password): bool {
        if ($this->logged_in) {
            $this->error = 'Usuario logado';
            return FALSE;
	    }

        if (strlen($password < 8)) {
            $this->error = 'Senha possui menos que 8 caracteres';
            return FALSE;
        }

        $this->password = $password;
        return TRUE;
    }

    function setEmail(string $email): bool {
        if ($this->logged_in) {
            $this->error = 'Usuario logado';
            return FALSE;
        }

	    if (!validateEmail($email)) {
            $this->error = "Email invalido";
            return FALSE;
        }

        $this->email = $email;
	    return TRUE;
    }

    protected validateEmail(mixed $email) : bool {
	   return filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    static function logout() : bool {
        if(!$logged_in) {
            $this->error = 'Usuario não está logado';
            return FALSE;
        }

        session_destroy();
        $_SESSION = [];
        return TRUE;
    }
}
