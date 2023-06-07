<?php
require_once 'db.php';

session_start();

function deleteDirectory(string $directoryPath) : bool {
    if (!is_dir($directoryPath)) {
        return false;
    }

    $files = array_diff(scandir($directoryPath), array('.', '..'));
    
    foreach ($files as $file) {
        $filePath = $directoryPath . '/' . $file;
        
        if (is_dir($filePath)) {
            deleteDirectory($filePath);
        } else {
            unlink($filePath);
        }
    }

    return rmdir($directoryPath);
}


if(isset($_GET['mode']) && $_GET['mode'] === 'register') {
    require_once 'add_product.php';
    exit();
}


if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'vendedor' ) {
    header("Location: login.php"); // Redireciona para o login caso não seja um vendedor
    exit();
}

//Retorna os produtos atralados ao id do usuario
$userId = $_SESSION['id'];
$sql = "SELECT * FROM Products WHERE User_Id = $userId";
$result = $db->query($sql);

// Deleta o produto
if (isset($_POST['delete_product'])) {
    $productId = $_POST['id'];
    // Perform validation and delete product from database
    $stmt = $db->prepare('DELETE FROM Products WHERE Product_Id = ?');
    $stmt->bind_param('i', $productId);
    $stmt->execute();

    $stmt = $db->prepare('DELETE FROM Images WHERE Product_Id = ?');
    $stmt->bind_param('i', $productId);
    $stmt->execute();

    $stmt->close();

    deleteDirectory("img/product_images/$productId/");

    header("Location: meusprodutos.php");
}

?>

<?php require_once 'header.php'; ?>

<?php if ($result->num_rows > 0) : ?>

<div class="conteiner">
    <br>
    <br>
    <fieldset class="bg-light opacity-60 p-4 rounded">
        <h1 class="text-center">Meus Produtos</h1>
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Data</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    </fieldset>
    <?php

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td><a href="produto.php?id=' . $row['Product_Id'] . '" class="btn btn-success mt-3">Acessar</a></td>';
    echo '<td>' . $row['Product_Name'] . '</td>';
    echo '<td>' . $row['Product_Price'] . '</td>';
    echo '<td>' . $row['Product_Date'] . '</td>';
    echo '<td><a href="editarproduto.php?id=' . $row['Product_Id'] . '" class="btn btn-warning">Modificar</a></td>';
    echo '<td><a href="excluirproduto.php?id=' . $row['Product_Id'] . '" class="btn btn-danger">Excluir</a></td>';
    echo '</tr>';
}
?>

    </tbody>
    </table>
</div>

<?php else: ?>

<h2>Nenhum produto registrado</h2>

<?php endif; ?>

<br>
<br>
<div class="conteiner text-center">
    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?mode=register'; ?>"
        class="btn btn-lg btn-primary">Adicionar Produto</a>
</div>

<?php require_once 'footer.php'; ?>