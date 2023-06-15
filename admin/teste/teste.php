<?php
session_start();

// Verifica se a chave está presente na URL
if (isset($_GET['chave'])) {
    // Obtém a chave da URL
    $chave = $_GET['chave'];

    // Exibe a chave
    echo "Chave: " . $chave . "<br>";

    // Verifica se a variável de sessão existe
    if (isset($_SESSION['session_token'])) {
        // Obtém o token de sessão da variável de sessão
        $sessionToken = $_SESSION['session_token'];

        // Exibe o token de sessão
        echo "Token de Sessão: " . $sessionToken . "<br>";
    } else {
        // A variável de sessão não existe
        echo "Token de Sessão não encontrado.";
    }
} else {
    // A chave não está presente na URL
    echo "Chave não encontrada na URL.";
}
?>
