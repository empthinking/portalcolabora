<?php
session_start();
require_once "dbconn.php";

// Verificar se o administrador está logado
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: login_admin.php");
    exit();
}

// Consultar os usuários no banco de dados
$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql);
$usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Função para filtrar os usuários com base na pesquisa
function filtrarUsuarios($usuarios, $pesquisa) {
    $usuariosFiltrados = [];
    foreach ($usuarios as $usuario) {
        if (stripos($usuario['user_nome'], $pesquisa) !== false || stripos($usuario['user_email'], $pesquisa) !== false) {
            $usuariosFiltrados[] = $usuario;
        }
    }
    return $usuariosFiltrados;
}

// Verificar se o formulário de pesquisa foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pesquisa"])) {
    $pesquisa = mysqli_real_escape_string($conn, $_POST["pesquisa"]);
    $usuarios = filtrarUsuarios($usuarios, $pesquisa);
}

// Atualizar permissão do usuário
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["atualizar_permissao"])) {
    $user_id = $_POST["user_id"];
    $permissao = $_POST["permissao"];

    $sql = "UPDATE usuarios SET permissao_publicar = $permissao WHERE user_id = $user_id";
    if (mysqli_query($conn, $sql)) {
        echo "Permissão atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a permissão: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Gerenciar Usuários</h2>
            <form method="POST">
                <div class="mb-4">
                    <label for="pesquisa" class="block text-gray-700 font-bold mb-2">Pesquisar:</label>
                    <input type="text" id="pesquisa" name="pesquisa"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        value="<?php echo isset($pesquisa) ? $pesquisa : ''; ?>">
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
            </form>
            <table class="w-full border-collapse mt-4">
                <thead>
                    <tr>
                        <th class="border-b-2 border-gray-300 py-2">Nome</th>
                        <th class="border-b-2 border-gray-300 py-2">E-mail</th>
                        <th class="border-b-2 border-gray-300 py-2">Ações</th>
                        <th class="border-b-2 border-gray-300 py-2">Produtos</th>
                        <th class="border-b-2 border-gray-300 py-2">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td class="border-b border-gray-300 py-2"><?php echo $usuario['user_nome']; ?></td>
                            <td class="border-b border-gray-300 py-2"><?php echo $usuario['user_email']; ?></td>
                            <td class="border-b border-gray-300 py-2">
                                <a href="editar_usuario.php?id=<?php echo $usuario['user_id']; ?>" class="text-blue-500 hover:text-blue-700 mr-2">Editar</a>
                                <a href="excluir_usuario.php?id=<?php echo $usuario['user_id']; ?>" class="text-red-500 hover:text-red-700">Excluir</a>
                            </td>
                            <td class="border-b border-gray-300 py-2">
                                <a href="listar_produtos.php?user_id=<?php echo $usuario['user_id']; ?>" class="text-green-500 hover:text-green-700">Listar Produtos</a>
                            </td>
                            <td class="border-b border-gray-300 py-2">
                                <form method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $usuario['user_id']; ?>">
                                    <select name="permissao" class="px-2 py-1 border border-gray-300 rounded">
                                        <option value="0" <?php echo $usuario['permissao_publicar'] == 0 ? 'selected' : ''; ?>>Sim</option>
                                        <option value="1" <?php echo $usuario['permissao_publicar'] == 1 ? 'selected' : ''; ?>>Não</option>
                                    </select>
                                    <button type="submit" name="atualizar_permissao" class="bg-green-400 hover:bg-green-600 text-white font-bold py-1 px-2 rounded ml-2">Atualizar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <a href="#" onclick="history.back()" class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-9 rounded focus:outline-none focus:shadow-outline">
            Voltar
        </a>
        </div>
    </div>
</body>
</html>
