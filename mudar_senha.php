<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
require_once "db.php";

// Obter o ID do usuário da sessão
$user_id = $_SESSION['user_id'];

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter os dados do formulário
    $current_password = mysqli_real_escape_string($conn, $_POST["current_password"]);
    $new_password = mysqli_real_escape_string($conn, $_POST["new_password"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

    // Consultar a tabela Users para obter a senha atual do usuário
    $sql = "SELECT User_Password FROM Users WHERE User_Id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // Verificar se a senha atual fornecida pelo usuário corresponde à senha armazenada no banco de dados
    if (password_verify($current_password, $user['User_Password'])) {
        // Verificar se a nova senha e a confirmação da senha são iguais
        if ($new_password === $confirm_password) {
            // Gerar o hash da nova senha
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Atualizar a senha do usuário no banco de dados
            $update_sql = "UPDATE Users SET User_Password = '$hashed_password' WHERE User_Id = '$user_id'";
            mysqli_query($conn, $update_sql);

            // Redirecionar para uma página de sucesso ou exibir uma mensagem de sucesso
            header("Location: senha_atualizada.php");
            exit();
        } else {
            $error_message = "A nova senha e a confirmação de senha não correspondem.";
        }
    } else {
        $error_message = "A senha atual está incorreta.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mudar Senha</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Mudar Senha</h2>
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="current_password">Senha Atual:</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Nova Senha:</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirmar Nova Senha:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
