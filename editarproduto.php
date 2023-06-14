<?php
require_once 'db.php';

session_start();

if (!isUserLoggedIn()) {
    header('Location: index.php');
    exit();
}

require_once 'header.php';

$error = '';
$product_id = $_GET['id'];

// Query the database to fetch the product information
$stmt = $db->prepare("
    SELECT p.Product_Name, p.Product_Description, p.Product_Price, p.Product_Date, u.User_Name, u.User_Id, u.User_Number
    FROM Products p
    INNER JOIN Users u ON p.User_Id = u.User_Id
    WHERE p.Product_Id = ?
");
$stmt->bind_param('i', $product_id);
if($stmt->execute()) {
    $stmt->bind_result($product_name, $product_description, $product_price, $product_date, $vendor_name, $vendor_id,$User_Number);
    $stmt->fetch();
} else {
    $error = false;
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle image uploads
    if (!empty($_FILES['images']['name'][0])) {
        $images = $_FILES['images'];

        //Cria um diretório caso não exista
        $targetDir = 'img/product_images/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $uploadedImages = [];

        //Atualiza e armazena as imagens
        foreach ($images['name'] as $index => $imageName) {
            $imageDate = date('Y-m-d H:i:s');
            $imagePath = $targetDir . uniqid() . '_' . $imageName;

            if (move_uploaded_file($images['tmp_name'][$index], $imagePath)) {
                $uploadedImages[] = $imagePath;

                $insertImageStmt = $db->prepare("INSERT INTO Images (Image_Name, Image_Date, User_Id, Product_Id) VALUES (?, ?, ?, ?)");
                $insertImageStmt->bind_param("ssii", $imagePath, $imageDate, $vendor_id, $product_id);
                $insertImageStmt->execute();
            }
        }
    }

    // Handle other form fields
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $updateProductStmt = $db->prepare("UPDATE Products SET Product_Name = ?, Product_Description = ?, Product_Price = ? WHERE Product_Id = ? AND User_Id = ?");
    $updateProductStmt->bind_param("ssdii", $name, $description, $price, $product_id, $vendor_id);

    if ($updateProductStmt->execute()) {
        echo '<div class="container">';
        echo 'Produto atualizado com sucesso!';
        echo '</div>';
    } else {
        $error = 'Falha ao atualizar o produto. Por favor, tente novamente.';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Produto</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Preço</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $product_price; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $product_description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="images">Imagens</label>
                <input type="file" class="form-control-file" id="images" name="images[]" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="meusprodutos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
