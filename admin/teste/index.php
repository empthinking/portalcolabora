<?php
require_once "dbconn.php";

// Verificar se o formulário foi submetido para validar o código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    $verificationCode = $_POST['verification_code'];

    // Validar o código de verificação
    if (validateVerificationCode($verificationCode)) {
        // Redirecionar para a página de teste com a chave na URL
        header("Location: teste.php?code=" . urlencode($verificationCode));
        exit();
    } else {
        // Código inválido, exibir mensagem de erro
        echo '<div class="alert alert-danger">Código de verificação inválido. Acesso negado.</div>';
    }
}

// Função para validar o código de verificação
function validateVerificationCode($code) {
    global $connection;

    $stmt = $connection->prepare("SELECT COUNT(*) FROM verification_codes WHERE code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

// Função para descriptografar a chave e obter o ID e o e-mail do usuário
function decryptChave($chave) {
    $decodedChave = base64_decode($chave);
    $chaveParts = explode('_', $decodedChave);

    $id = $chaveParts[0];
    $email = $chaveParts[1];

    return array('id' => $id, 'email' => $email);
}

// Verificar se a chave está presente na URL
if (isset($_GET['id'])) {
    $chave = $_GET['id'];

    // Descriptografar a chave
    $userInfo = decryptChave($chave);

    // Exibir informações do usuário
    echo '<div class="alert alert-info">';
    echo 'ID do usuário: ' . $userInfo['id'] . '<br>';
    echo 'E-mail do usuário: ' . $userInfo['email'];
    echo '</div>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificação de Código</title>
    <!-- Adicione o link para o arquivo CSS do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Verificação de Código</h1>

        <form method="POST" action="index.php">
            <div class="mb-3">
                <label for="verification_code" class="form-label">Código de Verificação:</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" class="btn btn-primary" name="verify_code">Verificar</button>
        </form>
    </div>

    <!-- Adicione o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
