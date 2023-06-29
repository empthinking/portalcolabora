<?php
// Database connection details
$servername = "127.0.0.1";
$username = "u871226378_admin";
$password = "Xq*4^5^1";
$dbname = "u871226378_Colabora";

// Initialize variables
$email = '';
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    $message = "Password recovery instructions sent to the email address.";
  } else {
    // Email doesn't exist in the database
    $message = "Email not found.";
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
}
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
      <?php if(!empty($message)): ?>
        <?php if($message === 'Password recovery instructions sent to the email address.'): ?>
          alert('Funciona');
        <?php elseif($message === 'Email not found.'): ?>
          alert('Email not found');
        <?php endif; ?>
      <?php endif; ?>
    });
  </script>
</head>
<body>
  <div class="container">
    <h2>Password Recovery</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email; ?>">
      </div>
      <button type="submit" class="btn btn-primary">Recover Password</button>
    </form>
    <?php if (!empty($message)): ?>
      <div class="mt-3">
        <?php if ($message === 'Password recovery instructions sent to the email address.'): ?>
          <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
          </div>
        <?php elseif ($message === 'Email not found.'): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
