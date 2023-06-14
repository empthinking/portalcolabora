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

// Definir o número de usuários exibidos por página
$users_per_page = 5;

// Definir a página atual
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($current_page < 1) {
    $current_page = 1;
}

// Definir o filtro de tipo de usuário
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Definir a coluna e a ordem de classificação padrão
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'User_Id';
$sort_order = isset($_GET['sort_order']) && strtoupper($_GET['sort_order']) === 'DESC' ? 'DESC' : 'ASC';

// Construir a cláusula WHERE para o filtro de tipo de usuário
$where_clause = '';
if ($filter === 'vendedor') {
    $where_clause = "WHERE User_Type = 'vendedor'";
} elseif ($filter === 'cliente') {
    $where_clause = "WHERE User_Type = 'cliente'";
}

// Obter o total de usuários com base no filtro
$sql_count = "SELECT COUNT(*) AS total FROM Users $where_clause";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_users = $row_count['total'];

// Calcular o número total de páginas
$total_pages = ceil($total_users / $users_per_page);

// Verificar se a página atual é válida
if ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Calcular o índice de início e limite para a consulta
$start_index = ($current_page - 1) * $users_per_page;
$limit = $users_per_page;

// Construir a cláusula ORDER BY para a ordenação
$order_by_clause = "ORDER BY $sort_column $sort_order";

// Consultar a tabela Users com filtragem, ordenação e paginação
$sql = "SELECT * FROM Users $where_clause $order_by_clause LIMIT $start_index, $limit";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Gerenciar Usuários</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <form action="" method="get" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Pesquisar por nome, data ou tipo de usuário" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Pesquisar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <a href="?filter=vendedor" class="btn btn-info mr-2">Mostrar Vendedores</a>
                                    <a href="?filter=cliente" class="btn btn-info">Mostrar Clientes</a>
                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"><a href="?filter=<?php echo $filter; ?>&sort_column=User_Id&sort_order=<?php echo $sort_column === 'User_Id' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">ID</a></th>
                                    <th scope="col"><a href="?filter=<?php echo $filter; ?>&sort_column=User_Name&sort_order=<?php echo $sort_column === 'User_Name' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Nome</a></th>
                                    <th scope="col"><a href="?filter=<?php echo $filter; ?>&sort_column=User_Email&sort_order=<?php echo $sort_column === 'User_Email' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">E-mail</a></th>
                                    <th scope="col"><a href="?filter=<?php echo $filter; ?>&sort_column=User_Type&sort_order=<?php echo $sort_column === 'User_Type' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Tipo de Usuário</a></th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['User_Id']; ?></th>
                                        <td><?php echo $row['User_Name']; ?></td>
                                        <td><?php echo $row['User_Email']; ?></td>
                                        <td><?php echo $row['User_Type']; ?></td>
                                        <td>
                                            <!-- Botões de ação -->
                                            <a href="editar_usuario.php?id=<?php echo $row['User_Id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                            <a href="excluir_usuario.php?id=<?php echo $row['User_Id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php if ($total_pages > 1) : ?>
                            <nav aria-label="Navegação de página">
                                <ul class="pagination justify-content-center">
                                    <?php if ($current_page > 1) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?filter=<?php echo $filter; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>&page=<?php echo $current_page - 1; ?>">Anterior</a>
                                        </li>
                                    <?php else : ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">Anterior</span>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                        <li class="page-item <?php echo $i === $current_page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?filter=<?php echo $filter; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($current_page < $total_pages) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?filter=<?php echo $filter; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>&page=<?php echo $current_page + 1; ?>">Próxima</a>
                                        </li>
                                    <?php else : ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">Próxima</span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <a href="area_admin.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
