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

    // Verificar se o filtro é válido (comprador ou vendedor)
    if ($filter !== "comprador" && $filter !== "vendedor") {
        $filter = "";
    }
}

// Definir a consulta SQL base
$sql = "SELECT * FROM Users";

// Adicionar o filtro à consulta SQL
if ($filter === "comprador") {
    $sql .= " WHERE User_Type = 'comprador'";
} elseif ($filter === "vendedor") {
    $sql .= " WHERE User_Type = 'vendedor'";
}

// Ordenação padrão (por ID ascendente)
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'User_Id';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
$sql .= " ORDER BY $sort_column $sort_order";

// Consultar a tabela Users para obter a lista de usuários
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
                                            <option value="comprador" <?php if ($filter === "comprador") echo "selected"; ?>>Compradores</option>
                                            <option value="vendedor" <?php if ($filter === "vendedor") echo "selected"; ?>>Vendedores</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <label for="search">Pesquisar:</label>
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Nome, E-mail, etc." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                                </form>
                            </div>
                            <div>
                                <a href="gerenciar_usuarios.php" class="btn btn-secondary mr-2">Limpar</a>
                                <a href="gerenciar_usuarios.php?sort_column=<?php echo $sort_column; ?>&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>" class="btn btn-primary">Ordenar</a>
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
