<?php
require_once 'db.php';

session_start();
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
