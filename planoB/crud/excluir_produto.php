<?php
require_once "dbconn.php";

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Verifica se foi recebido o parâmetro 'id'
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $usuario_id = $_SESSION["usuario_id"];

    // Verifica se o produto pertence ao usuário logado
    $query = "SELECT * FROM produtos WHERE id = $id AND usuario_id = $usuario_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Executa a consulta SQL para excluir o produto
        $sql = "DELETE FROM produtos WHERE id = $id AND usuario_id = $usuario_id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado) {
            echo "Produto excluído com sucesso!";
        } else {
            echo "Erro ao excluir o produto: " . mysqli_error($conn);
        }
    } else {
        echo "Você não tem permissão para excluir este produto.";
    }
} else {
    echo "ID do produto não informado.";
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>
