<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login_admin.php");
    exit();
}

// Verificar se o usuário possui permissão de administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: acesso_negado.php");
    exit();
}

require_once "db.php";

// Verificar se o parâmetro 'id' está presente na URL
if (!isset($_GET['id'])) {
    header("Location: listar_produtos.php");
    exit();
}

$product_id = $_GET['id'];

// Verificar se o formulário foi enviado para atualizar o produto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter os dados do formulário
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $product_description = mysqli_real_escape_string($conn, $_POST["product_description"]);
    $product_price = mysqli_real_escape_string($conn, $_POST["product_price"]);

    // Atualizar as informações do produto no banco de dados
    $update_query = "UPDATE Products SET Product_Name = '$product_name', Product_Description = '$product_description', Product_Price = '$product_price' WHERE Product_Id = $product_id";
    mysqli_query($conn, $update_query);

    // Redirecionar de volta para a página listar_produtos.php após a atualização
    header("Location: listar_produtos.php");
    exit();
}

// Consultar o banco de dados para obter as informações do produto
$query = "SELECT * FROM Products WHERE Product_Id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Verificar se o produto foi encontrado
if (!$product) {
    header("Location: listar_produtos.php");
    exit();
}

// Consultar o banco de dados para obter as imagens do produto
$query_images = "SELECT * FROM Images WHERE Product_Id = $product_id";
$result_images = mysqli_query($conn, $query_images);
$images = mysqli_fetch_all($result_images, MYSQLI_ASSOC);

// Verificar se há solicitação para excluir uma imagem
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];

    // Verificar se a imagem pertence ao produto
    $query_check_image = "SELECT * FROM Images WHERE Image_Id = $image_id AND Product_Id = $product_id";
    $result_check_image = mysqli_query($conn, $query_check_image);
    $image = mysqli_fetch_assoc($result_check_image);

    if ($image) {
        // Excluir a imagem do banco de dados e do diretório
        $image_path = $image['Image_Name'];
        $delete_query = "DELETE FROM Images WHERE Image_Id = $image_id";
        mysqli_query($conn, $delete_query);

        if (unlink($image_path)) {
            echo "<script>alert('Imagem excluída com sucesso!');</script>";
        } else {
            echo "<script>alert('Falha ao excluir a imagem do diretório.');</script>";
        }
    } else {
        echo "<script>alert('A imagem não pertence ao produto ou não existe.');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <h2>Editar Produto</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Nome do Produto:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['Product_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_description">Descrição do Produto:</label>
                <textarea class="form-control" id="product_description" name="product_description"><?php echo $product['Product_Description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="product_price">Preço do Produto:</label>
                <input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo $product['Product_Price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="product_images">Imagens do Produto:</label>
                <div class="row">
                    <?php foreach ($images as $image) { ?>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <img src="<?php echo $image['Image_Name']; ?>" class="card-img-top" alt="Imagem do Produto">
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <input type="hidden" name="image_id" value="<?php echo $image['Image_Id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-block">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="listar_produtos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
