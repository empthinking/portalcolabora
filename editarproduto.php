<?php
session_start();

require_once 'db.php';

// Assuming you have already connected to the database and obtained the product ID from the URL
$product_id = $_GET['id'] ?? '';
$error = false;

// Query the database to fetch the product information
$stmt = $db->prepare("
    SELECT p.Product_Name, p.Product_Description, p.Product_Price, p.Product_Date, u.User_Name, u.User_Id, u.User_Number
    FROM Products p
    INNER JOIN Users u ON p.User_Id = u.User_Id
    WHERE p.Product_Id = ?
");
$stmt->bind_param('i', $product_id);
if ($stmt->execute()) {
    $stmt->bind_result($product_name, $product_description, $product_price, $product_date, $vendor_name, $vendor_id, $User_Number);
    $stmt->fetch();
} else {
    $error = false;
}
$stmt->close();

if (isset($_GET['mode']) && $_GET['mode'] === 'register') {
    require_once 'send_message.php';
    exit();
}

// Query the database to fetch the associated images
$stmt = $db->prepare("
    SELECT Image_Name
    FROM Images
    WHERE Product_Id = ?
");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$stmt->bind_result($image_name);

$images = array();

while ($stmt->fetch()) {
    $images[] = $image_name;
}

$stmt->close();
?>

<?php require_once 'header.php'; ?>

<div class="container">
    <?php if (!$error) : ?>
        <h1>Detalhes do Produto:</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product_name; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Postado em <?php echo $product_date; ?></h6>
                <p class="card-text"><?php echo $product_description; ?></p>
                <p class="card-text">Preço: <?php echo $product_price; ?></p>
                <p class="card-text">Anunciante: <?php echo $vendor_name; ?></p>
                <a class="btn btn-success my-2" href="<?php echo isUserLoggedIn() ? htmlspecialchars($_SERVER['PHP_SELF']) . "?id=$product_id&mode=register" : "login.php"; ?>">Contatar</a>
                <a class="btn btn-success my-2" <?php echo isUserLoggedIn() ? "href='https://api.whatsapp.com/send?phone=+55$User_Number&text=Olá, tudo bem?' target='_blank'" : "href=login.php"; ?>><i class="fa-brands fa-whatsapp fa-spin"></i></a>
            </div>
        </div>

        <h2>Imagens</h2>
        <div class="row">
            <?php foreach ($images as $image) : ?>
                <div class="col-md-3 mb-3">
                    <img src="<?php echo $image; ?>" class="img-fluid" alt="Product Image">
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Formulário para adicionar uma nova imagem -->
        <h2>Adicionar Imagem</h2>
        <form action="adicionarimagem.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="form-group">
                <label for="image">Selecione a imagem</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Imagem</button>
        </form>
        
        <!-- Formulário para excluir uma imagem -->
        <h2>Excluir Imagem</h2>
        <form action="excluirimagem.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="form-group">
                <label for="image_select">Selecione a imagem para excluir</label>
                <select class="form-control" id="image_select" name="image_select">
                    <?php foreach ($images as $image) : ?>
                        <option value="<?php echo $image; ?>"><?php echo $image; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Excluir Imagem</button>
        </form>
        
        <!-- Formulário para alterar uma imagem -->
        <h2>Alterar Imagem</h2>
        <form action="alterarimagem.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="form-group">
                <label for="old_image_select">Selecione a imagem para alterar</label>
                <select class="form-control" id="old_image_select" name="old_image_select">
                    <?php foreach ($images as $image) : ?>
                        <option value="<?php echo $image; ?>"><?php echo $image; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_image">Selecione a nova imagem</label>
                <input type="file" class="form-control-file" id="new_image" name="new_image" required>
            </div>
            <button type="submit" class="btn btn-primary">Alterar Imagem</button>
        </form>
        
        <a href="index.php" class="btn btn-danger"><i class="fas fa-undo"></i> Voltar</a>

    <?php else :
        echo "<p>$error</p>";
    endif;
    ?>
</div>

<?php require_once 'footer.php'; ?>
