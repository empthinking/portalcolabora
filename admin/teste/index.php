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

        <?php
        // Verificar se o formulário foi submetido para validar o código
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
            // Obter o código digitado pelo usuário
            $verificationCode = $_POST['verification_code'];

            // Validar o código de verificação
            if (validateVerificationCode($verificationCode)) {
                echo '<div class="alert alert-success">Código de verificação válido. Acesso permitido.</div>';
            } else {
                echo '<div class="alert alert-danger">Código de verificação inválido ou expirado. Acesso negado.</div>';
            }
        }
        ?>

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
