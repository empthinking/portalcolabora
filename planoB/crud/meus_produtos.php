<?php
session_start();
require_once "dbconn.php";

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

// Seleciona todos os produtos cadastrados pelo usuário logado
$query = "SELECT * FROM produtos WHERE usuario_id = '$usuario_id'";
$result = mysqli_query($conn, $query);

// Verifica se o usuário possui produtos cadastrados
if (mysqli_num_rows($result) == 0) {
    echo "<h1>Meus Produtos</h1>";
    echo "<p>Você ainda não cadastrou nenhum produto.</p>";
    echo "<p><button type='button' onclick=\"location.href='adicionar_produto.php'\">Adicionar Produto</button></p>";
} else {
    // Exibe a lista de produtos cadastrados
    echo "<h1>Meus Produtos</h1>";
    echo "<table>";
    echo "<tr><th>Nome</th><th>Descrição</th><th>Preço</th><th>Imagem</th><th>Opções</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['descricao'] . "</td>";
        echo "<td>" . $row['preco'] . "</td>";
        if (!empty($row['imagem'])) {
            echo "<td><img src='" . $row['imagem'] . "' width='100'></td>";
        } else {
            echo "<td>N/A</td>";
        }
        echo "<td><a href='editar_produto.php?id=" . $row['id'] . "'>Editar</a> | <a href='excluir_produto.php?id=" . $row['id'] . "' onclick=\"return confirm('Tem certeza que deseja excluir esse produto?')\">Excluir</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p><button type='button' onclick=\"location.href='adicionar_produto.php'\">Adicionar Produto</button></p>";
}

mysqli_close($conn);
?>
