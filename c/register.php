<?php
require_once 'db.php';

if (isUserLoggedIn()) {
    header('index.php');
    exit();
}

$name = $password = $password_confirm = $email = $number = $email_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form submission and validation logic...

    // ...

}

$url = htmlspecialchars(trim($_SERVER['PHP_SELF']));
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media (max-width: 576px) {
            .form-group {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4">Cadastro</h2>
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
        <button type="submit" id="submit" class="btn btn-success">Cadastrar</button>
        <a href="index.php" class="btn btn-link mt-3">Voltar</a>
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
