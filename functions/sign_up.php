<?php
    function sign_up(mysqli $mysqli, string $name, string $pwd, string $email, string $num, string $id = null) {
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

        if (!preg_match("/^\([0-9]?[0-9]?\)[0-9]{9}/", $num))
            throw new Exception("Número em formato invalido");

        if (isset($id) && !filter_var($id, FILTER_VALIDATE_INT))
            throw new Exception("ID em formato invalido");
	
        $stmt = $mysqli->prepare("INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES(?, ?, ?, ?) WHERE user_id = ?");
        $stmt = bind_param("ssssi", $id);
        $stmt = execute();
        if($mysqli->error)
            throw new Exception($this ->mysqli ->error);
	$stmt->close();
	$mysqli->close();
    }
