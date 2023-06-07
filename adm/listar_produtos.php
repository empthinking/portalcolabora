<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login_admin.php");
    exit();
}

// Verificar se o usuário possui permissão de administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: acesso_negado.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
require_once "dbconn.php";

// Excluir o produto, se o parâmetro 'delete_id' estiver presente na URL
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Excluir o produto da tabela Products
    $delete_query = "DELETE FROM Products WHERE Product_Id = $delete_id";
    mysqli_query($conn, $delete_query);

    // Redirecionar de volta para a página listar_produtos.php
    header("Location: listar_produtos.php");
    exit();
}

// Consultar a tabela Products para obter a lista de produtos
$sql = "SELECT * FROM Products";

// Pesquisar produtos, se o parâmetro 'search' estiver presente na URL
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE Product_Name LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listar Produtos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Produtos</h2>

        <form class="mb-4" method="GET">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Pesquisar por nome do produto">
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
            <a href="listar_produtos.php" class="btn btn-secondary">Limpar</a>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['Product_Id']; ?></td>
                        <td><?php echo $row['Product_Name']; ?></td>
                        <td><?php echo $row['Product_Description']; ?></td>
                        <td><?php echo $row['Product_Price']; ?></td>
                        <td><?php echo $row['Product_Date']; ?></td>
                        <td>
                            <a href="editar_produto.php?id=<?php echo $row['Product_Id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="listar_produtos.php?delete_id=<?php echo $row['Product_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza de que deseja excluir este produto?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="area_admin.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
