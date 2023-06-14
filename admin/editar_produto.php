<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="bg-gray-200">
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

        // Verifica se novas imagens foram enviadas
        if (isset($_FILES["new_images"])) {
            // Lógica para manipular as novas imagens
            // Aqui você deve adicionar a lógica para manipular as novas imagens de acordo com sua necessidade
                
            // Exemplo de salvamento das novas imagens no servidor
            foreach ($_FILES["new_images"]["tmp_name"] as $key => $tmp_name) {
                $file_name = $_FILES["new_images"]["name"][$key];
                $file_tmp = $_FILES["new_images"]["tmp_name"][$key];
                $destination = "caminho/para/salvar/as/imagens/" . $file_name;
                move_uploaded_file($file_tmp, $destination);
                    
                // Insere a nova imagem no banco de dados
                // Aqui você deve adicionar a lógica para inserir a nova imagem no banco de dados de acordo com sua estrutura
                    
                // Exemplo de inserção da nova imagem usando PDO
                /*
                $pdo = new PDO("mysql:host=localhost;dbname=seu_banco_de_dados", "seu_usuario", "sua_senha");
                $query = "INSERT INTO imagens (produto_id, nome) VALUES (:produto_id, :nome)";
                $statement = $pdo->prepare($query);
                $statement->bindParam(":produto_id", $product_id);
                $statement->bindParam(":nome", $file_name);
                $statement->execute();
                */
            }
        }

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

    <div class="container mt-5">
        <h2>Editar Produto</h2>
        <form method="POST" enctype="multipart/form-data">
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
                <label for="new_images">Novas Imagens:</label>
                <input type="file" class="form-control-file" id="new_images" name="new_images[]" multiple accept="image/*">
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
                                        <input type="file" class="form-control-file" id="new_image_<?php echo $image['Image_Id']; ?>" name="new_images[]" accept="image/*">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" onclick="trocarImagem(<?php echo $image['Image_Id']; ?>)">Salvar</button>
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
                                        <p>Deseja realmente excluir essa imagem?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-danger" onclick="excluirImagem(<?php echo $image['Image_Id']; ?>)">Excluir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="listar_produtos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script>
        function trocarImagem(imageId) {
            var inputFile = document.getElementById("new_image_" + imageId);
            var formData = new FormData();
            formData.append("new_images[]", inputFile.files[0]);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "trocar_imagem.php?id=" + imageId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Imagem trocada com sucesso
                    location.reload();
                } else {
                    // Erro ao trocar a imagem
                    alert("Erro ao trocar a imagem");
                }
            };
            xhr.send(formData);
        }

        function excluirImagem(imageId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "excluir_imagem.php?id=" + imageId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Imagem excluída com sucesso
                    location.reload();
                } else {
                    // Erro ao excluir a imagem
                    alert("Erro ao excluir a imagem");
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
