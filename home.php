<?php
require_once "dbconn.php";

// Executa a consulta SQL para selecionar todos os produtos
$sql = "SELECT * FROM products;";
$resultado = mysqli_query($conn, $sql);

// Verifica se a consulta retornou algum resultado
if (mysqli_num_rows($resultado) > 0) {
    // Loop pelos resultados e exibe os dados
    while ($linha = mysqli_fetch_assoc($resultado)) {
        echo '<div class="bg-white rounded-lg overflow-hidden shadow-md">';
        echo '<div class="relative">';
        echo '<img src="' . $linha["imagem"] . '" alt="' . $linha["produto_nome"] . '" class="w-full h-64 object-cover">';
        echo '</div>';
        echo '<div class="p-6">';
        echo '<h3 class="text-lg font-semibold mb-2">' . $linha["produto_nome"] . '</h3>';
        echo '<p class="text-gray-700 font-medium mb-2">R$ ' . $linha["produto_preco"] . '</p>';
        echo '<p class="text-gray-700 mb-4">' . $linha["produto_descricao"] . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "Nenhum produto encontrado.";
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>
