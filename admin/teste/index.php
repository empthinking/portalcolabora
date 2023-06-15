<?php
require_once "dbconn.php";

// Verificar se o formulário foi submetido para validar o código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    // Obter o código digitado pelo usuário
    $verificationCode = $_POST['verification_code'];

    // Validar o código de verificação
    if (validateVerificationCode($verificationCode)) {
        // Código válido, redirecionar para a página de teste
        header("Location: teste.php");
        exit();
    } else {
        // Código inválido, exibir mensagem de erro
        echo '<div class="alert alert-danger">Código de verificação inválido. Acesso negado.</div>';
    }
}

// Função para validar o código de verificação
function validateVerificationCode($code) {
    // Implemente a lógica de validação do código de verificação aqui
    // Por exemplo, consulte o banco de dados para verificar se o código existe e é válido
    // Retorne true se o código for válido, ou false caso contrário

    // Exemplo de lógica de validação:
    global $connection;

    $stmt = $connection->prepare("SELECT COUNT(*) FROM verification_codes WHERE code = ?");
    $stmt->bind_param("s", $code);
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
