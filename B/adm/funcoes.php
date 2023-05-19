<?php
// Função para verificar se o usuário está logado
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Função para verificar se o usuário é um administrador
function isAdmin(): bool {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}


?>
