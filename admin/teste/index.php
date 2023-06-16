<?php
require_once "dbconn.php";

function checkVerificationCode($userEmail, $userId, $code) {
    global $connection;

    $currentTime = time();

    // Consultar o banco de dados para verificar se o código existe e não expirou
    $stmt = $connection->prepare("SELECT expiry_time FROM verification_codes WHERE User_Email = ? AND User_Id = ? AND code = ?");
    $stmt->bind_param("sis", $userEmail, $userId, $code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($expiryTime);
        $stmt->fetch();

        if ($expiryTime >= $currentTime) {
            // O código existe e não expirou
            return true;
        }
    }

    return false;
}

function markEmailAsVerified($userEmail, $userId) {
    global $connection;

    // Atualizar o status de verificação do e-mail no banco de dados
    $stmt = $connection->prepare("UPDATE Users SET EmailVerified = 1 WHERE User_Email = ? AND User_Id = ?");
    $stmt->bind_param("si", $userEmail, $userId);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $chave = $_GET["id"];
    $decodedKey = base64_decode($chave);
    $keyParts = explode("|", $decodedKey);

    $userEmail = $keyParts[0];
    $userId = $keyParts[1];
    $code = $_GET["code"];

    $verificationCodeValid = checkVerificationCode($userEmail, $userId, $code);

    if ($verificationCodeValid) {
        // Código de verificação válido
        markEmailAsVerified($userEmail, $userId);

        // Exibir o conteúdo da chave descriptografada
        echo "<h1>Chave decriptografada</h1>";
        echo "<p>Email: $userEmail</p>";
        echo "<p>ID do usuário: $userId</p>";
    } else {
        // Código de verificação inválido ou expirado
        echo "<h1>Código de verificação inválido ou expirado</h1>";
    }
}
?>
