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

$product = $result->fetch_assoc();

$stmt->close();

// Query the database to fetch the product images
$stmt = $db->prepare('SELECT * FROM Product_Images WHERE Product_Id = ?');
$stmt->bind_param('i', $productId);
$stmt->execute();
$imageResult = $stmt->get_result();
$images = $imageResult->fetch_all(MYSQLI_ASSOC);

$stmt->close();

// Verifica se o formulário foi enviado para salvar as alterações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $updatedName = $_POST['name'];
    $updatedPrice = doubleval($_POST['price']);
    $updatedDescription = $_POST['description'];

    // Atualiza os dados do produto no banco de dados
    $stmt = $db->prepare('UPDATE Products SET Product_Name = ?, Product_Price = ?, Product_Description = ? WHERE Product_Id = ? AND User_Id = ?');
    $stmt->bind_param('ssssi', $updatedName, $updatedPrice, $updatedDescription, $productId, $userId);
    $stmt->execute();
    $stmt->close();

    // Redireciona de volta para a página de produtos do usuário
    header("Location: meusprodutos.php");
    exit();
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
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $product['Product_Id']; ?>">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['Product_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Preço</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['Product_Price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $product['Product_Description']; ?></textarea>
            </div>

            <h2>Imagens do Produto</h2>
            <?php foreach ($images as $image): ?>
                <img src="<?php echo $image['Image_Path']; ?>" alt="Product Image" width="200px">
                <a href="excluirimagem.php?id=<?php echo $image['Image_Id']; ?>&product_id=<?php echo $product['Product_Id']; ?>">Excluir</a>
                <hr>
            <?php endforeach; ?>

            <h3>Adicionar Imagem</h3>
            <form action="adicionarimagem.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $product['Product_Id']; ?>">
                <div class="form-group">
                    <input type="file" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">Adicionar Imagem</button>
            </form>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="meusprodutos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
