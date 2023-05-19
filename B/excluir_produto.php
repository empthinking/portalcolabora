<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

require_once "dbconn.php";

// Verifica se o id do produto foi enviado por GET
if (!isset($_GET['id'])) {
    header("Location: perfil.php");
    exit();
}

// Obtém o id do produto
$id = $_GET['id'];

// Verifica se o produto pertence ao usuário logado
$result = mysqli_query($conn, "SELECT * FROM produtos WHERE id = $id AND usuario_id = {$_SESSION['id']}");
if (mysqli_num_rows($result) == 0) {
    header("Location: perfil.php");
    exit();
}

// Exclui o produto do banco de dados
mysqli_query($conn, "DELETE FROM produtos WHERE id = $id");

mysqli_close($conn);

// Redireciona para a página de Meus Produtos com uma mensagem de sucesso
header("Location: perfil.php?msg=Produto excluído com sucesso!");
exit();
?>
