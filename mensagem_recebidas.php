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
        .message-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Lista de Mensagens</h1>

        <?php if (isset($mensagens) && count($mensagens) > 0): ?>
            <?php foreach ($mensagens as $mensagem): ?>
                <div class="message-card bg-white rounded p-4 mb-4">
                    <p class="mb-2"><span class="font-semibold">Remetente:</span> <?php echo $mensagem['remetente']; ?></p>
                    <p class="mb-2"><span class="font-semibold">Destinatário:</span> <?php echo $mensagem['destinatario']; ?></p>
                    <p class="mb-2"><span class="font-semibold">Mensagem:</span> <?php echo $mensagem['mensagem']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">Nenhuma mensagem encontrada para este destinatário.</p>
        <?php endif; ?>
    </div>
