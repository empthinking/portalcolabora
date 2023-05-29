<?php
session_start();
require_once "dbconn.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  // Redireciona para a página de login se o usuário não estiver logado
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $destinatario = $_POST['destinatario'];
  $remetente = $_POST['remetente'];
  $produto_id = $_POST['produto_id'];
  $mensagem = $_POST['mensagem'];

  // Verifica se o destinatário é o vendedor do produto
  $sql = "SELECT usuario_id FROM produtos WHERE id = $produto_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $vendedor_id = $row['usuario_id'];

    if ($destinatario == $vendedor_id) {
      // Insere a mensagem na tabela de contatos
      $sql = "INSERT INTO contatos (destinatario, remetente, mensagem) VALUES ('$destinatario', '$remetente', '$mensagem')";

      if ($conn->query($sql) === true) {
        echo "Mensagem enviada com sucesso.";
      } else {
        echo "Erro ao enviar mensagem: " . $conn->error;
      }
    } else {
      echo "Destinatário inválido.";
    }
  } else {
    echo "Produto não encontrado.";
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
}
?>
