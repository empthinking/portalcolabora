<?php
// Verificar se a chave está presente na URL
if (isset($_GET['chave'])) {
    // Obter o valor da chave
    $chaveCodificada = $_GET['chave'];

    // Decodificar a chave
    $chaveDecodificada = base64_decode($chaveCodificada);

    // Exibir o valor da chave decodificada
    echo "Chave: " . $chaveDecodificada;
} else {
    // A chave não está presente na URL
    echo "Chave não encontrada.";
}
?>
