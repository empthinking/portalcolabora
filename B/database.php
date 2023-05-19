<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$user = "root";
$password = '';
$db_name = "crud";
$port = 3306;

$mysqli = new mysqli($servername, $user, $password, $db_name, $port);
#Verificação de conexão
if ($mysqli -> connect_error) {
  echo "Falha na conexão com o banco de dados $mysqli -> connect_error";
  exit();
}
?>