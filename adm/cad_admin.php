<?php
session_start();
require_once "funcoes.php";

// Verificar se o usuário já está logado
if (isUserLoggedIn()) {
    header("Location: admin.php");
    exit();
}

// Verificar se o formulário de cadastro foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os valores do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Validar os campos obrigatórios
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        // Conexão com o banco de dados
        require_once "dbconn.php";

        // Verificar se o e-mail já está cadastrado
        $sql = "SELECT * FROM administradores WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $erro = "O e-mail fornecido já está cadastrado.";
        } else {
            // Criptografar a senha antes de armazenar no banco de dados
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir o novo administrador no banco de dados
            $sql = "INSERT INTO administradores (nome, email, senha) VALUES ('$nome', '$email', '$senhaCriptografada')";
            mysqli_query($conn, $sql);

            // Redirecionar para a página de login após o cadastro bem-sucedido
            header("Location: login_admin.php");
            exit();
        }

        // Fechar a conexão com o banco de dados
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div class="flex justify-center m-20">
    <img src="../img/logo G (2).png" alt="Descrição da imagem">
</div>
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md">
            <div class="bg-white p-8 rounded shadow-md">
                <h2 class="text-2xl font-bold mb-4">Cadastro de Administrador</h2>
                <?php if (isset($erro)): ?>
                    <p class="text-red-500"><?= $erro ?></p>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="nome" class="block font-bold">Nome:</label>
                        <input type="text" name="nome" id="nome" class="w-full border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block font-bold">E-mail:</label>
                        <input type="email" name="email" id="email" class="w-full border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="senha" class="block font-bold">Senha:</label>
                        <input type="password" name="senha" id="senha" class="w-full border-gray-300 rounded" required>
                    </div>
                    <button type="submit" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cadastrar</button>
                </form>
                <a href="#" onclick="history.back()" class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-9 rounded focus:outline-none focus:shadow-outline">
        Voltar
    </a>
            </div>
        </div>
    </div>
</body>
</html>
