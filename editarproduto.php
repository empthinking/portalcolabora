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

// Recupera os detalhes do produto do banco de dados
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

// Atualiza o produto no banco de dados
if (isset($_POST['update_product'])) {
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];

    // Realiza a validação dos dados e atualiza o produto no banco de dados
    $stmt = $db->prepare('UPDATE Products SET Product_Name = ?, Product_Price = ? WHERE Product_Id = ?');
    $stmt->bind_param('ssi', $productName, $productPrice, $productId);
    $stmt->execute();

    $stmt->close();

    header("Location: meusprodutos.php");
    exit();
}

?>

<?php require_once 'header.php'; ?>

<div class="container">
    <h1>Editar Produto</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $productId); ?>">
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['Product_Name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Preço</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['Product_Price']; ?>" required>
        </div>
        <button type="submit" name="update_product" class="btn btn-primary">Atualizar</button>
    </form>
</div>

<?php require_once 'footer.php'; ?>
