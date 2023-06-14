<?php
require_once 'db.php';

session_start();

if (!isUserLoggedIn()) {
    header('Location: index.php');
    exit();
}

$name = $price = $description = '';
$error = '';

require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $images = $_FILES['images'];

    if (empty($name) || empty($description) || empty($price) || empty($images['name'][0])) {
        $error = 'Preencha todos os campos';
    } else {
        $userId = $_SESSION['id'];
        $productDate = date('Y-m-d H:i:s');

        $insertProductStmt = $db->prepare("INSERT INTO Products (Product_Name, Product_Description, Product_Price, Product_Date, User_Id) VALUES (?, ?, ?, ?, ?)");
        $insertProductStmt->bind_param("ssdsi", $name, $description, $price, $productDate, $userId);

        if ($insertProductStmt->execute()) {
            $productId = $insertProductStmt->insert_id;

            // Cria um diretório caso não exista
            $targetDir = 'img/product_images/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $uploadedImages = [];

            // Atualiza e armazena as imagens
            foreach ($images['name'] as $index => $imageName) {
                $imageDate = date('Y-m-d H:i:s');
                $imagePath = $targetDir . uniqid() . '_' . $imageName;

                if (move_uploaded_file($images['tmp_name'][$index], $imagePath)) {
                    $uploadedImages[] = $imagePath;

                    $insertImageStmt = $db->prepare("INSERT INTO Images (Image_Name, Image_Date, User_Id, Product_Id) VALUES (?, ?, ?, ?)");
                    $insertImageStmt->bind_param("ssii", $imagePath, $imageDate, $userId, $productId);
                    $insertImageStmt->execute();
                }
            }

            echo '<div class="conteiner">
            Produto Adicionado Com Sucesso';
            echo '<a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'" class="btn btn-primary">ADICIONAR OUTRO</a>';
            echo '<a href="index.php" class="btn btn-success">INÍCIO</a>';
            echo '</div>';
            exit();
        } else {
            $error = 'Failed to add the product. Please try again.';
        }
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
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Preço</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $description; ?></textarea>
            </div>

            <h2>Imagens do Produto</h2>
            <?php foreach ($images as $image): ?>
                <img src="<?php echo $image['Image_Path']; ?>" alt="Product Image" width="200px">
                <a href="?id=<?php echo $productId; ?>&image_id=<?php echo $image['Image_Id']; ?>">Excluir</a>
                <hr>
            <?php endforeach; ?>

            <h3>Adicionar Imagem</h3>
            <div class="form-group">
                <input type="file" name="images[]" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Imagem</button>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="meusprodutos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
