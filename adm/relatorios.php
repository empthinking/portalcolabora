<?php
session_start();
require_once "dbconn.php";

// Verificar se o administrador está logado
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: login_admin.php");
    exit();
}

// Função para gerar o relatório
function gerarRelatorio($conn) {
    $dataHora = date("Y-m-d H:i:s");

    // Consultar dados do banco de dados para os relatórios
    $sql = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalUsuarios = $row['total_usuarios'];

    $sql = "SELECT COUNT(*) AS total_produtos FROM produtos";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalProdutos = $row['total_produtos'];

    // Inserir o novo relatório no banco de dados
    $sql = "INSERT INTO relatorios (data_hora, total_usuarios, total_produtos) VALUES ('$dataHora', '$totalUsuarios', '$totalProdutos')";
    mysqli_query($conn, $sql);

    // Selecionar todos os relatórios do banco de dados
    $sql = "SELECT * FROM relatorios ORDER BY data_hora DESC";
    $result = mysqli_query($conn, $sql);
    $relatorios = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $relatorios;
}

// Processar o botão para gerar o relatório
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["gerar_relatorio"])) {
    $relatorios = gerarRelatorio($conn);
    $message = "Relatório gerado com sucesso!";
}

// Selecionar todos os relatórios do banco de dados
$sql = "SELECT * FROM relatorios ORDER BY data_hora DESC";
$result = mysqli_query($conn, $sql);
$relatorios = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerar Relatório</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Gerar Relatório</h2>
            <?php if (isset($message)): ?>
                <div class="bg-green-200 text-green-800 p-4 mb-4 rounded">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <button type="submit" name="gerar_relatorio"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gerar Relatório</button>
            </form>

            <h2 class="text-2xl font-bold mt-8">Relatórios Gerados</h2>
            <?php if (!empty($relatorios)): ?>
                <ul class="mt-4">
                    <?php foreach ($relatorios as $relatorio): ?>
                        <li class="mb-2">
                            <strong>Data e Hora:</strong> <?php echo $relatorio['data_hora']; ?><br>
                            <strong>Total de Usuários:</strong> <?php echo $relatorio['total_usuarios']; ?><br>
                            <strong>Total de Produtos:</strong> <?php echo $relatorio['total_produtos']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum relatório disponível.</p>
            <?php endif; ?>
            <br>
            <a href="#" onclick="history.back()" class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-9 rounded focus:outline-none focus:shadow-outline">
            Voltar
        </a>
        </div>
    </div>
</body>
</html>
