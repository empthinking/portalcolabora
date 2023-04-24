<?php

session_start();

require_once 'dbconn.php';

$email = $password = '';
$email_err = $password_err = $login_err = '';

try {

    if($_SERVER['REQUEST_METHOD'] == 'POST' && (!isset($_SESSION['login']) || $_SESSION['login'] !== false)){

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Check if email is empty
        if(empty($email)){
            throw new Exception('Email não pode ser vazio.');
        }

        // Check if password is empty
        if(empty($password)){
            throw new Exception('Senha não pode ser vazia.');
        }

        // If there are no errors, proceed with login
        if(empty($email_err) && empty($password_err)){

            // Prepare and execute the SQL statement
            $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE user_email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // If the user is found, check the password
            if($result->num_rows == 1){

                $row = $result->fetch_assoc();

                $id = $row['user_id'];
                $username_stored = $row['user_nome'];
                $password_stored = $row['user_senha'];
                $email_stored = $row['user_email'];
                $number_stored = $row['user_tel'];

                if(password_verify($password, $password_stored)){

                    // Set session variables
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username_stored;
                    $_SESSION['email'] = $email_stored;
                    $_SESSION['number'] = $number_stored;

                    // Regenerate session ID and set cookie parameters
                    session_regenerate_id(true);
                    $timeout = 1800; // 30 minutes
                    session_set_cookie_params($timeout);

                    // Close the prepared statement and free the result set
                    $stmt->close();
                    $result->free_result();

                    // Redirect to index.php
                    header('location: index.php');
                    exit();

                } else {
                    throw new Exception('Email ou senha inválidos.');
                }

            } else {
                throw new Exception('Email ou senha inválidos.');
            }

            // Close the prepared statement and free the result set
            $stmt->close();
            $result->free_result();

        }

        // Close the database connection
        $mysqli->close();

    }

} catch(Exception $e) {
    $login_err = $e->getMessage();
}

?>
