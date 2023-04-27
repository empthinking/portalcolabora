<?php
    function sign_up(mysqli $mysqli, string $name, string $email, string $pwd, string $num) {
        if(!isset($mysql))
            throw new Exception('Falha de conexao com o banco de dados');

        if (empty($name) || empty($email) || empty($pwd) || empty($num))
            throw new Exception("Todos os campos devem ser preenchidos");

        if (!preg_match('/^[a-zA-Z ]+$/', $name))
            throw new Exception("Nome deve conter apenas letras, numeros ou sublinhado apenas");

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Exception("Email invalido");

        if (strlen($password) < 8)
            throw new Exception("Senha deve conter 8 ou mais caracteres");

        //(xx)xxxxxxxxx[9 digitos apos o DDD]
        if (!preg_match("/^\([0-9]?[0-9]?\)[0-9]{9}/", $num))
            throw new Exception("Número em formato invalido");

        if (isset($id) && !filter_var($id, FILTER_VALIDATE_INT))
            throw new Exception("ID em formato invalido");
    

        //Verificacao de registro do email
        $stmt = $mysqli->prepare('SELECT user_email FROM usuarios WHERE user_email = ?');
        $stmt->bind_param('s', $user->get_email());
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_row > 0):
            throw new Exception('Email ja cadastrado');
        endif;

        $stmt = $mysqli->prepare('INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES(?, ?, ?, ?) WHERE user_id = ?');
        $stmt = bind_param('ssssi', $id);
        $stmt = execute();
        if($mysqli->error)
            throw new Exception($this ->mysqli ->error);
    $stmt->close();
    $mysqli->close();
    }
