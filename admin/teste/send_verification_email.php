<?php
require_once "dbconn.php";

// Gerar um código de verificação seguro
$verificationCode = generateSecureVerificationCode();

// Armazenar o código de verificação e a hora de expiração no banco de dados ou em uma sessão
storeVerificationCode($verificationCode);

// Enviar o código por e-mail
sendVerificationCodeByEmail($verificationCode, 'colaboraequipe@gmail.coma');

// Função para gerar um código de verificação seguro
function generateSecureVerificationCode()
{
    $codeLength = 6;
    $characters = '0123456789';
    $code = '';

    for ($i = 0; $i < $codeLength; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

// Função para armazenar o código de verificação e a hora de expiração
function storeVerificationCode($code)
{
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


// Função para enviar o código de verificação por e-mail
function sendVerificationCodeByEmail($code, $recipientEmail)
{
    $to = $recipientEmail;
    $subject = 'Código de verificação';
    $message = 'Seu código de verificação é: ' . $code;
    $headers = 'From: info@example.com' . "\r\n" .
        'Reply-To: info@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}

// Redirecionar de volta para a página principal após o envio do e-mail
header('Location: index.php');
exit();
?>
