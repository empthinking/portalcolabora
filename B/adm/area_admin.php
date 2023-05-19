<?php
session_start();
require_once "funcoes.php";

// Verifica se o usuário está logado e é um administrador
if (!isUserLoggedIn() || !isAdmin()) {
    header("Location: login_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Página de Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div class="flex justify-center m-20">
    <img src="../img/logo G (2).png" alt="Descrição da imagem">
</div>
    <div class="flex justify-center items-center ">
        <div class="w-full max-w-md">
            <div class="bg-white p-8 rounded shadow-md">
                <h2 class="text-2xl font-bold mb-4">Página de Administração</h2>
                <ul class="space-y-4">
                    <li>
                        <a href="gerenciar_usuarios.php" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">usuarios</a>
                    </li>
                    <li>
                        <a href="listar_produtos.php" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Listar Produtos</a>
                    </li>
                    <li>
                        <a href="relatorios.php" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Relatórios</a>
                    </li>
                </ul>
                <a href="logout.php" class="block text-right mt-4 text-red-500 hover:text-red-700">Sair</a>
            </div>
        </div>
    </div>
</body>
</html>
