<?php
session_start();

// Verifica se a sessão do admin está ativa
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    // Encerra a sessão do admin
    $_SESSION['admin'] = false;
    session_unset();
    session_destroy();
}

// Redireciona para a página de login do admin
header("Location: ../index.php");
exit();
?>
