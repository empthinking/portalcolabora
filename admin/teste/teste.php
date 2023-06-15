<?php
require_once "dbconn.php";

// Verificar se a chave está presente na URL
if (isset($_GET['chave'])) {
    $chave = $_GET['chave'];

    // Verificar se a chave é válida
    if (validateChave($chave)) {
        // Buscar os dados do usuário
        $user = getUserByChave($chave);

        if ($user) {
            // Exibir os dados do usuário
            echo "<h1>Dados do Usuário</h1>";
            echo "<p><strong>Nome:</strong> " . $user['User_Name'] . "</p>";
            echo "<p><strong>Email:</strong> " . $user['User_Email'] . "</p>";
        } else {
            // Usuário não encontrado
            echo "<div class='alert alert-danger'>Usuário não encontrado.</div>";
        }
    } else {
        // Chave inválida
        echo "<div class='alert alert-danger'>Chave inválida. Acesso negado.</div>";
    }
} else {
    // Chave não fornecida
    echo "<div class='alert alert-danger'>Chave não fornecida. Acesso negado.</div>";
}

// Função para validar a chave
function validateChave($chave) {
    // Implemente a lógica de validação da chave aqui
    // Por exemplo, você pode consultar o banco de dados para verificar se a chave é válida
    // Retorne true se a chave for válida, ou false caso contrário

    // Exemplo de lógica de validação da chave:
    global $connection;

    $stmt = $connection->prepare("SELECT COUNT(*) FROM verification_codes WHERE chave = ?");
    $stmt->bind_param("s", $chave);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

// Função para buscar os dados do usuário com base na chave
function getUserByChave($chave) {
    // Implemente a lógica para buscar os dados do usuário com base na chave
    // Por exemplo, você pode consultar o banco de dados para obter os dados do usuário
    // Retorne os dados do usuário como um array associativo, ou null se o usuário não for encontrado

    // Exemplo de busca do usuário pelo User_Id (considerando que a chave é o User_Id em formato sha1):
    global $connection;

    $stmt = $connection->prepare("SELECT User_Name, User_Email FROM User WHERE SHA1(User_Id) = ?");
    $stmt->bind_param("s", $chave);
    $stmt->execute();
    $stmt->bind_result($name, $email);
    $stmt->fetch();
    $stmt->close();

    if ($name && $email) {
        return array(
            'User_Name' => $name,
            'User_Email' => $email
        );
    }

    return null;
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
        <!-- O conteúdo da página de teste -->
    </div>

    <!-- Adicione os scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
