<?php
$servername = "127.0.0.1";
$user = "u871226378_colabora";
$password = 'F7k|MYhYf>';
$db_name = "u871226378_portalcolabora";
$port = 3306;

$conn = mysqli_connect($servername, $user, $password, $db_name, $port);
#Verificação de conexão
if (!$conn) {
  echo "Falha na conexão com o banco de dados";
  exit("Connection failed: " . mysqli_connect_error());
}
?>
