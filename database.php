<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "127.0.0.1";
$user = "u871226378_colabora";
$password = 'F7k|MYhYf>';
$db_name = "u871226378_portalcolabora";
$port = 3306;

$mysqli = new mysqli($servername, $user, $password, $db_name, $port);
#Verificação de conexão
if ($mysqli -> connect_errno) {
  echo "Falha na conexão com o banco de dados ${mysqli -> connect_error}";
  exit();
}
?>
