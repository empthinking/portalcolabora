<?php
session_start();
require_once "dbconn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = mysqli_real_escape_string($conn, $_POST["senha"]);

    // Consultar o banco de dados para verificar se as credenciais são válidas
    $sql = "SELECT * FROM administradores WHERE email = '$email' AND senha = '$senha'";
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
        header("Location: login_admin.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Login do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div class="flex justify-center m-20">
    <img src="../img/logo G (2).png" alt="Descrição da imagem">
</div>
    <div class="flex justify-center items-center">
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Login do Administrador</h2>
            <form method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">E-mail:</label>
                    <input type="text" id="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="senha" class="block text-gray-700 font-bold mb-2">Senha:</label>
                    <input type="password" id="senha" name="senha" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
