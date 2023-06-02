<?php
// Assuming you have already connected to the database and obtained the product ID from the URL
$product_id = $_GET['product_id'];

// Query the database to fetch the product information
$stmt = $db->prepare("
    SELECT p.Product_Name, p.Product_Description, p.Product_Price, p.Product_Date, u.User_Name
    FROM Products p
    INNER JOIN Users u ON p.User_Id = u.User_Id
    WHERE p.Product_Id = ?
");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$stmt->bind_result($product_name, $product_description, $product_price, $product_date, $vendor_name);
$stmt->fetch();
$stmt->close();

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
        <h1>Product Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product_name; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Posted on <?php echo $product_date; ?></h6>
                <p class="card-text"><?php echo $product_description; ?></p>
                <p class="card-text">Price: <?php echo $product_price; ?></p>
                <p class="card-text">Vendor: <?php echo $vendor_name; ?></p>
            </div>
        </div>

        <h2>Product Images</h2>
        <div class="row">
            <?php foreach ($images as $image) : ?>
                <div class="col-md-3 mb-3">
                    <img src="img/<?php echo $vendor_id; ?>/<?php echo $image; ?>" class="img-fluid" alt="Product Image">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php require_once 'footer.php'; 
