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

// Definir o número de usuários a serem exibidos por página
$users_per_page = 5;

// Obter o número total de usuários
$count_query = "SELECT COUNT(*) AS total FROM Users";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_users = $count_row['total'];

// Calcular o número total de páginas
$total_pages = ceil($total_users / $users_per_page);

// Obter o número da página atual
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Validar o número da página atual
if ($current_page < 1 || $current_page > $total_pages) {
    $current_page = 1;
}

// Calcular o deslocamento para a consulta SQL
$offset = ($current_page - 1) * $users_per_page;

// Consultar a tabela Users com filtro e paginação
$sql = "SELECT * FROM Users";

// Filtro por tipo de usuário (vendedor ou cliente)
$filter = isset($_GET['filter']) ? $_GET['filter'] : "";
if ($filter === "vendedor") {
    $sql .= " WHERE User_Type = 'vendedor'";
} elseif ($filter === "cliente") {
    $sql .= " WHERE User_Type = 'cliente'";
}

// Ordenação dos usuários
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : "User_Name";
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : "ASC";
$sql .= " ORDER BY $sort_column $sort_order";

// Limitar o número de resultados por página
$sql .= " LIMIT $offset, $users_per_page";

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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form method="GET">
                                    <div class="form-group">
                                        <label for="filter">Filtro:</label>
                                        <select class="form-control" id="filter" name="filter">
                                            <option value="">Todos</option>
                                            <option value="vendedor" <?php if ($filter === "vendedor") echo "selected"; ?>>Vendedores</option>
                                            <option value="cliente" <?php if ($filter === "cliente") echo "selected"; ?>>Clientes</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="search">Pesquisar:</label>
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Pesquisar por nome ou e-mail">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                                    <a href="gerenciar_usuarios.php" class="btn btn-secondary">Limpar</a>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <a href="?filter=<?php echo $filter; ?>&sort_column=User_Name&sort_order=ASC" class="btn btn-link">Ordenar por Nome (ASC)</a>
                                    <a href="?filter=<?php echo $filter; ?>&sort_column=User_Name&sort_order=DESC" class="btn btn-link">Ordenar por Nome (DESC)</a>
                                    <a href="?filter=<?php echo $filter; ?>&sort_column=User_Email&sort_order=ASC" class="btn btn-link">Ordenar por E-mail (ASC)</a>
                                    <a href="?filter=<?php echo $filter; ?>&sort_column=User_Email&sort_order=DESC" class="btn btn-link">Ordenar por E-mail (DESC)</a>
                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Tipo</th>
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
                            <nav aria-label="Navegação de páginas">
                                <ul class="pagination">
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
                                        <?php if ($i == $current_page) : ?>
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link"><?php echo $i; ?></span>
                                            </li>
                                        <?php else : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?filter=<?php echo $filter; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endif; ?>
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
