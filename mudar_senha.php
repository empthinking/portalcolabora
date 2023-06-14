<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
require_once "db.php";

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter os dados do formulário
    $currentPassword = mysqli_real_escape_string($conn, $_POST["current_password"]);
    $newPassword = mysqli_real_escape_string($conn, $_POST["new_password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

    // Verificar se a nova senha e a confirmação da senha coincidem
    if ($newPassword !== $confirmPassword) {
        $error = "A nova senha e a confirmação da senha não coincidem.";
    } else {
        // Obter o ID do usuário da sessão
        $userId = $_SESSION['user_id'];

        // Consultar a tabela Users para obter as informações do usuário
        $sql = "SELECT User_Password FROM Users WHERE User_Id = '$userId'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        // Verificar se a senha atual está correta
        if (password_verify($currentPassword, $user['User_Password'])) {
            // Gerar o hash da nova senha
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Atualizar a senha do usuário no banco de dados
            $updateSql = "UPDATE Users SET User_Password = '$newPasswordHash' WHERE User_Id = '$userId'";
            mysqli_query($conn, $updateSql);

            // Redirecionar para a página de perfil do usuário
            header("Location: perfil.php");
            exit();
        } else {
            $error = "A senha atual está incorreta.";
        }
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
                        <form method="POST">
                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>
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
