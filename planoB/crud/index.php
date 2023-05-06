<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
</head>
<body>
    <h1>Lista de Produtos</h1>
    <?php
    require_once "dbconn.php";

    $query = "SELECT * FROM produtos";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $nome = $row['nome'];
            $preco = $row['preco'];
            $descricao = $row['descricao'];
            $imagem = $row['imagem'];
    ?>
    <div>
        <?php if ($imagem != ""): ?>
        <img src="<?php echo $imagem ?>" alt="Imagem do Produto" width="200">
        <?php endif; ?>
        <h2><?php echo $nome ?></h2>
        <p>Preço: R$ <?php echo $preco ?></p>
        <p><?php echo $descricao ?></p>
        <p><a href="detalhes_produto.php?id=<?php echo $id ?>">Detalhes</a></p>
    </div>
    <?php
        }
    } else {
        echo "<p>Nenhum produto encontrado.</p>";
    }
    ?>
    <p><a href="login.php">Login</a> | <a href="cadastro.php">Cadastro</a></p>
</body>
</html>
