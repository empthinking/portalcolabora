/*$username = $email = $password = $confirm_password = $cellphone = '';
$error_msg = '';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(empty($_POST['username'])){
        $error_msg .= 'Insira um nome de usuário válido.<br>';
    } else {
        $username = $_POST['username'];
    }
    
    if(empty($_POST['email'])){
        $error_msg .= 'Insira um endereço de e-mail válido.<br>';
    } else {
        $email = $_POST['email'];
    }
    
    if(empty($_POST['password'])){
        $error_msg .= 'Insira uma senha válida.<br>';
    } else {
        $password = $_POST['password'];
    }
    
    if(empty($_POST['confirm_password'])){
        $error_msg .= 'Insira a confirmação da senha.<br>';
    } else {
        $confirm_password = $_POST['confirm_password'];
    }
    
    if(empty($_POST['number'])){
        $error_msg .= 'Insira um número de telefone válido.<br>';
    } else {
        $cellphone = $_POST['number'];
    }

    if(empty($error_msg)){
        try{
            if($password !== $confirm_password){ //Confirmação da senha
                throw new Exception('Insira corretamente a confirmação');
            } else {
                $stmt = $mysqli->prepare('INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES(?, ?, ?, ?)');
                $stmt->bind_param('sssi', $username, $email, $password_hash, $cellphone);
                $stmt->execute();
                if($mysqli->error){
                    throw new Exception($this ->mysqli ->error);
                } else {
                    header('location: index.php');
                    $_SESSION['success_msg'] = 'Registro completado com sucesso';
                }
                $stmt->close();
                $mysqli->close();
            }
        } catch(Exception $error) {
            $error_msg = $error->getMessage();
        }
    }
}

if(!empty($error_msg)){
    $_SESSION['error_msg'] = $error_msg;
}
*/