<?php
require_once "dbconn.php";
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"]; 

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];

    $query = "SELECT * FROM produtos WHERE id = '$id' AND usuario_id = '$usuario_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $query = "UPDATE produtos SET nome = '$nome', preco = '$preco', descricao = '$descricao' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Produto atualizado com sucesso!');window.location='read.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar produto!');</script>";
        }
    } else {
        echo "<script>alert('Você não tem permissão para editar este produto!');window.location='read.php';</script>";
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM produtos WHERE id = '$id' AND usuario_id = '$usuario_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $nome = $row['nome'];
        $preco = $row['preco'];
        $descricao = $row['descricao'];
    } else {
        echo "<script>alert('Você não tem permissão para editar este produto!');window.location='read.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <p>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $nome ?>">
        </p>
        <p>
            <label for="preco">Preço:</label>
            <input type="text" name="preco" value="<?php echo $preco ?>">
        </p>
        <p>
            <label for="descricao">Descrição:</label>
            <textarea name="descricao"><?php echo $descricao ?></textarea>
        </p>
        <p>
    <label for="imagem">Imagem:</label>
    <input type="file" name="imagem" accept="image/*">
    <?php if (isset($imagem) && $imagem != ""): ?>
    <br>
    <img src="<?php echo $imagem ?>" alt="Imagem do Produto" width="200">
    <?php endif; ?>
</p>

        <p>
            <button type="submit" name="submit">Atualizar Produto</button>
        </p>
    </form>
</body>
</html>
