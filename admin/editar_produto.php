<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: index.php");
    exit();
}

require_once "db.php";

// Verificar se o parâmetro 'id' está presente na URL
if (!isset($_GET['id'])) {
    header("Location: meus_produtos.php");
    exit();
}

$product_id = $_GET['id'];

// Verificar se o formulário foi enviado para atualizar o produto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter os dados do formulário
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $images = $_FILES['images'];

    if (empty($name) || empty($description) || empty($price)) {
        $error = 'Preencha todos os campos';
    } else {
        // Atualizar as informações do produto no banco de dados
        $updateProductStmt = $db->prepare("UPDATE Products SET Product_Name = ?, Product_Description = ?, Product_Price = ? WHERE Product_Id = ?");
        $updateProductStmt->bind_param("ssdi", $name, $description, $price, $product_id);

        if ($updateProductStmt->execute()) {
            // Verificar se novas imagens foram enviadas
            if (!empty($images['name'][0])) {
                // Excluir todas as imagens existentes do produto
                $deleteImagesStmt = $db->prepare("DELETE FROM Images WHERE Product_Id = ?");
                $deleteImagesStmt->bind_param("i", $product_id);
                $deleteImagesStmt->execute();

                //Cria um diretório caso não exista
                $targetDir = 'img/product_images/';
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                //Atualiza e armazena as novas imagens
                foreach ($images['name'] as $index => $imageName) {
                    $imageDate = date('Y-m-d H:i:s');
                    $imagePath = $targetDir . uniqid() . '_' . $imageName;

                    if (move_uploaded_file($images['tmp_name'][$index], $imagePath)) {
                        $insertImageStmt = $db->prepare("INSERT INTO Images (Image_Name, Image_Date, Product_Id) VALUES (?, ?, ?)");
                        $insertImageStmt->bind_param("ssi", $imagePath, $imageDate, $product_id);
                        $insertImageStmt->execute();
                    }
                }
            }

            // Redirecionar de volta para a página meus_produtos.php após a atualização
            header("Location: meus_produtos.php");
            exit();
        } else {
            $error = 'Falha ao atualizar o produto. Por favor, tente novamente.';
        }
    }
}

// Consultar o banco de dados para obter as informações do produto e imagens relacionadas
$stmt = $db->prepare("
    SELECT p.Product_Name, p.Product_Description, p.Product_Price, u.User_Name, u.User_Id, u.User_Number, i.Image_Name
    FROM Products p
    INNER JOIN Users u ON p.User_Id = u.User_Id
    LEFT JOIN Images i ON p.Product_Id = i.Product_Id
    WHERE p.Product_Id = ?
");
$stmt->bind_param('i', $product_id);
if ($stmt->execute()) {
    $stmt->bind_result($product_name, $product_description, $product_price, $vendor_name, $vendor_id, $User_Number, $image_name);
    $stmt->fetch();
} else {
    $error = 'Falha ao recuperar informações do produto.';
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Editar Produto</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nome do Produto:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição do Produto:</label>
                <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($product_description); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Preço do Produto:</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product_price); ?>" required>
            </div>
            <div class="form-group">
                <label for="images">Imagens do Produto:</label>
                <input type="file" class="form-control-file" id="images" name="images[]" multiple>
            </div>
            <?php if ($image_name) : ?>
                <div class="form-group">
                    <label>Imagens Atuais:</label>
                    <?php foreach ($image_name as $image) : ?>
                        <div class="d-flex align-items-center">
                            <img src="<?php echo $image; ?>" alt="Imagem do Produto" width="150" height="150">
                            <a href="excluir_imagem.php?id=<?php echo $image['Image_Id']; ?>&product_id=<?php echo $product_id; ?>" class="btn btn-danger ml-3">Excluir</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="meus_produtos.php" class="btn btn-secondary">Voltar para Meus Produtos</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
