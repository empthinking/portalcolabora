<?php
define('SERVER', 'localhost');
define('USUARIO', 'u871226378_colabora');
define('SENHA', 'k8qXGC1|;M');
define('DATABASE', 'u871226378_portalcolabora');

try{
    $pdo = new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE, USUARIO, SENHA);
    // Defina o modo de erro PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Não foi possível conectar." . $e->getMessage());
}
?>
