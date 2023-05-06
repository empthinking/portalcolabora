<?php
require_once "dbconn.php";
$sql = "SELECT * FROM produtos";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Lista de produtos</title>
</head>
<body>
	<h1>Lista de produtos</h1>
	<table>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>Preço</th>
			<th>Descrição</th>
			<th>Imagem</th>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)) { ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['nome']; ?></td>
				<td><?php echo $row['preco']; ?></td>
				<td><?php echo $row['descricao']; ?></td>
				<td><img src="<?php echo $row['imagem']; ?>" width="100px"></td>
			</tr>
		<?php } ?>
	</table>
	<a href="create.php">Adicionar produto</a>
</body>
</html>
