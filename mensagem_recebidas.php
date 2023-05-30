<?php
// Verifica se o destinatário está definido
if (isset($_SESSION['id'])) {
    $destinatario = $_SESSION['id'];

    // Recuperar as mensagens do banco de dados para o destinatário
    $sql = "SELECT * FROM contatos WHERE destinatario = $destinatario";
    $result = $conn->query($sql);

    // Array para armazenar as mensagens
    $mensagens = array();

    // Contador de mensagens não lidas
    $mensagensNaoLidas = 0;

    // Verifica se existem mensagens
    if ($result->num_rows > 0) {
        // Loop através dos resultados do banco de dados
        while ($row = $result->fetch_assoc()) {
            $mensagens[] = $row;

            // Verifica se a mensagem não foi lida
            if ($row['lida'] == 0) {
                $mensagensNaoLidas++;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exibir Mensagens</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .message-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message-card.unread {
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Lista de Mensagens</h1>

        <?php if (isset($mensagens) && count($mensagens) > 0): ?>
            <?php foreach ($mensagens as $mensagem): ?>
                <div class="message-card <?php echo $mensagem['lida'] == 0 ? 'unread' : ''; ?> bg-white rounded p-4 mb-4">
                    <p class="mb-2"><span class="font-semibold">Remetente:</span> <?php echo $mensagem['remetente']; ?></p>
                    <p class="mb-2"><span class="font-semibold">Destinatário:</span> <?php echo $mensagem['destinatario']; ?></p>
                    <p class="mb-2"><span class="font-semibold">Mensagem:</span> <?php echo $mensagem['mensagem']; ?></p>
                    <button class="text-red-500 font-semibold mt-2" onclick="apagarMensagem(<?php echo $mensagem['id']; ?>)">Apagar mensagem</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">Nenhuma mensagem encontrada para este destinatário.</p>
        <?php endif; ?>

        <?php if ($mensagensNaoLidas > 0): ?>
            <p class="mt-4">Mensagens não lidas: <?php echo $mensagensNaoLidas; ?></p>
        <?php else: ?>
            <p class="mt-4">Todas as mensagens foram lidas.</p>
        <?php endif; ?>
    </div>

    <script>
        function apagarMensagem(id) {
            // Aqui você pode adicionar a lógica para apagar a mensagem com o ID fornecido
            // por exemplo, fazendo uma requisição AJAX para um script PHP que realiza a exclusão no banco de dados.
            // Após apagar a mensagem, você pode recarregar a página ou atualizar a lista de mensagens.
        }
    </script>

