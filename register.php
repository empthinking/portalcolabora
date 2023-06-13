<?php
require_once 'db.php';

if (isUserLoggedIn()) {
    header('index.php');
    exit();
}

$name = $password = $password_confirm = $email = $number = $gender = $user_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = validateData($_POST['name']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);
    $email = validateData($_POST['email']);
    $number = validateData($_POST['number']);
    $gender = validateData($_POST['gender']);
    $user_type = validateData($_POST['user_type']);

    $error = array();

    $isEmailRegistered = function () use ($email, $db) : bool {
        $stmt = $db->prepare("SELECT * FROM Users WHERE User_Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    };

    if(empty($name)) $error['name'] = 'Campo precisa ser preenchido';
    elseif(!preg_match('/^[a-zA-Z ]+$/', $name)) $error['name'] = 'Nome não deve conter números ou caracteres especiais';

    if(empty($password)) $error['password'] = 'Campo precisa ser preenchido';
    elseif(strlen($password) < 8) $error['password'] = 'Senha precisa conter pelo menos 8 caracteres';

    if(empty($password_confirm)) $error['password_confirm'] = 'Campo precisa ser preenchido';

    if(empty($email)) $error['email'] = 'Campo precisa ser preenchido';
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error['email'] = 'Formato de email inválido';
    elseif($isEmailRegistered()) $error['email'] = 'Email já registrado';

    if(empty($number)) $error['number'] = 'Campo precisa ser preenchido';
    elseif(!preg_match('/^[0-9]+$/', $number)) $error['number'] = 'Campo não deve conter letras ou caracteres especiais';

    if(empty($gender)) $error['gender'] = 'Campo precisa ser preenchido';

    if(empty($user_type)) $error['user_type'] = 'Campo precisa ser preenchido';

    if($password !== $password_confirm) $error['password_confirm'] = true;

    if($user_type !== 'vendedor' && $user_type !== 'cliente' && $user_type !== 'admin') $error['user_type'] = true;



    if (count($error) === 0) {
            
                $sql_prep = "INSERT INTO Users(User_Name, User_Email, User_Password, User_Number, User_Gender, User_Type) VALUES(?, ?, ?, ?, ?, ?)";
                $stmt = $db->prepare($sql_prep);
                $password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param('ssssss', $name, $email, $password, $number, $gender, $user_type);
                $stmt->execute();
                $db->close();
                
//Mensagem de registro concluido
require_once 'header.php'; 
echo <<<MSG
<div class="container">
    <div class="alert alert-success m-3 p-3">CADASTRO REALIZADO COM SUCESSO!</div>

      <div class="container mt-5">
        <div class="progress">
          <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
</div>

  <script>
    $(document).ready(function() {
      let progressBar = document.getElementById('progressBar');
      let width = 0;
      let interval = setInterval(increaseProgress, 30);

    function increaseProgress() {
        if (width >= 100) {
          clearInterval(interval);
          redirectToOtherPage(); // Call the redirection function
        } else {
          width++;
          progressBar.style.width = width + '%';
          progressBar.setAttribute('aria-valuenow', width);
          progressBar.innerHTML = width + '%';
        }
      }

      function redirectToOtherPage() {
        setTimeout(function() {
          window.location.href = 'index.php';
        }, 1000);
      }
    });
  </script>
MSG;
require_once 'footer.php';
                exit();
           
    }     
        
}

$url = htmlspecialchars(trim($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html> 
 <html lang="pt-br"> 
 <head> 
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <title>Cadastro</title> 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./img/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<style>
     body { 
           min-height: 100vh; 
           display: flex; 
           flex-direction: column; 
     } 
  
   </style> 
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
 <script src="https://kit.fontawesome.com/0280b9824e.js" crossorigin="anonymous"></script> 
 </head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Cadastro</h2>
        <form action="<?php echo $url; ?>" method="POST">
            <div class="form-group">
                <label for="name"><i class="fas fa-signature"></i> Nome:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
<span class="text-danger"><?php echo $error['name']??''; ?></span>            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                <span class="text-danger"><?php echo $error['email']??''; ?></span>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-key"></i> Senha (No mínimo 8 caracteres):</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
<span class="text-danger"><?php echo $error['password']??''; ?></span> </div>
            <div class="form-group">
                <label for="password_confirm"><i class="fas fa-key"></i> Confirmar senha:</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="<?php echo $password_confirm; ?>" required>
                <span class="text-danger" id="password_error"><?php echo $error['password_confirm']??''; ?></span>
            </div>
            <div class="form-group">
                <label for="number"><i class="fas fa-phone-square-alt"></i> Telefone:</label>
                <input type="tel" class="form-control" id="number" name="number"
                    value="<?php echo $number; ?>" required>
<span class="text-danger"><?php echo $error['number']??''; ?></span>
            </div>
            <div class="form-group">
                <label for="gender"><i class="fas fa-venus-mars"></i> Gênero:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="masculino" <?php if ($gender === 'masculino') echo 'checked'; ?> required>
                    <label class="form-check-label" for="gender_male">
                        Masculino
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="feminino" <?php if ($gender === 'feminino') echo 'checked'; ?>                        required>
                    <label class="form-check-label" for="gender_female">
                        Feminino
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender_nonbinary" value="naobinario" <?php if ($gender === 'naobinario') echo 'checked'; ?>                        required>
                    <label class="form-check-label" for="gender_nonbinary"  >
                        Não-Binário
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="user_type"><i class="fas fa-users"></i> Tipo de usuário:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="user_type" id="user_type_client" value="cliente" <?php if ($user_type === 'cliente') echo 'checked'; ?> required>
                    <label class="form-check-label" for="user_type_client">
                        Cliente
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="user_type" id="user_type_vendor" value="vendedor" <?php if ($user_type === 'vendedor') echo 'checked'; ?> required>
                    <label class="form-check-label" for="user_type_vendor">
                        Vendedor
                    </label>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" id="submit" class="btn btn-success"><i class="fas fa-plus-circle"></i>
                    Cadastrar</button>
                <a href="index.php" class="btn btn-danger"><i class="fas fa-undo"></i> Voltar</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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

<?php require_once 'footer.php'?>
