<?php
// Verifica se o destinatário está definido
if (isset($_SESSION['id'])) {
    $destinatario = $_SESSION['id'];

    // Recuperar as mensagens do banco de dados para o destinatário
    $sql = "SELECT * FROM contatos WHERE destinatario = $destinatario";
    $result = $conn->query($sql);

    // Array para armazenar as mensagens
    $mensagens = array();

    // Verifica se existem mensagens
    if ($result->num_rows > 0) {
        // Loop através dos resultados do banco de dados
        while ($row = $result->fetch_assoc()) {
            $mensagens[] = $row;
        }
    }
}
?>

    <style>
        .message-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Lista de Mensagens</h1>

    <?php if (isset($mensagens) && count($mensagens) > 0): ?>
        <?php foreach ($mensagens as $mensagem): ?>
            <div class="message-card">
                <p>Remetente: <?php echo $mensagem['remetente']; ?></p>
                <p>Destinatário: <?php echo $mensagem['destinatario']; ?></p>
                <p>Mensagem: <?php echo $mensagem['mensagem']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhuma mensagem encontrada para este destinatário.</p>
    <?php endif; ?>
