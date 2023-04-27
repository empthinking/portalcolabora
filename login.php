<?php
//adiciona as funcoes de login
require_once 'functions/sign_in.php';

//estabelece a conexao com o banco de dados
//objeto $mysqli
require_once 'database.php';

$email = $password = '';

//caso o usuario nao esteja logado, realiza o login e redireciona para a pagina principal
if(!isUserLoggedIn()){
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    
    sign_in($mysqli, $email, $password);
    header('location: index.php');
} else {
    throw new Exception('Nome de usuário ou senha inválidos.');
}

//fecha a conexao com o banco de dados
$mysqli->close();
?>
