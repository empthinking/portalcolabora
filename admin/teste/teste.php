<?php 
require_once "dbconn.php";
// Gerar um código de verificação seguro
$verificationCode = generateSecureVerificationCode();

// Armazenar o código de verificação e a hora de expiração em um banco de dados ou em uma sessão
storeVerificationCode($verificationCode);

// Enviar o código por e-mail
sendVerificationCodeByEmail($verificationCode, 'viniciusvghrj@gmail.com');

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


// Função para enviar o código de verificação por e-mail
function sendVerificationCodeByEmail($code, $recipientEmail) {
    $to = $recipientEmail;
    $subject = 'Código de verificação';
    $message = 'Seu código de verificação é: ' . $code;
    $headers = 'From: info@example.com' . "\r\n" .
               'Reply-To: info@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
  
    mail($to, $subject, $message, $headers);
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

            // Remover o código de verificação do banco de dados, se desejado
            // removerVerificationCode($code);

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

        <?php
        // Verificar se o formulário foi submetido para enviar o e-mail
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_email'])) {
            // Gerar um novo código de verificação seguro
            $verificationCode = generateSecureVerificationCode();

            // Armazenar o código de verificação e a hora de expiração no banco de dados ou em uma sessão
            storeVerificationCode($verificationCode);

            // Enviar o código por e-mail
            sendVerificationCodeByEmail($verificationCode, 'viniciusvghrj@gmail.com');

            echo '<div class="alert alert-success">O código de verificação foi enviado para o seu e-mail.</div>';
        }

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

        <form method="POST" action="">
            <div class="mb-3">
                <label for="verification_code" class="form-label">Código de Verificação:</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" class="btn btn-primary" name="verify_code">Verificar</button>
            <button type="submit" class="btn btn-secondary" name="send_email">Enviar Código por E-mail</button>
        </form>
    </div>

    <!-- Adicione os scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
