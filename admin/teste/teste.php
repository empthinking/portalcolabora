<?php
require_once "dbconn.php";

// Verificar se a chave está presente na URL
if (isset($_GET['chave'])) {
    // Obter a chave da URL
    $chave = $_GET['chave'];

    // Verificar se a chave é válida
    if (validateChave($chave)) {
        // Obter as informações do usuário com base no User_Id relacionado à chave
        $user = getUserByChave($chave);

        // Verificar se o usuário foi encontrado
        if ($user) {
            // Exibir as informações do usuário
            echo "<h1>Dados do Usuário</h1>";
            echo "<p>Nome: " . $user['User_Nome'] . "</p>";
            echo "<p>E-mail: " . $user['User_Email'] . "</p>";
        } else {
            // Usuário não encontrado
            echo '<div class="alert alert-danger">Usuário não encontrado.</div>';
        }
    } else {
        // Chave inválida
        echo '<div class="alert alert-danger">Chave inválida. Acesso negado.</div>';
    }
} else {
    // Chave não presente na URL
    echo '<div class="alert alert-danger">Acesso negado. Chave não fornecida.</div>';
}

// Função para validar a chave
function validateChave($chave) {
    // Implemente a lógica de validação da chave aqui
    // Por exemplo, verifique se a chave existe no banco de dados ou se atende a algum critério específico
    // Retorne true se a chave for válida, ou false caso contrário

    // Exemplo de lógica de validação:
    global $connection;

    $stmt = $connection->prepare("SELECT COUNT(*) FROM Users WHERE User_Id = ? AND Chave = ?");
    $stmt->bind_param("ss", $userId, $chave);

    // Obter o User_Id relacionado à chave
    $userId = getUserIdByChave($chave);

    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

// Função para obter o User_Id relacionado à chave
function getUserIdByChave($chave) {
    // Implemente a lógica para obter o User_Id relacionado à chave
    // Por exemplo, consulte o banco de dados para obter o User_Id
    // Retorne o User_Id

    // Exemplo de lógica:
    global $connection;

    $stmt = $connection->prepare("SELECT User_Id FROM Users WHERE Chave = ?");
    $stmt->bind_param("s", $chave);
    $stmt->execute();
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();

    return $userId;
}

// Função para obter as informações do usuário com base no User_Id
function getUserByChave($chave) {
    // Implemente a lógica para obter as informações do usuário com base no User_Id
    // Por exemplo, consulte o banco de dados para obter o nome e e-mail do usuário
    // Retorne as informações do usuário em um array associativo

    // Exemplo de lógica:
    global $connection;

    $stmt = $connection->prepare("SELECT User_Nome, User_Email FROM Users WHERE Chave = ?");
    $stmt->bind_param("s", $chave);
    $stmt->execute();
    $stmt->bind_result($nome, $email);
    $stmt->fetch();
    $stmt->close();

    if ($nome && $email) {
        return array(
            'User_Nome' => $nome,
            'User_Email' => $email
        );
    } else {
        return false;
    }
}
?>
