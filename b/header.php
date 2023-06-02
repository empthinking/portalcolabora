<?php 
if(isUserLoggedIn()) {
    $welcome = 'Bem-Vind';
    if($_SESSION['gender'] === 'feminino')
        $welcome .= 'a';
    else if($_SESSION['gender'] === 'masculino')
        $welcome .= 'o';
    else
        $welcome .= 'e';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PortalColabora</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
              <a class="nav-link" href="contact.php">Contato</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">FAQs</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar..." aria-label="Search">
            <button class="btn btn-primary my-2 my-sm-0" type="submit">Pesquisar</button>
          </form>

        <!--Carrega em caso do usuario esteja logado -->
        <?php if (isset($welcome)):?>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userMenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo "$welcome, {$_SESSION['username']}"; ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
                <a class="dropdown-item" href="#">Perfil</a>
<?php echo $_SESSION['type'] === 'vendedor' ? '<a class="dropdown-item" href="meusprodutos.php">Meus Produtos</a>' : ''; ?>
                <a class="dropdown-item" href="#">Configuração</a>
                <a class="dropdown-item" href="logout.php">Sair</a>
              </div>
            </li>
          </ul>
        <?php else: ?>
        <!-- -->

        <!-- Padrão para usuario não logados -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="login.php">Entrar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Cadastre-se</a>
            </li>
          </ul>
        <?php endif; ?>
        <!-- -->
      </div>
    </nav>
  </header>
<!-- Header End -->
