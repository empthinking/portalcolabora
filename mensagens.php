<?php
session_start();

require_once 'db.php';

if(!isUserLoggedIn()) {
    header('Location: login.php');
    exit();
}

$markMessagesAsRead = fn($id) => $db->query("UPDATE Messages SET Message_Readed = 1 WHERE Message_Id = $id");

if(isset($_GET['id'])){
    $messageId = $_GET['id'];
    require_once 'message_details.php';
    exit();
}

    $result = $db->query("SELECT m.Message_Id, m.Message_Readed, p.Product_Name, m.Message_Date, u.User_Name FROM Messages m JOIN Users u ON m.Message_Sender = u.User_Id JOIN Products p ON p.User_Id = m.Message_Receiver WHERE m.Message_Receiver = {$_SESSION['id']}");

require_once 'header.php';
?>



  <!-- Main Content -->
  <main>
    <br>
    <br>
    <div class="container">
      <h1>Mensagens</h1>
      <br>
      <table class="table">
        <thead>
          <tr class="dark">
            <th>Remetente</th>
            <th>Produto</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <a href="<?php echo $_SERVER['PHP_SELF'] . "?id={$row['Message_Id']}"; ?>">
            <tr class="<?php echo $row['Message_Readed'] ? 'table-danger' : 'table-primary'; ?>">
              
              <td><?php echo $row['User_Name']; ?></td>
              <td><?php echo $row['Product_Name']; ?></td>
              <td><?php echo $row['Message_Date']; ?></td>
          
            </tr>
                    </a>
          <?php endwhile; ?>
        </tbody>
      </table>
        <a class="btn btn-danger" onclick="window.history.back()"><i class="fas fa-undo"></i> Voltar</a>
    </div>
  </main>
  <!-- Main Content End -->

<?php require_once 'footer.php';

