<?php

// Fetch products from the database
$keyword = $_GET['search']??'';
if($keyword) {
$sql = "SELECT p.Product_Id, p.Product_Name, p.Product_Price, i.Image_Name
            FROM Products p
            LEFT JOIN Images i ON p.Product_Id = i.Product_Id
            WHERE p.Product_Name LIKE '%$keyword%'
            AND i.Image_Id = (
                SELECT Image_Id FROM Images WHERE Product_Id = p.Product_Id ORDER BY Image_Id ASC LIMIT 1
            )
            ORDER BY p.Product_Date DESC";
} else {

    $sql = "SELECT p.Product_Id, p.Product_Name, p.Product_Price, i.Image_Name
            FROM Products p
            LEFT JOIN Images i ON p.Product_Id = i.Product_Id
            WHERE i.Image_Id = (
                SELECT Image_Id FROM u871226378_Colabora.Images WHERE Product_Id = p.Product_Id ORDER BY Image_Id ASC LIMIT 1
            )
            ORDER BY p.Product_Date DESC";
}



$result = $db->query($sql);

require_once 'header.php';
?>

<div class="container">
    <h2 class="mt-4">Recentes</h2>

    <div class="row">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <a href="produto.php?id=<?php echo $row['Product_Id']; ?>">
                    <img src="<?php echo $row['Image_Name']; ?>" class="card-img-top fixed-size" alt="Product Image  style="width: 100%; height: auto;">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="produto.php?id=<?php echo $row['Product_Id']; ?>">
                                <?php echo $row['Product_Name']; ?>
                            </a>
                        </h5>
                        <p class="card-text">Preço: R$<?php echo $row['Product_Price']; ?></p>
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
