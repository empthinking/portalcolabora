<?php

$serverName = "127.0.0.1";
$dBUsername = "u871226378_admin";
$dBPassword = "Xq*4^5^1";
$dBName = "u871226378_Colabora";

$connection = new mysqli($serverName, $dBUsername, $dBPassword, $dBName, 3306);

if ($connection->connect_error) {
    die("Falha na conexão com o banco de dados: " . $connection->connect_error);
}
