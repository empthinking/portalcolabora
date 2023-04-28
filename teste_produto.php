<?php

define('SQL_PRODUCT_INSERT', 'INSERT INTO products(produto_nome, produto_descricao, produto_preco, produto_category, user_id) VALUES(?, ?, ?, ?, ?)');
//'ssdsi'

define('SQL_PRODUCT_SELECT', 'SELECT * FROM products WHERE user_id = ?');
//'i'

function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name = trim($_POST['name']);
  $desc = trim($_POST['description']);
  $price = trim($_POST['price']);
  $categ = trim($_POST['category']);
  
}

<!DOCTYPE html>
<html>
<head>
	<title>Product Register Form</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}
		
		form {
			background-color: #fff;
			padding: 20px;
			max-width: 600px;
			margin: 0 auto;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		}
		
		input[type=text], textarea, select {
			width: 100%;
			padding: 12px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			margin-top: 6px;
			margin-bottom: 16px;
			resize: vertical;
		}
		
		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
		
		input[type=submit]:hover {
			background-color: #45a049;
		}
		
		label {
			font-weight: bold;
			display: block;
			margin-bottom: 10px;
		}
		
		.container {
			background-color: #f2f2f2;
			padding: 20px;
			max-width: 600px;
			margin: 0 auto;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		}
		
		h1 {
			text-align: center;
			margin-top: 0;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Product Register Form</h1>
		<form action="submit_product.php" method="post">
			<label for="name">Product Name</label>
			<input type="text" id="name" name="name" placeholder="Enter product name" pattern="^[a-zA-Z_0-9]+$" required>
			
			<label for="description">Product Description</label>
			<textarea id="description" name="description" placeholder="Enter product description" required></textarea>
			
			<label for="price">Price</label>
			<input type="text" id="price" name="price" placeholder="Enter price (e.g. 9.99)" pattern="^\d+(\.\d{1,2})?$" required>
			
			<label for="category">Category</label>
			<select id="category" name="category" required>
				<option value="">Select a category</option>
				<option value="books">Books</option>
				<option value="electronics">Electronics</option>
				<option value="clothing">Clothing</option>
				<option value="home">Home &amp; Garden</option>
				<option value="toys">Toys &amp; Games</option>
			</select>
			
			<input type="submit" value="Submit">
		</form>
	</div>
</body>
</html>
