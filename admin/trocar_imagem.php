<?php
require_once 'db.php';

session_start();

if (!isUserLoggedIn()) {
    header('Location: index.php');
    exit();
}

$image_id = $_POST['image_id'];
$product_id = $_POST['product_id'];

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

// Trocar a imagem do produto
$image = $result->fetch_assoc();
$image_path = $image['Image_Name'];

$new_image = $_FILES['new_image'];

// Verificar se foi enviado um novo arquivo de imagem
if (!empty($new_image['name'])) {
    // Verificar se a imagem é válida
    if ($new_image['error'] === 0 && $new_image['size'] > 0) {
        // Remover a imagem antiga do diretório
        unlink($image_path);

        // Salvar a nova imagem no diretório
        $new_image_path = 'caminho/para/o/diretorio/' . $new_image['name'];
        move_uploaded_file($new_image['tmp_name'], $new_image_path);

        // Atualizar o caminho da imagem no banco de dados
        $updateStmt = $db->prepare("UPDATE Images SET Image_Name = ? WHERE Image_Id = ?");
        $updateStmt->bind_param("si", $new_image_path, $image_id);

        if ($updateStmt->execute()) {
            header("Location: editarproduto.php?id=$product_id");
            exit();
        } else {
            echo "Falha ao atualizar o caminho da imagem no banco de dados.";
        }
    } else {
        echo "Falha ao fazer o upload da nova imagem.";
    }
} else {
    echo "Nenhuma imagem foi selecionada.";
}

$stmt->close();
?>
