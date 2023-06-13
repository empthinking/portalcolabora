<?php

$name = $description = $price = '';

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!empty($name) || !empty($description) || !empty($price)) {
        $id = $_SESSION['id'];
        $date = date('Y-m-d H:i:s');

        // Insert product into the database
        $stmt = $db->prepare("INSERT INTO Products(Product_Name, Product_Description, Product_Price, Product_Date, User_Id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdsi', $name, $description, $price, $date, $id);

        if ($stmt->execute()) {
            // Retrieve the inserted product's ID
            $product_id = $stmt->insert_id;

            // Process the uploaded images
            if (!empty($_FILES['images']['name'][0])) {
                $image_dir = "img/{$id}/";
                if (!is_dir($image_dir)) {
                    mkdir($image_dir, 0755, true);
                }

                $uploaded_images = $_FILES['images'];
                $total_images = count($uploaded_images['name']);

                for ($i = 0; $i < $total_images; $i++) {
                    $image_name = uniqid() . '_' . $uploaded_images['name'][$i];
                    $image_path = $image_dir . $image_name;
                    

                    if (move_uploaded_file($uploaded_images['tmp_name'][$i], $image_path)) {
                        // Insert image into the database
                        $stmt = $db->prepare("INSERT INTO Images(Image_Name, Image_Date, User_Id, Product_Id) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param('ssii', $image_path, $date, $id, $product_id);
                        $stmt->execute();
                    }
                }
            }

            header('Location: meusprodutos.php');
        } else {
            echo "FAILED";
        }
        exit();
    }
}

require_once 'header.php';

$url = htmlspecialchars($_SERVER['PHP_SELF']) . '?mode=register';
echo <<<FORM
  <div class="container">
  <br>
  <br>
    <h1>Registrar</h1>
    <br>
    <br>
    <form action="$url" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Nome:</label>
        <input type="text" class="form-control" id="name" name="name" value="$name" required>
      </div>
      <div class="form-group">
        <label for="description">Descrição:</label>
        <textarea class="form-control" id="description" name="description" value="$description" required></textarea>
      </div>
      <div class="form-group">
        <label for="price">Preço:</label>
        <input type="number" class="form-control" id="price" name="price" value="$price" step="0.01" required>
      </div>
      <p>Imagens (Max. 5)</p>
      <div id="image-container">
        <div class="form-group">
          <label for="images">Imagem:</label>
          <input type="file" class="form-control-file" id="images" name="images[]" accept="image/*" multiple required>
        </div>
      </div>
      <div class="d-flex flex-column">
  <button type="button" class="btn btn-success" onclick="addImageField()">Adicionar</button>
  <button type="button" class="btn btn-danger" onclick="removeImageField()">Remover</button>
  <div class="d-flex mt-auto">
    <button type="submit" name="add_product" class="btn btn-primary">Registrar</button>
    <button type="submit" name="add_product" class="btn btn-danger ml-2" onclick="history.back()"><i class="fas fa-undo"></i> Voltar</button>
  </div>
</div>
</form>
  </div>
FORM;
?>
  <script>
      function addImageField() {
        let imageContainer = document.getElementById("image-container");
        if (imageContainer.childElementCount < 5) {
          let newImageField = document.createElement("div");
          newImageField.classList.add("form-group");
          newImageField.innerHTML = `
            <label for="images">Imagem:</label>
            <input type="file" class="form-control-file" name="images[]" accept="image/*">
          `;
          imageContainer.appendChild(newImageField);
        }
      }

      function removeImageField() {
        let imageContainer = document.getElementById("image-container");
        if (imageContainer.childElementCount > 1) {
          imageContainer.removeChild(imageContainer.lastElementChild);
        }
      }
  </script>
<?php require_once 'footer.php'; ?>
