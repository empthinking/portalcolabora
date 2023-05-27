<?php
// Inicia a sessão
session_start();

// Remove todas as variáveis da sessão
session_unset();

// Destroi a sessão atual
session_destroy();

// Remove os cookies da sessão no navegador
setcookie(session_name(), '', time() - 3600);

// Redireciona para a página inicial
header('location: index.php');

// Finaliza o script para evitar a execução de mais código
exit;

?>
