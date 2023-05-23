<?php
require_once 'db.php';

// Fetch products from the database
$sql = "SELECT p.Product_Id, p.Product_Name, p.Product_Price, i.Image_Name
        FROM Products p
        LEFT JOIN Images i ON p.Product_Id = i.Product_Id
        WHERE i.Image_Id = (
            SELECT Image_Id FROM Images WHERE Product_Id = p.Product_Id ORDER BY Image_Id ASC LIMIT 1
        )
        ORDER BY p.Product_Date DESC";
$result = $db->query($sql);

require_once 'header.php';
?>

<div class="container">
    <h2 class="mt-4">Recentes</h2>

    <div class="row">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <a href="product.php?id=<?php echo $row['Product_Id']; ?>">
                        <img src="<?php echo $row['Image_Name']; ?>" class="card-img-top" alt="Product Image">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="product.php?id=<?php echo $row['Product_Id']; ?>">
                                <?php echo $row['Product_Name']; ?>
                            </a>
                        </h5>
                        <p class="card-text">Price: <?php echo $row['Product_Price']; ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if ($result->num_rows === 0) : ?>
            <div class="col">
                <p>Nenhum Produto Registrado.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
require_once 'footer.php';
?>
