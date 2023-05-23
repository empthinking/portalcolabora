<?php
require_once 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect if product ID is not provided
    header('Location: index.php');
    exit();
}

$productId = $_GET['id'];

// Fetch product details from the database
$sql = "SELECT p.Product_Name, p.Product_Description, p.Product_Price, u.User_Name, i.Image_Name
        FROM Products p
        INNER JOIN Users u ON p.User_Id = u.User_Id
        LEFT JOIN Images i ON p.Product_Id = i.Product_Id
        WHERE p.Product_Id = '$productId'
        ORDER BY i.Image_Id ASC";
$result = $db->query($sql);

require_once 'header.php';
?>

<div class="container">
    <?php if ($result->num_rows > 0) : ?>
        <?php $row = $result->fetch_assoc(); ?>
        <h1 class="mt-4"><?php echo $row['Product_Name']; ?></h1>

        <div id="productCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $imageIndex = 0; ?>
                <?php mysqli_data_seek($result, 0); ?>
                <?php while ($image = $result->fetch_assoc()) : ?>
                    <li data-target="#productCarousel" data-slide-to="<?php echo $imageIndex; ?>" <?php if ($imageIndex === 0) echo 'class="active"'; ?>></li>
                    <?php $imageIndex++; ?>
                <?php endwhile; ?>
            </ol>
            <div class="carousel-inner">
                <?php $imageIndex = 0; ?>
                <?php mysqli_data_seek($result, 0); ?>
                <?php while ($image = $result->fetch_assoc()) : ?>
                    <div class="carousel-item <?php if ($imageIndex === 0) echo 'active'; ?>">
                        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
                            <img src="<?php echo $image['Image_Name']; ?>" class="img-fluid" style="max-height: 100%; max-width: 100%;" alt="Product Image">
                        </div>
                    </div>
                    <?php $imageIndex++; ?>
                <?php endwhile; ?>
            </div>
            <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="mt-4">
            <h4>Owner: <?php echo $row['User_Name']; ?></h4>
            <p>Description: <?php echo $row['Product_Description']; ?></p>
            <p>Price: <?php echo $row['Product_Price']; ?></p>
            <button class="btn btn-primary">Buy Now</button>
        </div>
    <?php else : ?>
        <p>No product found.</p>
    <?php endif; ?>
</div>

<?php
require_once 'footer.php';
?>
