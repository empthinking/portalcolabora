<?php
$servername = '127.0.0.1';
$user = 'u871226378_colabora';
$password = 'F7k|MYhYf>';
$db_name = 'u871226378_portalcolabora';
$port = 3306;

$mysqli = new mysqli($servername, $user, $password, $db_name, $port);
#Verificação de conexão
if ($mysqli -> connect_errno) {
  echo "Falha na conexão com o banco de dados ${mysqli->connect_error}";
  exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_nome = $_POST['user_nome'];
  $user_email = $_POST['user_email'];
  $user_senha = $_POST['user_senha'];
  $user_tel = $_POST['user_tel'];

  // Prepare and bind the query
  $stmt = $mysqli->prepare("INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $user_nome, $user_email, $user_senha, $user_tel);

  // Execute the query
  if ($stmt->execute()) {
    // Redirect to confirmation page
    header("Location: confirmation.php");
    exit();
  } else {
    echo "Erro ao inserir usuário: " . $mysqli->error;
  }

  // Close the statement and connection
  $stmt->close();
  $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>User Registration</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      padding: 20px;
    }
    form {
      background-color: #ffffff;
      border-radius: 5px;
      box-shadow: 0px 0px 5px 0px #888888;
      padding: 20px;
      max-width: 500px;
      margin: 0 auto;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    input[type=text], input[type=email], input[type=password], input[type=tel] {
      width: 100%;
      padding: 10px;
      border-radius: 3px;
      border: 1px solid #dddddd;
      margin-bottom: 20px;
    }
    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    input[type=submit]:hover {
      background-color: #3e8e41;
    }
  </style>
</head>
<body>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h2>User Registration</h2>
    <label for="user_nome">Name:</label>
    <input type="text" id="user_nome" name="user_nome" required>

    <label for="user_email">Email:</label>
    <input type="email" id="user_email" name="user_email" required>

    <label for="user_senha">Password:</label>
    <input type="password" id="user_senha" name="user_senha" required>

    <label for="user_tel">Phone:</label>
    <input type="tel" id="user_tel" name="user_tel" required>

    <input type="submit" value="Register">
  </form>
</body>
</html>
