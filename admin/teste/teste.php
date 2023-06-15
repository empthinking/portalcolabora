<?php
session_start();

// Verificar se o token de sessão está presente e válido
if (!isset($_SESSION['session_token']) || empty($_SESSION['session_token'])) {
    // Token de sessão inválido ou ausente, redirecionar de volta para a página de verificação
    header("Location: index.php");
    exit();
}

// Obter o token de sessão atual
$sessionToken = $_SESSION['session_token'];

// Verificar se a página foi acessada após fechar a janela do navegador
if (!isset($_COOKIE['session_token']) || $_COOKIE['session_token'] !== $sessionToken) {
    // Token de sessão inválido ou ausente, redirecionar de volta para a página de verificação
    header("Location: index.php");
    exit();
}

// Definir um novo cookie para atualizar a expiração do token de sessão
setcookie('session_token', $sessionToken, time() + 60);

// Verificar se a chave está presente na URL
if (isset($_GET['chave'])) {
    // Obter a chave da URL
    $chave = $_GET['chave'];

    // Pesquisar no banco de dados usando a chave
    $stmt = $connection->prepare("SELECT User_Id, User_Email FROM Users WHERE SHA1(CONCAT(User_Email, User_Id)) = ?");
    $stmt->bind_param("s", $chave);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se a chave é válida
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Extrair o ID e o email do resultado da consulta
        $id = $row['User_Id'];
        $email = $row['User_Email'];

        // Exibir o ID e o email
        echo "ID: " . $id . "<br>";
        echo "Email: " . $email . "<br>";
    } else {
        // Chave inválida
        echo "Chave inválida";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de Teste</title>
    <!-- Adicione os links para os arquivos CSS do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Página de Teste</h1>
        <p>Conteúdo da página de teste.</p>
    </div>

    <!-- Adicione os scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
