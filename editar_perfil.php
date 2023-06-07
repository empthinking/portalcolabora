<?php
require_once 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se os campos do formulário estão definidos
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['numero'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $numero = $_POST['numero'];

        // Recupere o ID do usuário logado
        $userId = $_SESSION['id'];

        // Atualize os dados do usuário no banco de dados
        $stmt = $db->prepare('UPDATE Users SET Nome = ?, Email = ?, Numero = ? WHERE User_Id = ?');
        $stmt->bind_param('sssi', $nome, $email, $numero, $userId);
        $stmt->execute();
        $stmt->close();

        // Redirecione para a página de perfil
        header("Location: perfil.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Editar Perfil</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      padding: 20px;
    }
  </style>
</head>
<body>
  <h1>Editar Perfil</h1>

  <form action="atualizar_perfil.php" method="POST">
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" class="form-control" id="nome" name="nome" value="Nome atual" required>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" value="email@example.com" required>
    </div>

    <div class="form-group">
      <label for="numero">Número:</label>
      <input type="tel" class="form-control" id="numero" name="numero" value="123456789" required>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


    <?php
require_once 'footer.php';
?>
