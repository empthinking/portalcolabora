<?php
session_start();
require_once 'header.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sobre Nós</title>
</head>
<body>
    <h1>Sobre Nós</h1>

    <?php
        // Contexto sobre o Portal Colabora
        $projeto = "Portal Colabora";
        $instituicao = "UEPA";
        $intuito = "fomentar a compra e venda da pimenta-do-reino na região do Baixo Tocantins.";

        // Exibindo o contexto na página
        echo "<p>O $projeto é um projeto desenvolvido pela $instituicao com o intuito de $intuito</p>";
    ?>

</body>
</html>
