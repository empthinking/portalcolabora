<?php
require_once 'db.php';

if (isUserLoggedIn()) {
    header('index.php');
    exit();
}

$name = $password = $password_confirm = $email = $number = $email_error = '';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = validateData($_POST['name']);
    $password         = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);
    $email            = validateData($_POST['email']);
    $number           = validateData($_POST['number']);

    $isEmailRegistered = function() use ($email, $db) : bool {
        $stmt = $db->prepare("SELECT * FROM Users WHERE User_Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    };

    $dataError = fn() =>
        (empty($name) || empty($password) || empty($password_confirm) || empty($email) || empty($number)) &&
        !filter_var($email, FILTER_VALIDATE_EMAIL) &&
        !preg_match('/^[a-bA-B1-9 ]$/', $name) &&
        $password !== $password_confirm &&
        strlen($password < 8);


    if ($dataError() === false) {
        if($isEmailRegistered() === false) {
            $sql_prep = "INSERT INTO Users(User_Name, User_Email, User_Password, User_Number) VALUES(?, ?, ?, ?)";
            $stmt = $db->prepare($sql_prep);
            $stmt->bind_param('ssss',$name, $email, password_hash($password, PASSWORD_DEFAULT), $number);
            $stmt->execute();
            echo "<p>Cadastro Realizado</p><a href='index.php'><button>página inicial</button></a>";
            $db->close();
            exit(); 
        } else {
            $email_error = 'Email já registrado';
        }
    }

} 

$url = htmlspecialchars(trim($_SERVER['PHP_SELF']));
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Cadastro</h2>
    <form action="<?php echo $url; ?>" method="POST">
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" pattern="^[a-zA-Z]+$" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" value="<?php echo $email; ?>" required>
            <span class="text-danger"><?php echo $email_error; ?></span>
        </div>
        <div class="form-group">
            <label for="password">Senha (No mínimo 8 caracteres):</label>
            <input type="password" class="form-control" id="password" name="password" pattern=".{8,}" value="<?php echo $password; ?>" required>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirmar senha:</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" pattern=".{8,}" value="<?php echo $password_confirm; ?>" required>
            <span class="text-danger" id="password_error"></span>
        </div>
        <div class="form-group">
            <label for="number">Telefone:</label>
            <input type="tel" class="form-control" id="number" name="number" pattern=".{11}" value="<?php echo $number; ?>" required>
        </div>
        <div class="text-center">
            <button type="submit" id="submit" class="btn btn-success">Cadastrar</button>
            <a href="index.php" class="btn btn-link">Voltar</a>
        </div>
    </form>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirm');
    const passwordError = document.getElementById('password_error');
    const submitInput = document.getElementById('submit');

    function checkPasswordMatch() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            passwordError.textContent = 'As senhas não correspondem.';
            submitInput.disabled = true;
        } else {
            passwordError.textContent = '';
            submitInput.disabled = false;
        }
    }

    passwordInput.addEventListener('input', checkPasswordMatch);
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
</script>

</body>
</html>

