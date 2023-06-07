<?php
require_once 'db.php';

session_start();

if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'vendedor') {
    header("Location: login.php");
    exit();
}
$stmt->close();
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
        <form action="salvarproduto.php" method="POST">
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
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="meusprodutos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
