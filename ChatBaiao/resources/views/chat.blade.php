<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Online</title>
</head>

<body>

    <h1>Chat Online</h1>

    <div id="chat">
        @foreach ($mensagens as $mensagem)
            <p><strong>{{ $mensagem->nome }}:</strong> {{ $mensagem->mensagem }} <br> {{ $mensagem->created_at }}</p>
        @endforeach
    </div>

    <form action="{{ route('chat.store') }}" method="post">
        @csrf
        <label>Nome:</label>
        <input type="text" name="nome" required><br><br>

        <label>Mensagem:</label>
        <input type="text" name="mensagem" required><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>

</html>
