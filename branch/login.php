<?php

require_once 'db.php';

session_start();

if(isUserLoggedIn()) header('Location: index.php');

$password = $email = $error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email     = validateData($_POST['email']);
    $password  = htmlspecialchars($_POST['password']);

    $getUserByEmail = function() use ($email, $db) : false | array {
        $stmt = $db->prepare("SELECT * FROM Users WHERE User_Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    };
        
    if(!($user = $getUserByEmail()) || !password_verify($password, $user['User_Password'])) {
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    .bg-header {
        background-color: rgb(99, 242, 83);
    }
    body {
            margin: 0;
            padding: 0;
            background-color: #000000;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            animation: slideAnimation 15s linear infinite;
        }

        @keyframes slideAnimation {
            0%, 33.33% {
                background-image: url(img/gliricidia.jpg);
                opacity: 1;
            }
            33.34%, 66.66% {
                background-image: url(img/GVI-Agriculture-800x443.png);
                opacity: 1;
            }
            66.67%, 100% {
                background-image: url(img/plantar-pimenta-do-reino-cursos-cpt.jpg);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="fundo">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 bg-white rounded-lg w-full max-w-md mx-auto p-8"">
                    <div class="text-center">
                        <img class="mx-auto" src="img/logo.png" width="323px" alt="logo">
                    </div>
                    <h2 class="mb-4 text-center">LOGIN</h2>
           
                    </form>
                </div>
            </div>
        </div>
    </div>
                                                                          <?php

$db->close();

require_once 'footer.php';
