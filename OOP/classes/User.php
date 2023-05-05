<?php
require_once 'Database.php';
class User extends Database{
    private $id;
    private $username;
    private $password;
    private $email;
    private $number;
    private $db;

    public $error; 
    public $logged_in = FALSE;


    function __construct(
        Database $db = '',
        int      $id = '',
        string   $username = '',
        string   $password = '',
        string   $email = '',
        string   $number = ''
        
        ) {

        parent::__construct($db);

        if (!empty($username) && !empty($email) && !empty($password) && !empty($number)):
            if (self::isLoggedIn()):
                $this->error = 'Usuario logado';

                //Filtro dos dados adicionados

            elseif (preg_match('/^[a-zA-Z ]+$/', $name)):
                $this->error = "Nome de usuário inválido";
         
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)):
                $this->error = "Email invalido";

            elseif (!preg_match("/^[0-9]{9}/", $num)):
                $this->error = "Número em formato invalido";

            else:
                $this->username = $username;
                $this->password = $password;
                $this->email    = $email;
                $this->number   = $number;
            endif;
	endif; 

    }

    //Checa o estado de login
    static function isLoggedIn(): bool {
        return isset($_SESSION['login']) && $_SESSION['login'] === TRUE;
    }

    static function logout() : bool {
        if(!self::isLoggedIn):
            return FALSE;
        else:
            session_destroy();
            $_SESSION = [];
            return TRUE;
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

    function setName($string name): bool {
        if ($this->logged_in):
            $this->error = 'Usuario logado';
            return FALSE;

	elseif (preg_match('/^[a-zA-Z ]+$/', $name)):
            $this->error = "Nome de usuário inválido";
	    return FALSE;
	else:
            $this->username = $name;
            return TRUE;
        endif;
    }

    function setNumber(string $num): bool {
        if ($this->logged_in):
            $this->error = 'Usuario logado';
            return FALSE;
  
        elseif (!preg_match("/^[0-9]{9}/", $num)):
           $this->error = "Número em formato invalido";
           $this->error = 'Usuario logado';
           return FALSE;
	else:
	   $this->number = $num;
        endif;
    }

    function setPassword(string $pwd): bool {
        if ($this->logged_in):
            $this->error = 'Usuario logado';
            return FALSE;
	else:
	    $this->password = $pwd;
        endif;
    }

    function setEmail(string $email): bool {
        if ($this->logged_in):
            $this->error = 'Usuario logado';
            return FALSE;
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)):
            $this->error = "Email invalido";
            return false;
	else:
	    $this->email = $email;
        endif;
    }


    //Metodo para o cadastro
    function register(): bool {
	 $sql = 'INSERT INTO ' . U_TABLE . 'VALUES(?, ?, ?, ?)';
        if($this->logged_in === TRUE):
            $this->error = 'Usuario logado';
            return FALSE;

        elseif (empty($this->name) || empty($this->email) || empty($this->password) || empty($this->number)):
            $this->error = "Todos os campos devem ser preenchidos";
            return FALSE;
        elseif(!secureQuery($sql, $this->username, $this->email, $this->password, %this->number)):
            $this->error = "Erro no banco de dados -> $this->db->error";
            $stmt->close();
            return FALSE;
        endif;
    }


    function updateUserName(string $name) : bool{
       if($this->logged_in === FALSE):
	       $this->error = 'Usuario não logado';
       
       $sql = 'UPDATE ' . U_TABLE . 'SET ' . U_N . ' = ?'; 
       if

    }

    function close(): void {
        $this->db->close();
    }

    function confirmPassword(string $confirm_pwd): bool {
        return $confirm_pwd === $this->password;
    }

    function login(): bool {
        if($this->logged_in === TRUE):
            $this->error = 'Usuario logado';
            return FALSE;

        elseif (empty($email) || empty($pwd)):
            $this->error = "Todos os campos devem ser preenchidos";
            return FALSE;

        endif;
    }
}
