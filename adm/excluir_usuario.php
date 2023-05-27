<?php
session_start();

// Verifica se o usuário está logado como administrador
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redireciona para a página de login do administrador
    header("Location: login_admin.php");
    exit;
}

// Verifica se o ID do usuário a ser excluído foi fornecido
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Aqui você pode incluir a lógica para excluir o usuário do banco de dados
    // Substitua esta parte pelo código adequado para o seu projeto

    // Exemplo de código para excluir o usuário (substitua pelo seu próprio código)
    $conexao = mysqli_connect("127.0.0.1", "u871226378_colabora", "F7k|MYhYf>", "u871226378_portalcolabora");
    if ($conexao) {
        // Executa a query para excluir o usuário
        $query = "DELETE FROM usuarios WHERE user_id = $idUsuario";
        $resultado = mysqli_query($conexao, $query);

        if ($resultado) {
            // Usuário excluído com sucesso
            echo "Usuário excluído com sucesso.";
        } else {
            // Erro ao excluir o usuário
            echo "Erro ao excluir o usuário.";
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    } else {
        // Erro na conexão com o banco de dados
        echo "Erro na conexão com o banco de dados.";
    }
} else {
    // ID do usuário não fornecido, redireciona para uma página de erro ou para a página de listagem de usuários
    header("Location: listar_usuarios.php");
    exit;
}
