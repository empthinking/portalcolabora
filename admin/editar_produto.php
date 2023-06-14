<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login_admin.php");
    exit();
}

// Verificar se o usuário possui permissão de administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: acesso_negado.php");
    exit();
}

require_once "db.php";

// Verificar se o parâmetro 'id' está presente na URL
if (!isset($_GET['id'])) {
    header("Location: listar_produtos.php");
    exit();
}

$product_id = $_GET['id'];

// Verificar se o formulário foi enviado para atualizar o produto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter os dados do formulário
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $product_description = mysqli_real_escape_string($conn, $_POST["product_description"]);
    $product_price = mysqli_real_escape_string($conn, $_POST["product_price"]);

    // Atualizar as informações do produto no banco de dados
    $update_query = "UPDATE Products SET Product_Name = '$product_name', Product_Description = '$product_description', Product_Price = '$product_price' WHERE Product_Id = $product_id";
    mysqli_query($conn, $update_query);

    // Redirecionar de volta para a página listar_produtos.php após a atualização
    header("Location: listar_produtos.php");
    exit();
}

// Consultar o banco de dados para obter as informações do produto
$query = "SELECT * FROM Products WHERE Product_Id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Verificar se o produto foi encontrado
if (!$product) {
    header("Location: listar_produtos.php");
    exit();
}

// Obter as imagens do produto
$image_query = "SELECT * FROM Images WHERE Product_Id = $product_id";
$image_result = mysqli_query($conn, $image_query);
$images = mysqli_fetch_all($image_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
    <div class="container mt-5">
        <h2>Editar Produto</h2>
        <form method="POST">
            <div class="form-group">
                <label for="product_name">Nome do Produto:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['Product_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_description">Descrição do Produto:</label>
                <textarea class="form-control" id="product_description" name="product_description"><?php echo $product['Product_Description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="product_price">Preço do Produto:</label>
                <input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo $product['Product_Price']; ?>" required>
            </div>
            <div class="form-group">
                <label>Imagens do Produto:</label>
                <div class="row">
                    <?php foreach ($images as $image) { ?>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <img src="../<?php echo $image['Image_Name']; ?>" class="card-img-top" alt="Imagem do Produto">
                                <div class="card-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#imagemModal<?php echo $image['Image_Id']; ?>">Visualizar</a>
                                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#trocarImagemModal<?php echo $image['Image_Id']; ?>">Trocar</a>
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#excluirImagemModal<?php echo $image['Image_Id']; ?>">Excluir</a>
                                </div>
                            </div>
                        </div>
                        <!-- Modal de Visualização de Imagem -->
                        <div class="modal fade" id="imagemModal<?php echo $image['Image_Id']; ?>" tabindex="-1" role="dialog" aria-labelledby="imagemModal<?php echo $image['Image_Id']; ?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="../<?php echo $image['Image_Name']; ?>" class="img-fluid" alt="Imagem do Produto">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal de Troca de Imagem -->
                        <div class="modal fade" id="trocarImagemModal<?php echo $image['Image_Id']; ?>" tabindex="-1" role="dialog" aria-labelledby="trocarImagemModal<?php echo $image['Image_Id']; ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trocarImagemModal<?php echo $image['Image_Id']; ?>Label">Trocar Imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="trocar_imagem.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="image_id" value="<?php echo $image['Image_Id']; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <div class="form-group">
                        <input type="file" name="new_image" class="form-control-file" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Trocar</button>
                </form>
            </div>
        </div>
    </div>
</div>
                        <!-- Modal de Exclusão de Imagem -->
                       <div class="modal fade" id="excluirImagemModal<?php echo $image['Image_Id']; ?>" tabindex="-1" role="dialog" aria-labelledby="excluirImagemModal<?php echo $image['Image_Id']; ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excluirImagemModal<?php echo $image['Image_Id']; ?>Label">Excluir Imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir esta imagem?</p>
                <form action="excluir_imagem.php" method="POST">
                    <input type="hidden" name="image_id" value="<?php echo $image['Image_Id']; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
                    <?php } ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="listar_produtos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
