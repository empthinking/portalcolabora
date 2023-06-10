<?php

require_once 'db.php';

session_start();

if (isUserLoggedIn()) header('Location: index.php');

$password = $email = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email     = validateData($_POST['email']);
    $password  = htmlspecialchars($_POST['password']);

    $getUserByEmail = function () use ($email, $db): false | array {
        $stmt = $db->prepare("SELECT * FROM Users WHERE User_Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    };

    if (!($user = $getUserByEmail()) || !password_verify($password, $user['User_Password'])) {
        $error = 'Email ou Senha não encontrados';
    } else {
        $_SESSION['login']     = true;
        $_SESSION['username']  = $user['User_Name'];
        $_SESSION['id']        = $user['User_Id'];
        $_SESSION['type']      = $user['User_Type'];
        $_SESSION['gender']    = $user['User_Gender'];

        $db->close();

        header('Location: index.php');
        exit();
    }
}

$url = htmlspecialchars(trim($_SERVER['PHP_SELF']));

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon-32x32.png">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .fundo {
        background-image: url(./img/GVI-Agriculture-800x443.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        height: 100vh;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.5);
        padding: 20px;
        margin: 20px;
        border-radius: 10px;
    }

    @media screen and (max-width: 600px) {
        .card {
            height: 80vh;
            width: 75vw;
            background-color: red;
        }
    }
    </style>
</head>

<body>
    <div class="fundo">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="text-center">
                        <img class="mx-auto" src="img/logo.png" width="323px" alt="logo">
                    </div>
                    <h2 class="mb-4 text-center">LOGIN</h2>
                    <h4 class="text-danger"><?php echo $error; ?></h4>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="<?php echo $email; ?>"
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password"
                                value="<?php echo $password; ?>" required>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary m-3">Entrar</button>
                            <a href="index.php" class="btn btn-danger m-3">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php

    $db->close();

    require_once 'footer.php';