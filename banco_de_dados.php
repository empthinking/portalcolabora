<?php

$servername = "127.0.0.1:3306";
$username = "u871226378_colabora";
$password = "k8qXGC1|;M";
$db = "u871226378_portalcolabora";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$conn) {
    die("Conexao falhou" . mysqli_connect_error());
}


?>
