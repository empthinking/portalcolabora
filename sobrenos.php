<?php require_once 'header.php';?>
<html>
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
<?php require_once 'footer.php';?>