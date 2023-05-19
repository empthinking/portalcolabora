<?php
session_start();
require_once "funcoes.php";

// Verificar se o usuário está logado e é um administrador
if (!isUserLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
require_once "dbconn.php";

// Filtrar por ID de usuário, se fornecido na URL
$usuarioId = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : null;
$usuarioId = mysqli_real_escape_string($conn, $usuarioId);
$whereClause = $usuarioId ? "WHERE usuario_id = '$usuarioId'" : "";

// Filtrar por termo de pesquisa, se fornecido no formulário
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : "";
$pesquisa = mysqli_real_escape_string($conn, $pesquisa);
$searchClause = $pesquisa ? "AND (nome LIKE '%$pesquisa%' OR descricao LIKE '%$pesquisa%')" : "";

// Consulta para obter os produtos filtrados
$sql = "SELECT * FROM produtos $whereClause $searchClause";
$result = mysqli_query($conn, $sql);

// Array para armazenar os produtos
$produtos = [];

// Verificar se há produtos
if (mysqli_num_rows($result) > 0) {
    // Iterar sobre os resultados e armazenar os produtos no array
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }
}

// Atualizar o status "ativo" de produtos individuais
if (isset($_POST['atualizar'])) {
    foreach ($produtos as $produto) {
        $produtoId = $produto['id'];
        $ativo = isset($_POST['ativo'][$produtoId]) ? 1 : 0;
        $sql = "UPDATE produtos SET ativo = '$ativo' WHERE id = '$produtoId'";
        mysqli_query($conn, $sql);
    }
    header("Location: listar_produtos.php");
    exit();
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Listar Produtos</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-200">
        <div class="flex justify-center items-center min-h-screen">
            <div class="bg-white p-8 rounded shadow-md">
                <h2 class="text-2xl font-bold mb-4">Listar Produtos</h2>
                <form method="POST" class="mb-4">
                    <div class="flex">
                        <input type="text" name="pesquisa" placeholder="Digite o termo de pesquisa" class="w-full px-3 py-2 border border-gray-300 rounded-l focus:outline-none focus:border-blue-500">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r">Pesquisar</button>
                    </div>
                </form>
                <table class="w-full border-collapse">
                <form method="POST">
                    <button type="submit" name="atualizar" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Atualizar</button>
                    <thead>
                        <tr>
                            <th class="border-b-2 border-gray-300 py-2">Nome</th>
                            <th class="border-b-2 border-gray-300 py-2">Descrição</th>
                            <th class="border-b-2 border-gray-300 py-2">Preço</th>
                            <th class="border-b-2 border-gray-300 py-2">Imagem</th>
                            <th class="border-b-2 border-gray-300 py-2">Ativo</th>
                            <th class="border-b-2 border-gray-300 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td class="border-b border-gray-300 py-2"><?= $produto['nome'] ?></td>
                                <td class="border-b border-gray-300 py-2"><?= $produto['descricao'] ?></td>
                                <td class="border-b border-gray-300 py-2"><?= $produto['preco'] ?></td>
                                <td class="border-b border-gray-300 py-2"><img src="../<?= $produto['imagem'] ?>" alt="Imagem do produto" width="100"></td>
                                <td class="border-b border-gray-300 py-2">
                                    <input type="checkbox" name="ativo[<?= $produto['id'] ?>]" value="1" <?= $produto['ativo'] ? 'checked' : '' ?> class="rounded">
                                </td>
                                <td class="border-b border-gray-300 py-2">
                                    <a href="editar_produtos.php?id=<?= $produto['id'] ?>" class="text-blue-500 hover:text-blue-700 mr-2">Editar</a>
                                    <a href="excluir_produto.php?id=<?= $produto['id'] ?>" class="text-red-500 hover:text-red-700">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
            <br>
            <a href="#" onclick="history.back()" class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-9 rounded focus:outline-none focus:shadow-outline">
            Voltar
        </a>
         </div>
    </div>
</body>
</html>
