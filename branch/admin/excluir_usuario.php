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

// Verificar se o parâmetro de ID do usuário está presente na URL
if (!isset($_GET['id'])) {
    header("Location: gerenciar_usuarios.php");
    exit();
}

// Obter o ID do usuário da URL
$user_id = $_GET['id'];

// Consultar a tabela Users para obter as informações do usuário
$sql = "SELECT * FROM Users WHERE User_Id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Verificar se o usuário existe
if (!$user) {
    header("Location: gerenciar_usuarios.php");
    exit();
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Excluir o usuário do banco de dados
    $delete_sql = "DELETE FROM Users WHERE User_Id = '$user_id'";
    mysqli_query($conn, $delete_sql);

    // Redirecionar de volta para a página de gerenciamento de usuários
    header("Location: gerenciar_usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Excluir Usuário</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Excluir Usuário</h2>
                        <p>Tem certeza de que deseja excluir o usuário "<?php echo $user['User_Name']; ?>"?</p>
                        <form method="POST">
                            <button type="submit" class="btn btn-danger">Excluir</button>
                            <a href="gerenciar_usuarios.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
excluir_usuario.php
