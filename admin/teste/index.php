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
    <form action="password_recovery.php" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <button type="submit" class="btn btn-primary">Recover Password</button>
    </form>
  </div>
</body>
</html>
