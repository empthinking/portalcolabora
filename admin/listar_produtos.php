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

// Definir o número de produtos exibidos por página
$products_per_page = 10;

// Obter o número total de produtos
$total_products_query = "SELECT COUNT(*) AS total FROM Products";
$total_products_result = mysqli_query($conn, $total_products_query);
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total'];

// Calcular o número total de páginas
$total_pages = ceil($total_products / $products_per_page);

// Obter o número da página atual
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = max(1, min($page, $total_pages));

// Calcular o índice do primeiro produto a ser exibido
$offset = ($page - 1) * $products_per_page;

// Definir a coluna de ordenação padrão
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'Product_Id';

// Definir a ordem de ordenação padrão
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Consultar a tabela Products para obter a lista de produtos com paginação e ordenação
$sql = "SELECT p.*, u.User_Name 
        FROM Products p 
        INNER JOIN Users u ON p.User_Id = u.User_Id 
        ORDER BY $sort_column $sort_order 
        LIMIT $offset, $products_per_page";

// Pesquisar produtos, se o parâmetro 'search' estiver presente na URL
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT p.*, u.User_Name 
            FROM Products p 
            INNER JOIN Users u ON p.User_Id = u.User_Id 
            WHERE p.Product_Name LIKE '%$search%' 
            OR p.Product_Date LIKE '%$search%' 
            OR u.User_Name LIKE '%$search%' 
            ORDER BY $sort_column $sort_order 
            LIMIT $offset, $products_per_page";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listar Produtos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Produtos</h2>

        <form class="mb-4" method="GET">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Pesquisar por nome, data ou usuário">
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
                <div class="form-group col-md-2">
                    <a href="listar_produtos.php" class="btn btn-secondary"><i class="fas fa-times"></i> Limpar</a>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID <a href="listar_produtos.php?page=<?php echo $page; ?>&sort_column=Product_Id&sort_order=<?php echo $sort_column === 'Product_Id' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>"><i class="fas fa-sort"></i></a></th>
                    <th>Nome <a href="listar_produtos.php?page=<?php echo $page; ?>&sort_column=Product_Name&sort_order=<?php echo $sort_column === 'Product_Name' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>"><i class="fas fa-sort"></i></a></th>
                    <th>Descrição</th>
                    <th>Preço <a href="listar_produtos.php?page=<?php echo $page; ?>&sort_column=Product_Price&sort_order=<?php echo $sort_column === 'Product_Price' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>"><i class="fas fa-sort"></i></a></th>
                    <th>Data <a href="listar_produtos.php?page=<?php echo $page; ?>&sort_column=Product_Date&sort_order=<?php echo $sort_column === 'Product_Date' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>"><i class="fas fa-sort"></i></a></th>
                    <th>Usuário</th>
                    <th>Ações</th>
                    <th><input type="checkbox" id="select-all-checkbox"></th>
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
                            <input type="checkbox" class="select-checkbox" data-product-id="<?php echo $row['Product_Id']; ?>">
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item <?php echo $page === 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="listar_produtos.php?page=<?php echo $page - 1; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                        <a class="page-link" href="listar_produtos.php?page=<?php echo $i; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page === $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="listar_produtos.php?page=<?php echo $page + 1; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>">Próxima</a>
                </li>
            </ul>
        </nav>

        <div class="mt-3">
            <button class="btn btn-danger" id="delete-selected-btn"><i class="fas fa-trash"></i> Excluir Selecionados</button>
        </div>

        <a href="area_admin.php" class="btn btn-secondary">Voltar</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Selecionar/Deselecionar todos os checkboxes
        $('#select-all-checkbox').change(function () {
            $('.select-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Excluir produtos selecionados
        $('#delete-selected-btn').click(function () {
            var selectedProducts = [];

            $('.select-checkbox:checked').each(function () {
                selectedProducts.push($(this).data('product-id'));
            });

            if (selectedProducts.length > 0) {
                var confirmDelete = confirm('Tem certeza de que deseja excluir os produtos selecionados?');

                if (confirmDelete) {
                    var deleteUrl = 'excluir_produtos_selecionados.php?product_ids=' + selectedProducts.join(',');

                    window.location.href = deleteUrl;
                }
            }
        });
    </script>
</body>
</html>
