<?php
require_once "dbconn.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o e-mail do formulário
    $email = $_POST["email"];

    // Verifica se o e-mail é válido
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Consulta o banco de dados para verificar se o e-mail existe
        $stmt = $connection->prepare("SELECT User_Email FROM Users WHERE User_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();


        if ($result->num_rows > 0) {
            // E-mail existe na tabela de usuários

            // Gerar um código de verificação seguro
            $verificationCode = generateSecureVerificationCode();

            // Armazenar o código de verificação e a hora de expiração em um banco de dados ou em uma sessão
            storeVerificationCode($verificationCode);

            // Enviar o código por e-mail
            sendVerificationCodeByEmail($verificationCode, $email,$row);

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
function sendVerificationCodeByEmail($code, $recipientEmail,$row) {
$chave = base64_encode($row['User_Email'].$row['User_Id']);
    $to = $recipientEmail;
    $subject = 'Código de verificação';
    $message = 'Seu código de verificação é: ' . $code . "\n\n";
    $message .= 'Utilize o seguinte link para validar seu e-mail: ';
    $message .= 'https://portalcolabora.com.br/admin/teste/index.php?id=' . $chave;
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
