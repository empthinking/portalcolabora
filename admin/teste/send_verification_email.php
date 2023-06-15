<?php
require_once "dbconn.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o e-mail do formulário
    $email = $_POST["email"];

    // Verifica se o e-mail é válido
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Gerar um código de verificação seguro
        $verificationCode = generateSecureVerificationCode();

        // Armazenar o código de verificação e a hora de expiração em um banco de dados ou em uma sessão
        storeVerificationCode($verificationCode);

        // Enviar o código por e-mail
        sendVerificationCodeByEmail($verificationCode, $email);
        
        // Mensagem de sucesso
        $success = "O código de verificação foi enviado para o e-mail fornecido.";
    } else {
        // E-mail inválido
        $errors['email'] = "E-mail inválido. Por favor, insira um endereço de e-mail válido.";
    }
}

// Função para enviar o código de verificação por e-mail
function sendVerificationCodeByEmail($code, $recipientEmail) {
    $to = $recipientEmail;
    $subject = 'Código de verificação';
    $message = 'Seu código de verificação é: ' . $code;
    $headers = 'From: suporte@portalcolabora.com.br' . "\r\n" .
               'Reply-To: suporte@portalcolabora.com.br' . "\r\n" .
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
    global $connection;

    $expiryTime = time() + (60 * 5); // Expira em 5 minutos

    // Preparar a consulta SQL
    $stmt = $connection->prepare("INSERT INTO verification_codes (code, expiry_time) VALUES (?, ?)");
    $stmt->bind_param("si", $code, $expiryTime);

    // Executar a consulta
    if ($stmt->execute()) {
        // Código de verificação armazenado com sucesso
    } else {
        // Tratar o erro de armazenamento
    }

    // Fechar a declaração
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Envio de Código de Verificação</title>
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
    <h1>Envio de Código de Verificação</h1>
    
    <?php if (isset($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <label for="email">Digite seu e-mail:</label>
        <input type="email" id="email" name="email" required>
        <?php if (isset($errors['email'])): ?>
            <div class="error"><?php echo $errors['email']; ?></div>
        <?php endif; ?>
        <button type="submit">Enviar código de verificação</button>
    </form>
</body>
</html>
