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
require_once "db.php";

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
$limit = 10; // Número de produtos por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página atual
$start = ($page - 1) * $limit; // Registro inicial para a consulta

$sql = "SELECT Products.*, Users.User_Name 
        FROM Products 
        INNER JOIN Users ON Products.User_Id = Users.User_Id 
        ORDER BY Product_Id DESC 
        LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);

// Consultar o total de produtos na tabela Products
$count_query = "SELECT COUNT(*) AS total FROM Products";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_products = $count_row['total'];

// Calcular o número total de páginas
$total_pages = ceil($total_products / $limit);
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

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Data</th>
                    <th>Nome do Usuário</th>
                    <th>Ações</th>
                    <th>Selecionar</th>
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
                        <td><?php echo $row['User_Name']; ?></td>
                        <td>
                            <a href="editar_produto.php?id=<?php echo $row['Product_Id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="listar_produtos.php?delete_id=<?php echo $row['Product_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza de que deseja excluir este produto?')">Excluir</a>
                        </td>
                        <td>
                            <input type="checkbox" name="selected_products[]" value="<?php echo $row['Product_Id']; ?>">
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botão "Mostrar Mais" -->
        <?php if ($page < $total_pages) : ?>
            <button class="btn btn-primary mb-4" onclick="window.location.href='listar_produtos.php?page=<?php echo $page + 1; ?>'">Mostrar Mais</button>
        <?php endif; ?>

        <!-- Botão de Excluir Produtos Selecionados -->
        <form action="excluir_selecionados.php" method="POST">
            <div class="form-group">
                <label for="selected-products">Produtos Selecionados:</label>
                <select class="form-control" name="selected_products[]" id="selected-products" multiple>
                    <?php mysqli_data_seek($result, 0); // Reiniciar o ponteiro do resultado ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <option value="<?php echo $row['Product_Id']; ?>"><?php echo $row['Product_Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Excluir Selecionados</button>
        </form>

        <a href="area_admin.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
