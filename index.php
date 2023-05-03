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
if(isset($_SESSION['login_success']) && !isset($_SESSION['login_success_displayed'])):
    echo '<script>alert("' . htmlspecialchars('Login realizado com sucesso!') . '")</script>';
    $_SESSION['login_success_displayed'] = true;
    unset($_SESSION['login_success']);
else:
    echo '<script>alert("' . htmlspecialchars('Login') . '")</script>';
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