<?php

function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

//Inicia a sessao
session_start();
/*
//Exibe um alerta quando o usuário se cadastra;
	//alerta de erro.
if (isset($_SESSION['error_msg'])) {
    echo '<script>alert("' . htmlspecialchars($_SESSION['error_msg']) . '")</script>';
    unset($_SESSION['error_msg']);
}
	// alerta de cadastro realizado com sucesso 
if (isset($_SESSION['success_msg'])) {
    echo '<script>alert("' . htmlspecialchars($_SESSION['success_msg']) . '")</script>';
    unset($_SESSION['success_msg']);
}
*/

//Checa se o formulaio de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
	require_once "login.php"; //executa login de usuario
endif;

// Cabeçalho
if(isUserLoggedIn()):
	require_once 'header_loggedin.php';
else:
	require_once 'header.php';
endif;

//Pagina de perfil
require_once 'home.php';

//Rodape
require_once 'footer.php';

?>


