<?php
// Database connection details
$servername = "127.0.0.1";
$username = "u871226378_admin";
$password = "Xq*4^5^1";
$dbname = "u871226378_Colabora";

// Retrieve email from the form
$email = $_POST['email'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query to check if email exists in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the email exists in the database
if ($result->num_rows > 0) {
  // Email exists, send password recovery instructions to the user
  // Add your code to send the password recovery instructions via email here

  // Redirect to password_recovery.html with success message
  header("Location: password_recovery.html?message=success");
  exit();
} else {
  // Email doesn't exist in the database
  // Redirect to password_recovery.html with not found message
  header("Location: password_recovery.html?message=not_found");
  exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <title>Password Recovery</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      <?php if(isset($_GET['message'])): ?>
        <?php if($_GET['message'] === 'success'): ?>
          alert('Funciona');
        <?php elseif($_GET['message'] === 'not_found'): ?>
          alert('Email not found');
        <?php endif; ?>
      <?php endif; ?>
    });
  </script>
</head>
<body>
  <div class="container">
    <h2>Password Recovery</h2>
    <form action="index.php" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <button type="submit" class="btn btn-primary">Recover Password</button>
    </form>
  </div>
</body>
</html>
