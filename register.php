<?php
require_once 'db.php';

if (isUserLoggedIn()) {
    header('index.php');
    exit();
}

$name = $password = $password_confirm = $email = $number = $email_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = validateData($_POST['name']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);
    $email = validateData($_POST['email']);
    $number = validateData($_POST['number']);
    $gender = validateData($_POST['gender']);
    $user_type = validateData($_POST['user_type']);

    $error = false;

    $isEmailRegistered = function () use ($email, $db) : bool {
        $stmt = $db->prepare("SELECT * FROM Users WHERE User_Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    };

    if(empty($name) || empty($password) || empty($password_confirm) || empty($email) || empty($number) || empty($gender) || empty($user_type) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z ]+$/', $name) || $password !== $password_confirm || strlen($password) < 8 || ($user_type !== 'vendedor' && $user_type !== 'cliente' && $user_type !== 'admin'))
        $error = true;



    if ($error !== true) {
        if ($isEmailRegistered() === false) {
            $sql_prep = "INSERT INTO Users(User_Name, User_Email, User_Password, User_Number, User_Gender, User_Type) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql_prep);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ssssss', $name, $email, $password, $number, $gender, $user_type);
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
        <link rel="icon" type="image/x-icon" href="./img/favicon-32x32.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

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
            <label for="name"><i class="fas fa-signature"></i> Nome:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email:</label>
            <input type="email" class="form-control" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" value="<?php echo $email; ?>" required>
            <span class="text-danger"><?php echo $email_error; ?></span>
        </div>
        <div class="form-group">
            <label for="password"><i class="fas fa-key"></i> Senha (No mínimo 8 caracteres):</label>
            <input type="password" class="form-control" id="password" name="password" pattern=".{8,}" value="<?php echo $password; ?>" required>
        </div>
        <div class="form-group">
            <label for="password_confirm"><i class="fas fa-key"></i> Confirmar senha:</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" pattern=".{8,}" value="<?php echo $password_confirm; ?>" required>
            <span class="text-danger" id="password_error"></span>
        </div>
        <div class="form-group">
            <label for="number"><i class="fas fa-phone-square-alt"></i> Telefone:</label>
            <input type="tel" class="form-control" id="number" name="number" pattern=".{11}" value="<?php echo $number; ?>" required>
        </div>
        <div class="form-group">
            <label for="gender"><i class="fas fa-venus-mars"></i> Gênero:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="masculino" required>
                <label class="form-check-label" for="gender_male"> 
                    Masculino
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender_female" value="feminino" required>
                <label class="form-check-label" for="gender_female"> 
                    Feminino
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender_nonbinary" value="naobinario" required>
                <label class="form-check-label" for="gender_nonbinary"> 
                    Não-Binário
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="user_type"><i class="fas fa-users"></i> Tipo de usuário:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="user_type" id="user_type_client" value="cliente" required>
                <label class="form-check-label" for="user_type_client">
                    Cliente
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="user_type" id="user_type_vendor" value="vendedor" required>
                <label class="form-check-label" for="user_type_vendor">
                    Vendedor
                </label>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" id="submit" class="btn btn-success"><i class="fas fa-plus-circle"></i> Cadastrar</button>
            <a href="index.php" class="btn btn-danger"><i class="fal fa-undo"></i> Voltar</a>
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

  <?php require_once 'faq.php'?>
</body>
</html>
