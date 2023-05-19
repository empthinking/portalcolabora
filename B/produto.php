<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Detalhes do Produto</title>
</head>
<body>
<?php
// Função para obter produtos recomendados aleatoriamente
function getProdutosRecomendados($conn, $id, $limit = 3) {
    $query = "SELECT * FROM produtos WHERE id != $id ORDER BY RAND() LIMIT $limit";
    $result = mysqli_query($conn, $query);
    $produtos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }
    return $produtos;
}

// Verifica se foi passado um ID de produto válido na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Conecta ao banco de dados e faz a consulta para obter os detalhes do produto
    $conn = mysqli_connect('localhost', 'usuario', 'senha', 'meu_banco_de_dados');
    $id = $_GET['id'];
    $query = "SELECT * FROM produtos WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Verifica se a consulta retornou algum resultado
    if (mysqli_num_rows($result) > 0) {
        $produto = mysqli_fetch_assoc($result);
        ?>
        <h1><?php echo $produto['nome']; ?></h1>
        <p><?php echo $produto['descricao']; ?></p>
        <p>Preço: R$ <?php echo $produto['preco']; ?></p>
        <p>Quantidade em estoque: <?php echo $produto['estoque']; ?></p>
        <!-- Adicione aqui outros detalhes do produto que deseja exibir -->
        <?php

        // Obter produtos recomendados aleatoriamente
        $produtosRecomendados = getProdutosRecomendados($conn, $id);

        if (!empty($produtosRecomendados)) {
            ?>
            <h2>Produtos Recomendados</h2>
            <ul>
                <?php foreach ($produtosRecomendados as $recomendado) { ?>
                    <li><?php echo $recomendado['nome']; ?></li>
                    <!-- Adicione aqui os detalhes dos produtos recomendados que deseja exibir -->
                <?php } ?>
            </ul>
            <?php
        }
    } else {
        echo "Produto não encontrado.";
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
} else {
    echo "ID de produto inválido.";
}
?>
</body>
</html>
