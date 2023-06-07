<?php
session_start();
require_once "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $senha = mysqli_real_escape_string($conn, $_POST["senha"]);

    // Consultar o banco de dados para verificar se as credenciais são válidas
    $sql = "SELECT * FROM admin WHERE name = '$name' AND senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        // As credenciais estão corretas, iniciar sessão do administrador
        $_SESSION['login'] = true;
        $_SESSION["admin"] = true;
        header("Location: area_admin.php");
        // Definir o tempo limite da sessão
        ini_set("session.cookie_lifetime", 3600);
        exit();
    } else {
        // Credenciais inválidas, redirecionar para a página de login com mensagem de erro
        $_SESSION['login_error'] = 'Email ou senha inválidos';
        header("Location: ../index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login do Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login do Administrador</h2>
                        <form method="POST">
                            <div class="form-group">
                                <label for="name">E-mail:</label>
                                <input type="name" id="name" name="name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" id="senha" name="senha" required class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
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
