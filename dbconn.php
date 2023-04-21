<?php
$servername = "127.0.0.1:3306";
$user = "u871226378_colabora"
$password = 'F7k|MYhYf>'
$db_name = "u871226378_portalcolabora"

$conn = mysqli_connect($servername, $user, $password, $db_name);

if (!$conn) {
    exit("Conexao falhou" . mysqli_connect_error());
}

?>
