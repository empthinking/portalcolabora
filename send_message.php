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
        echo "Mensagem enviada com sucesso.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
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
