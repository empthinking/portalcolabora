<?php
require_once "dbconn.php";

// Faz a requisição ao banco de dados para obter as informações do produto
$sql = "SELECT imagem, nome, descricao, preco FROM produtos";
$result = $conn->query($sql);

// Verifica se existem registros retornados
if ($result->num_rows > 0) {
  // Loop através dos registros e exibe as informações
  while ($row = $result->fetch_assoc()) {
    $imagem = $row["imagem"];
    $nome = $row["nome"];
    $descricao = $row["descricao"];
    $preco = $row["preco"];

    // Exibe as informações do produto
    echo "<div>";
    echo "<img src='$imagem' alt='Imagem do Produto'>";
    echo "<h2>$nome</h2>";
    echo "<p>$descricao</p>";
    echo "<p>Preço: R$ $preco</p>";
    echo "</div>";
  }
} else {
  echo "Nenhum produto encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
