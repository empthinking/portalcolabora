<?php

//Constantes do banco de dados
define('HOST'    , '127.0.0.1');
define('NAME'    , 'u871226378_colabora');
define('PASSWORD', 'F7k|MYhYf>');
define('DATABASE', 'u871226378_portalcolabora');

//Constantes para a tabela de usuarios
define('U_TABLE', 'usuarios');
define('U_ID'   , 'user_id');
define('U_N'    , 'user_nome');
define('U_E'    , 'user_email');
define('U_P'    , 'user_senha');
define('U_BD'   , 'User_BirthDay');
define('U_CPF'  , 'User_CPF');
define('U_NUM'  , 'user_tel');

//Constantes para a tabela de produtos
define('P_TABLE'  , 'Products');
define('P_ID'     , 'Product_Id');
define('P_N'      , 'Product_Name');
define('P_C'      , 'Product_Category');
define('P_A'      , 'Product_Amount');

$mysqli = new mysqli(HOST, NAME, PASSWORD, DATABASE);

if($mysqli->connect_error)
    exit('Falha na conexão');

class Table {

    protected $table_name;
    protected $db;
    public  $error;

    function __construct(mysqli $db, string $table_name){
        $this->db = $db;
        $this->table_name = $table_name;
    }    

    // Realiza uma query preparada
    protected function secureSqlQuery(string $sql_prep, array $bindings, bool $return = FALSE, bool $mult_row = FALSE) : bool | array {
        if(!$stmt = $this->db->prepare($sql_prep)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        if(!$stmt->execute($bindings)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        if($return){
            $result = $stmt->get_result();
            $stmt->close();
            $row = $mult_result ? $result->fetch_all(MYSQLI_BOTH) : $result->fetch_assoc();
            $result->close();
            return $row;
	}

        return TRUE;
    }


    function __destruct(){
        $this->db->close();
    }

} 

$username = $password = $email = $number = '';
$redirect = htmlspecialchars($_SERVER['PHP_SELF']);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = htmlspecialchars($_POST[U_N]);
    $password = htmlspecialchars($_POST[U_P]);
    $email    = htmlspecialchars($_POST[U_E]);
    $number   = htmlspecialchars($_POST[U_NUM]);
    $user = new User();
    
    if(!$user->setName($username) || !$user->setPassword($password) || !$user->setEmail($email) || !$user->setNumber($number)) {
        echo $user->error;
        exit();
    }
    
    $table = new UserTable($mysqli);
    if(!$table->register($user)){
        echo "Error $table->error";
        exit();
    }
    echo "Success";
    exit();
}

echo <<<EOL
<!DOCTYPE html>
<html>
<head>
  <title>User Registration Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2>User Registration Form</h2>
    <form action="{html_special_chars(" method="POST">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="{U_N}" pattern="^[a-zA-Z]+$" required placeholder="$username">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="{U_E}" required placeholder="$email">
      </div>
      <div class="form-group">
        <label for="password">Password (at least 8 characters):</label>
        <input type="password" class="form-control" id="password" name="{U_P}" pattern=".{8,}" required placeholder="$password">
      </div>
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" class="form-control" id="phone" name="{U_NUM}" required placeholder="$number">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
EOL;
