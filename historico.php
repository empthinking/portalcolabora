<?php
session_start();
require_once "header_loggedin.php";
require_once "dbconn.php";
require_once "funcoes.php";

function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

$usuario_id = $_SESSION['id'];

// Consulta o histórico de visualizações do usuário logado
$query = "SELECT p.nome, h.data_visualizacao FROM produtos p JOIN historico h ON p.id = h.produto_id WHERE h.usuario_id = $usuario_id ORDER BY h.data_visualizacao DESC";
$result = mysqli_query($conn, $query);
$produtos = array();
while ($row = mysqli_fetch_assoc($result)) {
    $produtos[] = $row;
}

// Verifica se o usuário possui histórico de visualizações
if (empty($produtos)) {
    echo "<div class='bg-white rounded-lg w-full max-w-md mx-auto p-8'>";
    echo "<h3 class='text-lg leading-6 font-medium text-gray-900'>Histórico de Visualizações</h3>";
    echo "<p>Você ainda não visualizou nenhum produto.</p>";
    echo "<button type='button' onclick='document.getElementById(\"meuHistorico\").style.display=\"none\"' class='bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full'>Fechar</button>";
    echo "</div>";
} else {
    echo "<div class='bg-white rounded-lg w-full max-w-md mx-auto p-8'>";
    echo "<h3 class='text-lg leading-6 font-medium text-gray-900'>Histórico de Visualizações</h3>";
    echo "<table>";
    echo "<tr><th>Nome do Produto</th></tr>";
    foreach ($produtos as $produto) {
        echo "<tr>";
        echo "<td>" . $produto['nome'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<div>";
    echo "<a href='index.php' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 m-4 px-4 rounded'> Página Inicial </a>";
    echo "<a href='javascript:history.back()' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Voltar</a></div>";
    echo "</div>";
}

mysqli_close($conn);
?>
