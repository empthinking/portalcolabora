<?php
// Atualiza o status de leitura das mensagens
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $mensagem_id = $_POST['mensagem_id'];
  $usuario_id = $_SESSION['id'];

  $sql = "UPDATE contatos SET lido = 1 WHERE id = $mensagem_id AND destinatario = $usuario_id";

  if ($conn->query($sql) === true) {
    echo "Status de leitura atualizado.";
  } else {
    echo "Erro ao atualizar o status de leitura: " . $conn->error;
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
}

// Consulta as mensagens recebidas
$usuario_id = $_SESSION['id'];

$sql = "SELECT c.id, c.remetente, c.mensagem, c.lido, p.nome, p.imagem
        FROM contatos c
        INNER JOIN produtos p ON c.produto_id = p.id
        WHERE c.destinatario = $usuario_id
        ORDER BY c.id DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $mensagem_id = $row['id'];
    $remetente = $row['remetente'];
    $mensagem = $row['mensagem'];
    $lido = $row['lido'];
    $produto_nome = $row['nome'];
    $produto_imagem = $row['imagem'];

    // Formata o status de leitura
    $status_leitura = $lido ? "Lido" : "<strong>Não lido</strong>";

    // Exibe as informações da mensagem
    echo "<div>";
    echo "<h3>Remetente: $remetente</h3>";
    echo "<p>Produto: $produto_nome</p>";
    echo "<img src=\"$produto_imagem\" alt=\"Imagem do Produto\" width=\"100\">";
    echo "<p>$mensagem</p>";
    echo "<p>Status de leitura: $status_leitura</p>";

    // Botão para marcar a mensagem como lida
    if (!$lido) {
      echo "<form method=\"POST\" action=\"mensagem_recebidas.php\">";
      echo "<input type=\"hidden\" name=\"mensagem_id\" value=\"$mensagem_id\">";
      echo "<button type=\"submit\">Marcar como lido</button>";
      echo "</form>";
    }

    echo "</div>";
  }
} else {
  echo "Nenhuma mensagem recebida.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
