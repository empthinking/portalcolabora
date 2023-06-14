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

// Verificar se foi enviado um filtro por parâmetro
$filter = "";
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    // Verificar se o filtro é válido (vendedor ou cliente)
    if ($filter !== "vendedor" && $filter !== "cliente") {
        $filter = "";
    }
}

// Definir a consulta SQL base
$sql = "SELECT COUNT(*) AS total FROM Users";

// Adicionar o filtro à consulta SQL
if ($filter === "vendedor") {
    $sql .= " WHERE User_Type = 'vendedor'";
} elseif ($filter === "cliente") {
    $sql .= " WHERE User_Type = 'cliente'";
}

// Obter o total de usuários
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_users = $row['total'];

// Definir a quantidade de usuários por página
$users_per_page = 5;

// Calcular o número total de páginas
$total_pages = ceil($total_users / $users_per_page);

// Obter o número da página atual
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Verificar se o número da página é válido
if ($current_page < 1 || $current_page > $total_pages) {
    $current_page = 1;
}

// Calcular o offset para a consulta SQL
$offset = ($current_page - 1) * $users_per_page;

// Consultar a tabela Users para obter a lista de usuários
$sql = "SELECT * FROM Users";

// Adicionar o filtro e a limitação à consulta SQL
if ($filter === "vendedor") {
    $sql .= " WHERE User_Type = 'vendedor'";
} elseif ($filter === "cliente") {
    $sql .= " WHERE User_Type = 'cliente'";
}
$sql .= " ORDER BY $sort_column $sort_order LIMIT $offset, $users_per_page";
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
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <form class="form-inline">
                                    <div class="form-group mr-2">
                                        <label for="filter">Filtro:</label>
                                        <select class="form-control" id="filter" name="filter">
                                            <option value="">Todos</option>
                                            <option value="vendedor" <?php if ($filter === "vendedor") echo "selected"; ?>>Vendedores</option>
                                            <option value="cliente" <?php if ($filter === "cliente") echo "selected"; ?>>Clientes</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </form>
                            </div>
                            <div>
                                <a href="area_admin.php" class="btn btn-secondary">Voltar</a>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col"><a href="?sort_column=User_Name&sort_order=<?php echo $sort_column === 'User_Name' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Nome</a></th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col"><a href="?sort_column=User_Type&sort_order=<?php echo $sort_column === 'User_Type' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Tipo</a></th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['User_Id']; ?></th>
                                        <td><?php echo $row['User_Name']; ?></td>
                                        <td><?php echo $row['User_Email']; ?></td>
                                        <td><?php echo $row['User_Type'] === 'vendedor' ? 'Vendedor' : 'Cliente'; ?></td>
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
                                <ul class="pagination">
                                    <?php if ($current_page > 1) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?filter=<?php echo $filter; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>&page=<?php echo $current_page - 1; ?>">Previous</a>
                                        </li>
                                    <?php else : ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
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
                                            <a class="page-link" href="?filter=<?php echo $filter; ?>&sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order; ?>&page=<?php echo $current_page + 1; ?>">Next</a>
                                        </li>
                                    <?php else : ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
