<?php
$sql_prep= 'SELECT m.Message_Sender, m.Message_Content, u.User_Name FROM Messages m JOIN Users u ON m.Message_Receiver = u.User_Id WHERE m.Message_Receiver = ? AND m.Message_Id = ?';
$stmt = $db->prepare($sql_prep);
$stmt->bind_param('ii', $_SESSION['id'], $messageId);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();
$result->close();
$stmt->close();


require_once 'header.php';

?>


<main>
    <div class="container">
      <h1>Mensagem</h1>
      <div>
        <h3>Remetente: <?php echo $message['sender']; ?></h3>
        <p><?php echo $message['content']; ?></p>
      </div>
    </div>
  </main>

<?php require_once 'footer.php';
