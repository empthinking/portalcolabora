<?php
require_once "dbconn.php";

// Verificar se o código de verificação está presente na URL
if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

    // Validar o código de verificação
    if (validateVerificationCode($verificationCode)) {
        // Redirecionar para a página de teste com a chave na URL
        header("Location: teste.php?code=" . urlencode($verificationCode));
        exit();
    } else {
        echo 'Código de verificação inválido.';
    }
}

// Função para validar o código de verificação
function validateVerificationCode($code) {
    global $connection;

    $stmt = $connection->prepare("SELECT COUNT(*) FROM verification_codes WHERE code = ? AND expiry_time >= ?");
    $stmt->bind_param("si", $code, time());
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
