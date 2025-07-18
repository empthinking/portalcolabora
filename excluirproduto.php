<?php
require_once 'db.php';

session_start();

if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'vendedor') {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do produto está presente
if (!isset($_GET['id'])) {
    header("Location: meusprodutos.php");
    exit();
}

$productId = $_GET['id'];
$userId = $_SESSION['id'];

// Verifica se o produto pertence ao usuário logado
$stmt = $db->prepare('SELECT * FROM Products WHERE Product_Id = ? AND User_Id = ?');
$stmt->bind_param('ii', $productId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // O produto não pertence ao usuário logado
    header("Location: meusprodutos.php");
    exit();
}

$stmt->close();

// Exclui o produto do banco de dados
$stmt = $db->prepare('DELETE FROM Products WHERE Product_Id = ?');
$stmt->bind_param('i', $productId);
$stmt->execute();

$stmt = $db->prepare('DELETE FROM Images WHERE Product_Id = ?');
$stmt->bind_param('i', $productId);
$stmt->execute();

$stmt->close();

// Remove o diretório das imagens relacionadas ao produto
$directoryPath = "img/product_images/$productId/";
if (is_dir($directoryPath)) {
    $files = array_diff(scandir($directoryPath), array('.', '..'));
    
    foreach ($files as $file) {
        $filePath = $directoryPath . $file;
        
        if (is_dir($filePath)) {
            deleteDirectory($filePath);
        } else {
            unlink($filePath);
        }
    }

    rmdir($directoryPath);
}

header("Location: meusprodutos.php");
exit();

function deleteDirectory(string $directoryPath): bool {
    if (!is_dir($directoryPath)) {
        return false;
    }

    $files = array_diff(scandir($directoryPath), array('.', '..'));
    
    foreach ($files as $file) {
        $filePath = $directoryPath . $file;
        
        if (is_dir($filePath)) {
            deleteDirectory($filePath);
        } else {
            unlink($filePath);
        }
    }

    return rmdir($directoryPath);
}
?>
