<?php
require_once 'db.php';

session_start();
?><!DOCTYPE html>
<html>
<head>
  <title>Editar Perfil</title>
  <link rel="stylesheet" href="style.css"> <!-- Arquivo CSS para estilização -->
</head>
<body>
  <h1>Editar Perfil</h1>

  <form action="atualizar_perfil.php" method="POST">
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" value="Nome atual" required>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="email@example.com" required>
    </div>

    <div class="form-group">
      <label for="numero">Número:</label>
      <input type="tel" id="numero" name="numero" value="123456789" required>
    </div>

    <button type="submit">Salvar</button>
  </form>

  <script src="script.js"></script> <!-- Arquivo JavaScript para interatividade -->
</body>
</html>

    <?php
require_once 'footer.php';
?>
