<?php
//Inicia a sessao
session_start();

function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}


if(isset($_SESSION['success_msg'])):
    $msg = $_SESSION['success_msg'];
    echo '<script>alert("' . htmlspecialchars($msg) . '")</script>';
endif;

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

//Pagina de exibição dos produtos
require_once 'home.php';

// Pagina de rodapé
require_once 'footer.php';
?>
