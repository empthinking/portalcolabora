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
<div class="conteiner">
  <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?mode=register'; ?>" class="btn btn-primary">Adicionar</a>
</div>

<?php if ($result->num_rows > 0) : ?>

  <div class="conteiner">
    <h1>Meus Produtos</h1>
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
<?php

    while ($row = $result->fetch_assoc()) {
        echo <<<ROW
            <tr>
              <td><a href="produto.php?id={$row['Product_Id']}" class="btn btn-primary">acessar</a></td>
              <td>{$row['Product_Name']}</td></a>
              <td>{$row['Product_Price']}</td>
              <td>{$row['Product_Date']}</td>
              <td><a href="#" class="btn btn-success">modificar</a></td>
              <td><a href="#" class="btn btn-danger">excluir</a></td>
            </tr>
            ROW;
    }
?>
      </tbody>    
    </table>
  </div>

<?php else: ?>

  <h2>Nenhum produto registrado</h2>

<?php endif; ?>

<?php require_once 'footer.php'; ?>

