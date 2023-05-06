<?php
session_start();
require_once "dbconn.php";

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

// Verifica se o formulário de confirmação de exclusão foi enviado
if (isset($_POST['confirmar'])) {
    // Deleta os produtos do usuário do banco de dados
    $query = "DELETE FROM produtos WHERE usuario_id = $usuario_id";
    $result = mysqli_query($conn, $query);

    // Deleta o usuário do banco de dados
    $query = "DELETE FROM usuarios WHERE user_id = $usuario_id";
    $result = mysqli_query($conn, $query);

    // Verifica se a exclusão foi bem-sucedida
    if ($result) {
        // Remove as informações do usuário da sessão
        session_unset();
        session_destroy();

        // Redireciona o usuário para a página inicial
        header("Location: index.php");
        exit();
    } else {
        // Exibe uma mensagem de erro caso a exclusão tenha falhado
        echo "<p>Erro ao excluir a conta do usuário.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Conta</title>
</head>
<body>
    <h1>Deletar Conta</h1>
    <p>Você tem certeza que deseja excluir sua conta? Todos os dados serão perdidos e essa ação não pode ser desfeita.</p>
    <form method="POST">
        <button type="submit" name="confirmar">Confirmar</button>
        <button type="button" onclick="location.href='perfil.php'">Cancelar</button>
    </form>
</body>
</html>
