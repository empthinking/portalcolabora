<?php
session_start();

// Verificar se o usuário está logado
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: area_admin.php");
    exit();
} else {
    header("Location: login_admin.php");
    exit();
}
