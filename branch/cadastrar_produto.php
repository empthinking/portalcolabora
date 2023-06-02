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

<div class="container">
    <h1 class="mt-4">Cadastro de Produto</h1>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea class="form-control" name="description" id="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>

<div class="form-group">
            <label for="price">Preço:</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required>
        </div>

        <div class="form-group">
            <label for="images">Imagens:</label>
            <input type="file" class="form-control-file" name="images[]" id="images" accept="image/*" multiple required>
            <small class="form-text text-muted">Adicione até 5 imagens</small>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<?php
require_once 'footer.php';
?>
