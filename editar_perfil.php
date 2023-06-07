<?php
require_once 'db.php';

session_start();

if (!isUserLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
$user = getUserById($_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = validateData($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = 'Email e senha são obrigatórios.';
    } else {
        // Atualizar os dados do perfil do usuário no banco de dados
        $stmt = $db->prepare("UPDATE Users SET User_Email = ?, User_Password = ? WHERE User_Id = ?");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param('ssi', $email, $hashedPassword, $user['User_Id']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $user['User_Email'] = $email;
            $error = 'Perfil atualizado com sucesso.';
        } else {
            $error = 'Erro ao atualizar o perfil.';
        }

        $stmt->close();
    }
}

$url = htmlspecialchars(trim($_SERVER['PHP_SELF']));

?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .bg-header {
            background-color: rgb(99, 242, 83);
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .fundo {
            background-image: url('img/Fundo\ login.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="fundo">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center">
                        <img class="mx-auto" src="img/logo.png" width="323px" alt="logo">
                    </div>
                    <h2 class="mb-4 text-center">Editar Perfil</h2>
                    <h4 class="text-danger"><?php echo $error; ?></h4>
                    <form action="<?php echo $url; ?>" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="<?php echo $user['User_Email']; ?>"
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                        </div>
                        <div class="form-group">
                            <label for="password">Nova Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary m-3">Salvar</button>
                            <a href="index.php" class="btn btn-danger m-3">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
require_once 'footer.php';
?>
