<?php

define('SERVER', 'localhost');
define('USUARIO', 'u871226378_colabora');
define('SENHA', 'k8qXGC1|;M');
define('DATABASE', 'u871226378_portalcolabora');
$conn = mysqli_connect(SERVER, USUARIO, SENHA, DATABASE);

if (!$conn) {
    exit("Conexao falhou" . mysqli_connect_error());
}

?>
