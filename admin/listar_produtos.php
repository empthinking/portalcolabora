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

// Definir o número de produtos a serem exibidos por página
$per_page = 10;

// Definir a página atual
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calcular o offset para a consulta SQL
$offset = ($page - 1) * $per_page;

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

// Ordenar produtos, se o parâmetro 'order_by' estiver presente na URL
if (isset($_GET['order_by'])) {
    $order_by = $_GET['order_by'];
    $sql .= " ORDER BY $order_by";
}

// Definir a ordem de classificação padrão
$order = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
$sql .= " $order";

// Consultar o número total de produtos
$total_products = mysqli_num_rows(mysqli_query($conn, $sql));

// Calcular o número total de páginas
$total_pages = ceil($total_products / $per_page);

// Atualizar a consulta SQL com o limite e offset
$sql .= " LIMIT $per_page OFFSET $offset";

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
                    <th><a href="listar_produtos.php?order_by=Product_Id&order=<?php echo ($order === 'ASC' && $order_by === 'Product_Id') ? 'DESC' : 'ASC'; ?>">ID</a></th>
                    <th><a href="listar_produtos.php?order_by=Product_Name&order=<?php echo ($order === 'ASC' && $order_by === 'Product_Name') ? 'DESC' : 'ASC'; ?>">Nome</a></th>
                    <th><a href="listar_produtos.php?order_by=Product_Description&order=<?php echo ($order === 'ASC' && $order_by === 'Product_Description') ? 'DESC' : 'ASC'; ?>">Descrição</a></th>
                    <th><a href="listar_produtos.php?order_by=Product_Price&order=<?php echo ($order === 'ASC' && $order_by === 'Product_Price') ? 'DESC' : 'ASC'; ?>">Preço</a></th>
                    <th><a href="listar_produtos.php?order_by=Product_Date&order=<?php echo ($order === 'ASC' && $order_by === 'Product_Date') ? 'DESC' : 'ASC'; ?>">Data</a></th>
                    <th><a href="listar_produtos.php?order_by=Product_Author&order=<?php echo ($order === 'ASC' && $order_by === 'Product_Author') ? 'DESC' : 'ASC'; ?>">Autor</a></th>
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
                        <td><?php echo $row['Product_Author']; ?></td>
                        <td>
                            <a href="editar_produto.php?id=<?php echo $row['Product_Id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="listar_produtos.php?delete_id=<?php echo $row['Product_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza de que deseja excluir este produto?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <div>
                <p>Página <?php echo $page; ?> de <?php echo $total_pages; ?></p>
                <p>Total de Produtos: <?php echo $total_products; ?></p>
            </div>
            <div>
                <?php if ($page < $total_pages): ?>
                    <a href="listar_produtos.php?page=<?php echo $page + 1; ?>" class="btn btn-primary">Mostrar Mais</a>
                <?php endif; ?>
            </div>
        </div>
        
        <form method="POST" action="apagar_selecionados.php" class="mb-4">
            <div class="form-group">
                <label for="selected_products">Produtos Selecionados:</label>
                <select name="selected_products[]" id="selected_products" multiple class="form-control">
                    <?php mysqli_data_seek($result, 0); ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <option value="<?php echo $row['Product_Id']; ?>"><?php echo $row['Product_Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Apagar Selecionados</button>
        </form>
        
        <a href="area_admin.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
