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

// Definir a quantidade de produtos por página
$limit = 10;

// Definir a página atual
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Definir o deslocamento para a consulta
$start = ($page - 1) * $limit;

// Definir o campo de ordenação padrão e a direção de ordenação padrão
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'Product_Id';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Consultar a tabela Products para obter a lista de produtos com ordenação e limite
$sql = "SELECT Products.*, Users.User_Name 
        FROM Products 
        INNER JOIN Users ON Products.User_Id = Users.User_Id 
        ORDER BY $sort_column $sort_order 
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
                    <th>
                        <a href="listar_produtos.php?sort_column=Product_Id&sort_order=<?php echo $sort_column === 'Product_Id' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">
                            ID
                            <?php if ($sort_column === 'Product_Id') : ?>
                                <?php if ($sort_order === 'ASC') : ?>
                                    <i class="fas fa-sort-up"></i>
                                <?php else : ?>
                                    <i class="fas fa-sort-down"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="listar_produtos.php?sort_column=Product_Name&sort_order=<?php echo $sort_column === 'Product_Name' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">
                            Nome
                            <?php if ($sort_column === 'Product_Name') : ?>
                                <?php if ($sort_order === 'ASC') : ?>
                                    <i class="fas fa-sort-up"></i>
                                <?php else : ?>
                                    <i class="fas fa-sort-down"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="listar_produtos.php?sort_column=Product_Description&sort_order=<?php echo $sort_column === 'Product_Description' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">
                            Descrição
                            <?php if ($sort_column === 'Product_Description') : ?>
                                <?php if ($sort_order === 'ASC') : ?>
                                    <i class="fas fa-sort-up"></i>
                                <?php else : ?>
                                    <i class="fas fa-sort-down"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="listar_produtos.php?sort_column=Product_Price&sort_order=<?php echo $sort_column === 'Product_Price' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">
                            Preço
                            <?php if ($sort_column === 'Product_Price') : ?>
                                <?php if ($sort_order === 'ASC') : ?>
                                    <i class="fas fa-sort-up"></i>
                                <?php else : ?>
                                    <i class="fas fa-sort-down"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="listar_produtos.php?sort_column=Product_Date&sort_order=<?php echo $sort_column === 'Product_Date' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">
                            Data
                            <?php if ($sort_column === 'Product_Date') : ?>
                                <?php if ($sort_order === 'ASC') : ?>
                                    <i class="fas fa-sort-up"></i>
                                <?php else : ?>
                                    <i class="fas fa-sort-down"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Publicado por</th>
                    <th>Ações</th>
                    <th>
                        <input type="checkbox" id="select-all-checkbox">
                    </th>
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
                    <li class="page-item <?php echo $page === $i ? 'active' : ''; ?>">
                        <a class="page-link" href="listar_produtos.php?page=<?php echo $i; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page === $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="listar_produtos.php?page=<?php echo $page + 1; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>">Próxima</a>
                </li>
            </ul>
        </nav>

        <button type="button" class="btn btn-danger" id="delete-selected-button">Excluir selecionados</button>

        <a href="area_admin.php" class="btn btn-secondary">Voltar</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        // Selecionar todos os checkboxes
        $("#select-all-checkbox").change(function() {
            $(".select-checkbox").prop("checked", $(this).prop("checked"));
        });

        // Excluir produtos selecionados
        $("#delete-selected-button").click(function() {
            var selectedProductIds = [];

            $(".select-checkbox:checked").each(function() {
                selectedProductIds.push($(this).data("product-id"));
            });

            if (selectedProductIds.length > 0) {
                if (confirm("Tem certeza de que deseja excluir os produtos selecionados?")) {
                    var url = "delete_selected_products.php?product_ids=" + selectedProductIds.join(",");
                    window.location.href = url;
                }
            } else {
                alert("Nenhum produto selecionado.");
            }
        });
    </script>
</body>
</html>
