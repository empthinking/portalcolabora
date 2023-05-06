<?php
session_start();
require_once "dbconn.php";

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define as informações do produto a partir dos dados do formulário
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $usuario_id = $_SESSION["usuario_id"];

    // Verifica se foi enviada alguma imagem
    if (!empty($_FILES["imagem"]["name"])) {
        // Define o caminho para salvar a imagem no servidor
        $nome_imagem = uniqid() . "_" . $_FILES["imagem"]["name"];
        $caminho_imagem = "uploads/" . $nome_imagem;

        // Move o arquivo para o diretório de uploads
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_imagem);
    } else {
        // Define um valor padrão para a imagem, caso não tenha sido enviada nenhuma
        $nome_imagem = "";
        $caminho_imagem = "";
    }

    // Insere o novo produto no banco de dados
    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem_nome, imagem, usuario_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdssi", $nome, $descricao, $preco, $nome_imagem, $caminho_imagem, $usuario_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redireciona o usuário de volta para a página de listagem de produtos
    header("Location: meus_produtos.php");
    exit();
}

include "form_produto.php";
?>
