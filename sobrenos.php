<?php
session_start();
require_once 'db.php';
require_once 'header.php';
require_once 'header.php';
?>
<html>
<body>
<fieldset class="bg-light opacity-60 p-4 mx-5 my-5 rounded">
    <h1 class="text-center">SOBRE NÓS</h1>

    <?php   
        // Contexto sobre o Portal Colabora
        $projeto = "Portal Colabora";
        $instituicao = "UEPA";
        $intuito = "fomentar a compra e venda da pimenta-do-reino na região do Baixo Tocantins.";

        // Exibindo o contexto na página
        echo "<p class='fs-6'>O $projeto é um projeto desenvolvido pela $instituicao com o intuito de $intuito</p>";
    ?>
</fieldset>
</body>
</html>
<?php require_once 'footer.php';?>