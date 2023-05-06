<?php
session_start();
require_once "dbconn.php"; // inclua aqui o arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Verifica se o e-mail já está cadastrado
    $sql = "SELECT * FROM usuarios WHERE user_email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION["msg"] = "Este e-mail já está cadastrado!";
        header("Location: cadastro.php");
        exit();
    }

    // Insere os dados na tabela de usuários
    $sql = "INSERT INTO usuarios (user_nome, user_email, user_senha) VALUES ('$nome', '$email', '$senha')";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0) {
        echo "<p style='color:green'>Cadastro realizado com sucesso!</p>";
    } else {
        echo "<p style='color:red'>Erro ao realizar o cadastro. Tente novamente mais tarde.</p>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h1>Cadastro de Usuário</h1>

    <?php if (isset($_SESSION["msg"])): ?>
        <p><?= $_SESSION["msg"] ?></p>
        <?php unset($_SESSION["msg"]) ?>
    <?php endif ?>

    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
