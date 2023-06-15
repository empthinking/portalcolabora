<?php
require_once "dbconn.php";

// Verificar se o formulário foi submetido para validar o código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    $verificationCode = $_POST['verification_code'];

    // Validar o código de verificação
    if (validateVerificationCode($verificationCode)) {
        // Obter a chave codificada da URL
        $encodedKey = $_GET['chave'];

        // Decodificar a chave
        $decodedKey = base64_decode($encodedKey);

        // Descriptografar a chave
        $decryptedKey = decryptKey($decodedKey);

        // Obter os dados (ID e email) da chave descriptografada
        list($userId, $email) = explode('|', $decryptedKey);

        // Validar os dados com a tabela User
        if (validateUser($userId, $email)) {
            // Iniciar a sessão para o usuário
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $email;

            // Redirecionar para a página de teste
            header("Location: teste.php");
            exit();
        } else {
            // Dados inválidos, exibir mensagem de erro
            echo '<div class="alert alert-danger">Dados inválidos. Acesso negado.</div>';
        }
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

// Função para descriptografar a chave
function decryptKey($encryptedKey) {
    // Aqui você deve implementar o algoritmo de descriptografia adequado
    // Utilize a lógica de descriptografia que você possui

    // Exemplo: descriptografia simples com base64_decode
    $decryptedKey = base64_decode($encryptedKey);

    return $decryptedKey;
}

// Função para validar os dados do usuário
function validateUser($userId, $email) {
    global $connection;

    $stmt = $connection->prepare("SELECT COUNT(*) FROM User WHERE User_Id = ? AND User_Email = ?");
    $stmt->bind_param("is", $userId, $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificação de Código</title>
    <!-- Adicione os links para os arquivos CSS do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Verificação de Código</h1>

        <!-- Formulário para verificar o código de verificação -->
        <form method="POST" action="index.php">
            <div class="mb-3">
                <label for="verification_code" class="form-label">Código de Verificação:</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" class="btn btn-primary" name="verify_code">Verificar</button>
        </form>

        <!-- Formulário para gerar e validar a chave -->
        <form method="POST" action="validate_key.php">
            <button type="submit" class="btn btn-secondary" name="validate_key">Validar Chave</button>
        </form>
    </div>
</body>
</html>
