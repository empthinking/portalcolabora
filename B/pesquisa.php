<?php

function conectar() {
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "crud";
    $conn = mysqli_connect($host, $user, $password, $db);
    if (!$conn) {
        die("Erro na conexão: " . mysqli_connect_error());
    }
    return $conn;
}

function obter_lista_produtos($conn, $search = null) {
    $query = "SELECT p.*, u.user_nome as nome_usuario FROM produtos p JOIN usuarios u ON p.usuario_id = u.user_id";
    if (!empty($search)) {
        $query .= " WHERE p.nome LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
    }
    $result = mysqli_query($conn, $query);
    if (!$result) {
        throw new Exception("Erro na consulta: " . mysqli_error($conn));
    }
    $produtos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }
    mysqli_free_result($result);
    return $produtos;
}

function exibir_lista_produtos($produtos) {
    foreach ($produtos as $produto) {
        echo "<div class='flex items-center py-4'>";
        echo "<div class='w-1/4'>";
        echo "<img class='max-w-full h-auto' src='" . $produto['imagem'] . "' alt='" . $produto['nome'] . "'>";
        echo "</div>";
        echo "<div class='w-1/2 pl-4'>";
        echo "<a href='produto.php?id=" . $produto['id'] . "'><h2 class='font-bold text-lg'>" . $produto['nome'] . "</h2></a>";
        echo "<p class='text-gray-700'>" . $produto['descricao'] . "</p>";
        echo "</div>";
        echo "<div class='w-1/4 text-right pr-4'>";
        echo "<p class='text-gray-700 font-bold'>" . number_format($produto['preco'], 2, ',', '.') . " R$</p>";
        echo "</div>";
        echo "</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = conectar();
    $search = $_POST['search'] ?? null;
    $produtos = obter_lista_produtos($conn, $search);
    mysqli_close($conn);
} else {
    $produtos = array();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesquisa de Produtos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.16/tailwind.min.css">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-8">
        <form class="flex items-center" method="post">
            <input class="rounded-l-full w-full px-6 py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="search" name="search" type="text" placeholder="Pesquisar...">
            <button class="bg-blue-500 hover:bg-blue-700 rounded-r-full text-white font-bold py-4 px-8 focus:outline-none focus:shadow-outline" type="submit">
                Buscar
            </button>
 
        </form>

        <?php if (!empty($search) && empty($produtos)): ?>
            <p class="mt-4 text-gray-700">Nenhum produto encontrado.</p>
        <?php elseif (!empty($produtos)): ?>
            <div class="mt-4">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Imagem</th>
                            <th class="px-4 py-2">Nome</th>
                            <th class="px-4 py-2">Usuário</th>
                            <th class="px-4 py-2">Descrição</th>
                            <th class="px-4 py-2">Preço</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td class="border px-4 py-2">
                                    <?php if (!empty($produto['imagem'])): ?>
                                        <img class="w-20 h-20 object-cover rounded" src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                                    <?php endif ?>
                                </td>
                                <td class="border px-4 py-2"><a class="hover:underline" href="exibir_produto.php?id=<?= $produto['id'] ?>"><?= $produto['nome'] ?></a></td>
                                <td class="border px-4 py-2"><?= $produto['nome_usuario'] ?></td>
                                <td class="border px-4 py-2"><?= $produto['descricao'] ?></td>
                                <td class="border px-4 py-2"><?= $produto['preco'] ?></td>
                                <td class="border px-4 py-2"><a class="bg-blue-500 hover:bg-blue-700 rounded-full text-white font-bold py-2 px-4" href="produto.php?id=<?= $produto['id'] ?>">Ir para o produto</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

        <?php endif ?>
    </div>

</body>
</html>
