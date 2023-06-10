<?php 
$id = $_SESSION['id']??'';

if(isUserLoggedIn()) {
    $welcome = 'Bem-Vind';
    if($_SESSION['gender'] === 'feminino')
        $welcome .= 'a';
    else if($_SESSION['gender'] === 'masculino')
        $welcome .= 'o';
    else
        $welcome .= 'e';
}

$checkUnreadMessages = function() use ($id, $db) : bool {
    $stmt = $db->prepare('SELECT Message_Id FROM Messages WHERE Message_Receiver = ? AND Message_Readed = 0');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PortalColabora</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="./img/favicon-32x32.png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    .bg-header {
      background-color: rgb(99, 242, 83);
    }
    body {
          min-height: 100vh;
          display: flex;
          flex-direction: column;
    }

  </style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-header">
      <a class="navbar-brand" href="index.php">
        <img src="img/logo.png" alt="Your Logo" width="200">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <!-- Display navigation options for logged-in user -->
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Início</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contato.php">Contato</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="faq.php">FAQs</a>
            </li>
          </ul>
          <form id="search-form" action="index.php" method="GET" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" name="search" type="search" placeholder="Pesquisar..." aria-label="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> Pesquisar</button>
          </form>

    <!--Carrega em caso do usuario esteja logado -->
    <?php if (isset($welcome)): ?>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userMenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo "$welcome, {$_SESSION['username']}"; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
                    <a class="dropdown-item" href="perfil.php">Perfil</a>
                    <?php if($_SESSION['type'] === 'vendedor'): ?> 
                    <a class="dropdown-item" href="meusprodutos.php">Meus Produtos</a>
                    <a class="dropdown-item <?php echo $checkUnreadMessages() ? 'text-danger font-weight-bold' : ''; ?>" href="mensagens.php">Mensagens</a>
                    <?php endif; ?>
               <!--     <a class="dropdown-item" href="#">Configuração</a> -->
                    <a class="dropdown-item" href="logout.php">Sair</a>
                </div>
            </li>
        </ul>
    <?php else: ?>
    <!-- -->

<!-- Padrão para usuario não logados -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="login.php"><i class="far fa-right-to-bracket"></i> Entrar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="register.php"><i class="far fa-address-card"></i>
 Cadastre-se</a>
    </li>
</ul>
<?php endif; ?>
<!-- -->
      </div>
    </nav>
  </header>
<!-- Header End -->
