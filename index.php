<?php
//Inicia a sessao
session_start();

//Funcoes para a exibicao de mensagens em popup
require_once 'functions/message.php'

//Checa se o formulaio de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
	require_once "login.php"; //executa login de usuario
endif;

// Cabeçalho
require_once 'header.php';

//Checa se ha algum erro e exibe um popup com a respectiva mensagem
if(isset($_SESSION['error'])):
    echo errorMsg($_SESSION['error']);
    unset($_SESSION['error']);

//Checa se ha uma mensagem de confirmacao e exibe um popup
elseif(isset($_SESSION['success'])):
    echo errorMsg($_SESSION['success']);
    unset($_SESSION['success']);
endif;

//Pagina de perfil
require_once 'perfil.php';

//Rodape
require_once 'footer.php';

?>


