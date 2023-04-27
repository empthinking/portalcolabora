<?php
require_once 'message_functions.php'

//Inicia a sessao
session_start();

//Checa se o formulaio de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
	require_once "login.php"; //executa login de usuario
endif;

// Cabeçalho
require_once 'header.php';

//Checa por erros e exibe um popup com a respectiva mensagem
if(isset($_SESSION['error'])):
    echo errorMsg($_SESSION['error']);
    unset($_SESSION['error']);
endif;

//Pagina de perfil
require_once 'perfil.php';

//Rodape
require_once 'footer.php';

?>


