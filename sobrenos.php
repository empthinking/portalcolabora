<?php
session_start();
require_once 'db.php';
require_once 'header.php';
require_once 'header.php';
?>
<html>

<body>
    <div style="
        background-image: url(./img/GVI-Agriculture-800x443.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        height: 70vh;">
        <fieldset class="bg-light opacity-10 p-4 mx-5 mb-5 rounded">
            <h1 class="text-center">SOBRE NÓS</h1>

            <?php   
        // Contexto sobre o Portal Colabora
        $projeto = "Portal Colabora";
        $instituicao = "UEPA";
        $intuito = "fomentar a compra e venda da pimenta-do-reino na região do Baixo Tocantins.";

        // Exibindo o contexto na página
        echo "<h3 class='fs-5 text-center mt-5'>O $projeto é um projeto desenvolvido pela $instituicao com o intuito de $intuito</h3>";
    ?>
        </fieldset>
    </div>
</body>

</html>
<?php require_once 'footer.php';?>