<?php

//função para verificar se o usuário está logado.
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

//Inicia a sessao
session_start();

//alerta de cadastro realizado
if(isset($_SESSION['success_msg'])):
    $msg = $_SESSION['success_msg'];
    echo '<script>alert("' . htmlspecialchars($msg) . '")</script>';
    unset($_SESSION['success_msg']);
endif;

//alerta de login
if(isset($_SESSION['login_success'])):
    echo '<script>alert("' . htmlspecialchars('Login realizado com sucesso!') . '")</script>';
else:
    echo '<script>alert("' . htmlspecialchars($_SESSION['login_error']) . '")</script>';    
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

//Pagina de perfil
require_once 'home.php';

//Rodape
require_once 'footer.php';
?>