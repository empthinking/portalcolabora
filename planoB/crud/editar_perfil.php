<?php
session_start();
require_once "dbconn.php";

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

// Obtém as informações do usuário a partir do ID armazenado na sessão
$query = "SELECT * FROM usuarios WHERE user_id = $usuario_id";
$result = mysqli_query($conn, $query);

// Verifica se o usuário existe no banco de dados
if (mysqli_num_rows($result) != 1) {
    header("Location: logout.php");
    exit();
}

// Obtém as informações do usuário
$user = mysqli_fetch_assoc($result);

// Verifica se o formulário de edição foi enviado
if (isset($_POST["submit"])) {
    // Obtém as informações do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $confirma_senha = $_POST["confirma_senha"];

    // Valida os campos do formulário
    $erros = array();
    if (empty($nome)) {
        $erros[] = "O campo Nome é obrigatório.";
    }
    if (empty($email)) {
        $erros[] = "O campo Email é obrigatório.";
    }
    if (!empty($senha) && strlen($senha) < 6) {
        $erros[] = "A senha deve ter pelo menos 6 caracteres.";
    }
    if ($senha != $confirma_senha) {
        $erros[] = "As senhas não conferem.";
    }

    // Atualiza as informações do usuário no banco de dados
    if (count($erros) == 0) {
        $query = "UPDATE usuarios SET user_nome = '$nome', user_email = '$email'";
        if (!empty($senha)) {
            $query .= ", user_senha = '" . md5($senha) . "'";
        }
        $query .= " WHERE user_id = '$usuario_id'";
        $result = mysqli_query($conn, $query);

        // Verifica se a atualização foi bem-sucedida
        if ($result) {
            // Atualiza as informações do usuário na sessão
            $_SESSION["usuario_nome"] = $nome;

            // Redireciona o usuário de volta para a página de perfil
            header("Location: perfil.php");
            exit();
        } else {
            // Exibe uma mensagem de erro caso a atualização tenha falhado
            echo "<p>Erro ao atualizar informações do usuário.</p>";
        }
    } else {
        // Exibe as mensagens de erro de validação
        echo "<ul>";
        foreach ($erros as $erro) {
            echo "<li>$erro</li>";
        }
        echo "</ul>";
    }
}
?>

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
</head>
<body>
    <h1>Editar Perfil</h1>
    <form action="editar_perfil.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $user['user_nome']; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['user_email']; ?>"><br><br>
        <label for="senha">Nova senha:</label>
        <input type="password" id="senha" name="senha"><br><br>
        <label for="confirma_senha">Confirme a nova senha:</label>
        <input type="password" id="confirma_senha" name="confirma_senha"><br><br>
        <button type="submit" name="submit">Salvar Alterações</button>
    </form>
    <form action="deletar_conta.php" method="POST">
        <button type="submit" name="submit">Deletar Conta</button>
    </form>
</body>
</html>
