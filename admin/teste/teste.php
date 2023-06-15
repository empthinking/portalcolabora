<?php
// Inicie a sessão
session_start();

// Verifique se a chave está presente na URL
if (isset($_GET['chave'])) {
    $chave = $_GET['chave'];

    // Verifique se a chave corresponde à chave armazenada na sessão
    if ($_SESSION['chave'] === $chave) {
        // Chave válida, permita o acesso ao conteúdo da página
        echo "Bem-vindo à página de teste!";
    } else {
        // Chave inválida, exiba uma mensagem de erro
        echo "Acesso negado. Chave inválida.";
    }
} else {
    // Chave não fornecida, redirecione para a página de verificação de código
    header("Location: index.php");
    exit();
}
?>
