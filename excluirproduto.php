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

// Exclui o produto do banco de dados
if (isset($_POST['delete_product'])) {
    // Realiza a exclusão do produto do banco de dados
    $stmt = $db->prepare('DELETE FROM Products WHERE Product_Id = ?');
    $stmt->bind_param('i', $productId);
    $stmt->execute();

    $stmt->close();

    // Excluir as imagens relacionadas ao produto (se necessário)
    // deleteDirectory("img/product_images/$productId/");

    header("Location: meusprodutos.php");
    exit();
}

?>

<?php require_once 'header.php'; ?>

<div class="container">
    <h1>Excluir Produto</h1>
    <p>Tem certeza de que deseja excluir o seguinte produto?</p>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $product['Product_Name']; ?></h5>
            <p class="card-text">Preço: <?php echo $product['Product_Price']; ?></p>
            <!-- Incluir outras informações do produto, se necessário -->
        </div>
    </div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $productId); ?>">
        <button type="submit" name="delete_product" class="btn btn-danger mt-3">Excluir</button>
        <a href="meusprodutos.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

<?php require_once 'footer.php'; ?>
