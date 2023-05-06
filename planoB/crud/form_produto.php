<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Define o ID do usuário como a variável $usuario_id
$usuario_id = $_SESSION["usuario_id"];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Cadastro de Produto</title>
</head>
<body>
	<h1>Cadastro de Produto</h1>
	<form action="adicionar_produto.php?usuario_id=<?php echo $usuario_id ?>" method="post" enctype="multipart/form-data">
		<label for="nome">Nome:</label>
		<input type="text" name="nome" id="nome" required><br><br>
		
		<label for="descricao">Descrição:</label>
		<textarea name="descricao" id="descricao" required></textarea><br><br>
		
		<label for="preco">Preço:</label>
		<input type="number" name="preco" id="preco" step="0.01" required><br><br>
		
		<label for="imagem">Imagem:</label>
		<input type="file" name="imagem" id="imagem" accept="image/jpeg,image/png" required><br><br>
		
		<input type="submit" value="Cadastrar">
	</form>
</body>
</html>
