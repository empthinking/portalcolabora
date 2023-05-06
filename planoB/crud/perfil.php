<?php
// Define um tempo de expiração de 1 hora para o cookie da sessão
$hora = 3600; // 1 hora em segundos
session_set_cookie_params($hora);

session_start();
require_once "dbconn.php";

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}


// Obtém as informações do usuário a partir do ID armazenado na sessão
$usuario_id = $_SESSION["usuario_id"];
$query = "SELECT * FROM usuarios WHERE user_id = $usuario_id";
$result = mysqli_query($conn, $query);

// Verifica se o usuário existe no banco de dados
if (mysqli_num_rows($result) != 1) {
    header("Location: logout.php");
    exit();
}

// Obtém as informações do usuário
$user = mysqli_fetch_assoc($result);

// Define as variáveis nome, email e senha com as informações do usuário
$nome = $user['user_nome'];
$email = $user['user_email'];
$senha = $user['user_senha'];

// Verifica se o formulário de edição foi enviado
if (isset($_POST["submit"])) {
    // Obtém as informações do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];

    // Atualiza as informações do usuário no banco de dados
    $query = "UPDATE usuarios SET user_nome = '$nome', user_email = '$email' WHERE user_id = $usuario_id";
    $result = mysqli_query($conn, $query);

    // Verifica se a atualização foi bem-sucedida
    if ($result) {
        // Atualiza as informações do usuário na sessão
        $_SESSION["user_name"] = $nome;

        // Redireciona o usuário de volta para a página de perfil
        header("Location: perfil.php");
        exit();
    } else {
        // Exibe uma mensagem de erro caso a atualização tenha falhado
        echo "<p>Erro ao atualizar informações do usuário.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <h1>Perfil</h1>
    <p>Nome: <?php echo $nome ?></p>
    <p>Email: <?php echo $email ?></p>
    <p>Senha: <?php echo $senha ?></p>
    <p>
        <button type="button" onclick="location.href='editar_perfil.php'">Editar perfil</button>
        <a href="meus_produtos.php">Meus produtos</a>
        
        <form action="logout.php" method="post">
            <input type="submit" name="logout" value="Sair">
        </form>
    </p>
</body>
</html>
