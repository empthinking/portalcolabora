<?php
session_start();
require_once "funcoes.php";

// Verificar se o usuário está logado e é um administrador
if (!isUserLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
}

// Verificar se o ID do usuário foi fornecido na URL
if (!isset($_GET['id'])) {
    header("Location: gerenciar_usuarios.php");
    exit();
}

// Conexão com o banco de dados
require_once "dbconn.php";

// Obter o ID do usuário da URL
$usuario_id = $_GET['id'];

// Consulta para obter os dados do usuário pelo ID
$sql = "SELECT * FROM usuarios WHERE user_id = '$usuario_id'";
$result = mysqli_query($conn, $sql);

// Verificar se o usuário existe no banco de dados
if (mysqli_num_rows($result) !== 1) {
    header("Location: gerenciar_usuarios.php");
    exit();
}

// Obter os dados do usuário
$usuario = mysqli_fetch_assoc($result);

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter os novos valores do usuário
    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = mysqli_real_escape_string($conn, $_POST["senha"]);

    // Atualizar os dados do usuário no banco de dados
    $sql = "UPDATE usuarios SET user_nome = '$nome', user_email = '$email', user_senha = '$senha' WHERE user_id = '$usuario_id'";
    mysqli_query($conn, $sql);

    // Redirecionar de volta para a página de gerenciar usuários
    header("Location: gerenciar_usuarios.php");
    exit();
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div class="flex justify-center m-20">
    <img src="../img/logo G (2).png" alt="Descrição da imagem">
</div>
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Editar Usuário</h2>
            <form method="POST">
                <div class="mb-4">
                    <label for="nome" class="block text-gray-700 font-bold mb-2">Nome:</label>
                    <input type="text" id="nome" name="nome" required value="<?= $usuario['user_nome'] ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">E-mail:</label>
                    <input type="email" id="email" name="email" required value="<?= $usuario['user_email'] ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="senha" class="block text-gray-700 font-bold mb-2">Senha:</label>
                    <input type="password" id="senha" name="senha" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar</button>
                <a href="gerenciar_usuarios.php" class="block mt-4 text-blue-500 hover:text-blue-700">Cancelar</a>
            </form>
            <br>
            <a href="#" onclick="history.back()" class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-9 rounded focus:outline-none focus:shadow-outline">
            Voltar
        </a>
        </div>
    </div>
</body>
</html>
