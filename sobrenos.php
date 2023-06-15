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
        <fieldset class="p-4 mx-5 mt-5 mb-5 rounded" style="background-color: rgba(255, 255, 255, 0.5);">
            <h1 class="text-center">SOBRE NÓS</h1>

            <?php   
        // Contexto sobre o Portal Colabora
        $projeto = "Portal Colabora";
        $instituicao = "UEPA";
        $intuito = "fomentar a compra e venda da pimenta-do-reino na região do Baixo Tocantins.";
        // Exibindo o contexto na página
        echo "<h3 class='fs-5 text-center mt-5'>O projeto $projeto é um projeto de iniciação científica (PIBIC), financiado pelo edital xxx/2022, 
        desenvolvido pela $instituicao com o intuito de $intuito
        Agradecemos à Propesp/UEPA pelo incentivo e apoio.</h3>";

    ?>
        </fieldset>
        <a class="btn btn-danger" onclick="window.history.back()"><i class="fas fa-undo"></i> Voltar</a>
    </div>
</body>

</html>
<?php require_once 'footer.php';?>
