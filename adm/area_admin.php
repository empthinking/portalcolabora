<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de Administração</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Página de Administração</h2>
                        <ul class="list-unstyled">
                            <li>
                                <a href="gerenciar_usuarios.php" class="btn btn-primary btn-block mb-3">Usuários</a>
                            </li>
                            <li>
                                <a href="listar_produtos.php" class="btn btn-primary btn-block mb-3">Listar Produtos</a>
                            </li>
                            <li>
                                <a href="relatorios.php" class="btn btn-primary btn-block mb-3">Relatórios</a>
                            </li>
                        </ul>
                        <a href="logout.php" class="d-block text-right mt-4 text-danger">Sair</a>
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
