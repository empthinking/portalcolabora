<?php
session_start();

// Verifica se a sessão do admin está ativa
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redireciona para a página de login do admin
    header("Location: login_admin.php");
    exit();
}

// Aqui você pode adicionar a lógica para gerar os relatórios desejados

?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatórios</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div class="flex justify-center m-20">
        <img src="../img/logo G (2).png" alt="Descrição da imagem">
    </div>
    <div class="flex justify-center items-center">
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Relatórios</h2>
            <!-- Adicione aqui a estrutura HTML para exibir os relatórios -->
        </div>
    </div>
    <div class="flex justify-center mt-4">
        <a href="logout.php" class="block text-red-500 hover:text-red-700">Sair</a>
    </div>
</body>
</html>
