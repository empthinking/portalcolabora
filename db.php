<?php

// Função simples para carregar variáveis do arquivo .env
function loadEnv(string $filePath): void
{
    if (!file_exists($filePath)) {
        return; // Se não existir, apenas ignora
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;

        list($key, $value) = explode('=', $line, 2);

        $value = trim($value);

        // Armazena no ambiente
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Carregar as variáveis
loadEnv(__DIR__ . '/.env');

// Sanitização
function validateData(string $value): string {
    return htmlspecialchars(trim($value));
}

// Status da sessão
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Pegando valores do .env
$DB_HOST = getenv('DB_HOST') ?: 'mysql-db';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: 'root';
$DB_NAME = getenv('DB_NAME') ?: 'portalcolabora_db';
$DB_PORT = getenv('DB_PORT') ?: 3306;

// Conexão com o banco
$db = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, (int)$DB_PORT);

// Checagem de erro
if ($db->connect_error) {
    exit('Falha na conexão: ' . $db->connect_error);
}

// Charset recomendado
$db->set_charset("utf8mb4");

?>
