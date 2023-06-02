<?php

function validateData(string $value) : string {
    return htmlspecialchars(trim($value));
}

function isUserLoggedIn() : bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

require_once 'constants.php';

$db = new mysqli(HOST, NAME, PASSWORD, DATABASE, PORT);

if($db->connect_error)
    exit('Falha na conexão');
