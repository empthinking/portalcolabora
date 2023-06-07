<?php

function validateData(string $value) : string {
    return htmlspecialchars(trim($value));
}

function isUserLoggedIn() : bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}


$db = new mysqli('127.0.0.1', 'u871226378_admin', 'Xq*4^5^1', 'u871226378_Colabora', 3306);

if($db->connect_error)
    exit('Falha na conexão');
