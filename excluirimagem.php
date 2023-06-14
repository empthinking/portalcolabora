<?php
require_once 'db.php';

session_start();

if (!isUserLoggedIn()) {
    header('Location: index.php');
    exit();
}

$image_id = $_GET['id'];
$product_id = $_GET['product_id'];

// Verificar se a imagem pertence ao produto do usuário logado
$stmt = $db->prepare('SELECT * FROM Images WHERE Image_Id = ? AND Product_Id = ?');
$stmt->bind_param('ii', $image_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // A imagem não pertence ao produto ou não existe
    header("Location: editarproduto.php?id=$product_id");
    exit();
}

// Excluir a imagem do banco de dados e do diretório
$image = $result->fetch_assoc();
$image_path = $image['Image_Name'];

$deleteStmt = $db->prepare("DELETE FROM Images WHERE Image_Id = ?");
$deleteStmt->bind_param("i", $image_id);

if ($deleteStmt->execute()) {
    if (unlink($image_path)) {
        echo "Imagem excluída com sucesso!";
    } else {
        echo "Falha ao excluir a imagem do diretório.";
    }
} else {
    echo "Falha ao excluir a imagem do banco de dados.";
}

$stmt->close();
