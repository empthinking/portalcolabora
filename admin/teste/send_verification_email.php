<?php
require_once "dbconn.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o e-mail do formulário
    $email = $_POST["email"];

    // Verifica se o e-mail é válido
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Consulta o banco de dados para verificar se o e-mail existe
        $stmt = $connection->prepare("SELECT User_Id FROM Users WHERE User_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // E-mail existe na tabela de usuários

            // Gerar um código de verificação seguro
            $verificationCode = generateSecureVerificationCode();

            // Armazenar o código de verificação e a hora de expiração em um banco de dados ou em uma sessão
            storeVerificationCode($verificationCode);

            // Enviar o código por e-mail
            sendVerificationCodeByEmail($verificationCode, $email);

            // Mensagem de sucesso
            $success = "O código de verificação foi enviado para o e-mail fornecido.";
        } else {
            // E-mail não existe na tabela de usuários
            $errors['email'] = "O e-mail fornecido não está registrado em nosso sistema.";
        }

        // Fechar a declaração e liberar os resultados
        $stmt->close();
        $result->free();
    } else {
        // E-mail inválido
        $errors['email'] = "E-mail inválido. Por favor, insira um endereço de e-mail válido.";
    }
}

// Função para enviar o código de verificação por e-mail
function sendVerificationCodeByEmail($code, $recipientEmail) {
    $chave = base64_encode($email);
    $to = $recipientEmail;
    $subject = 'Código de verificação';
    $message = 'Seu código de verificação é: ' . $code . "\n\n";
    $message .= 'Utilize o seguinte link para validar seu e-mail: ';
    $message .= 'https://portalcolabora.com.br/admin/teste/index.php?id=' . urlencode($chave);
    $headers = 'From: suporte@example.com' . "\r\n" .
               'Reply-To: suporte@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}

// Função para gerar um código de verificação seguro
function generateSecureVerificationCode() {
    $codeLength = 6;
    $characters = '0123456789';
    $code = '';

    for ($i = 0; $i < $codeLength; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

// Função para armazenar o código de verificação e a hora de expiração
function storeVerificationCode($code) {
    // Aqui você pode implementar o armazenamento do código de verificação e a hora de expiração em um banco de dados ou em uma sessão, de acordo com a sua necessidade
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Envio de Código de Verificação</title>
    <!-- Adicione o link para o arquivo CSS do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Envio de Código de Verificação</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Digite seu e-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Enviar código de verificação</button>
        </form>
    </div>

    <!-- Adicione o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
