<?php
define('HOST'    , 'localhost');
define('NAME'    , 'u871226378_colabora');
define('PASSWORD', 'F7k|MYhYf>');
define('DATABASE', 'u871226378_Colabora');
define('PORT'    , 3306);

function validateData(string $value) : string {
    return htmlspecialchars(trim($value));
}

function isUserLoggedIn() : bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

$db = new mysqli(HOST, NAME, PASSWORD, DATABASE, PORT);

if($db->connect_error)
    exit('Falha na conexão');
