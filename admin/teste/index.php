<?php
require_once "dbconn.php";

// Verificar se o formulário foi submetido para validar o código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    // Obter o código digitado pelo usuário
    $verificationCode = $_POST['verification_code'];

    // Validar o código de verificação
    if (validateVerificationCode($verificationCode)) {
        // Código válido
        echo '<div class="alert alert-success">Código de verificação válido. Acesso permitido.</div>';
        // Redirecionar para a página de teste
        header("Location: teste.php");
        exit();
    } else {
        // Código inválido ou expirado
        echo '<div class="alert alert-danger">Código de verificação inválido ou expirado. Acesso negado.</div>';
    }
}

// Função para remover o código de verificação do banco de dados
function removeVerificationCode($code) {
    global $connection;

    // Preparar a consulta SQL para remover o código
    $stmt = $connection->prepare("DELETE FROM verification_codes WHERE code = ?");
    $stmt->bind_param("s", $code);

    // Executar a consulta
    if ($stmt->execute()) {
        // Código de verificação removido com sucesso
    } else {
        // Tratar o erro de remoção
    }

    // Fechar a declaração
    $stmt->close();
}

// Função para validar o código de verificação
function validateVerificationCode($code) {
    global $connection;

    // Verificar se o código existe no banco de dados
    $stmt = $connection->prepare("SELECT expiry_time FROM verification_codes WHERE code = ? LIMIT 1");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $expiryTime = null; // Inicializar a variável $expiryTime
        $stmt->bind_result($expiryTime);
        $stmt->fetch();

        // Verificar se o código ainda está válido (não expirado)
        if (time() <= $expiryTime) {
            // Código válido
            $stmt->close();

            // Remover o código de verificação do banco de dados imediatamente
            removeVerificationCode($code);

            return true;
        }
    }

    // Código inválido ou expirado
    $stmt->close();
    return false;
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

        <form method="POST" action="index.php">
            <div class="mb-3">
                <label for="verification_code" class="form-label">Código de Verificação:</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" class="btn btn-primary" name="verify_code">Verificar</button>
        </form>

        <form method="POST" action="send_verification_email.php">
            <button type="submit" class="btn btn-secondary" name="send_email">Enviar Código por E-mail</button>
        </form>
    </div>

    <!-- Adicione os scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
