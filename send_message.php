<?php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the message details from the form
    $message_sender = $_SESSION['id'];
    $message_receiver = $vendor_id;
    $message_content = $_POST['content'];
    $message_product = $product_id;
    $message_date = date('Y-m-d H:i:s'); // Assuming you want to use the current date and time in datetime format


    $stmt = $db->prepare("INSERT INTO Messages (Message_Sender, Message_Receiver, Message_Content, Message_Product, Message_Date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisis", $message_sender, $message_receiver, $message_content, $message_product, $message_date);

    if ($stmt->execute()) {
        require_once 'header.php'; 
echo <<<MSG
<div class="container">
    <div class="alert alert-success m-3 p-3">MENSAGEM ENVIADA!</div>

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
      let interval = setInterval(increaseProgress, 10);

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
          window.location.href = 'produto.php?id=$id';
        }, 1000);
      }
    });
  </script>
MSG;
require_once 'footer.php';

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
    exit();
}

require_once 'header.php';
?>
    <div class="container mt-5">
        <h2>Enviar Mensagem</h2>
        <form method="POST" action="">

            <div class="form-group">
                <label>Conteúdo:</label>
                <textarea name="content" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Enviar</button>
           <a class="btn btn-danger" onclick="window.history.back()"><i class="fas fa-undo"></i> Voltar</a>
        </form>
    </div>

<?php require_once 'footer.php';
