<?php
session_start();
require_once "db.php";
// Consulta SQL para buscar os dados necessários para o relatório
$sql = "SELECT COUNT(*) AS total_usuarios FROM Users";
$resultado_usuarios = mysqli_query($conn, $sql);
$row_usuarios = mysqli_fetch_assoc($resultado_usuarios);
$total_usuarios = $row_usuarios['total_usuarios'];

$sql = "SELECT COUNT(*) AS total_produtos FROM Products";
$resultado_produtos = mysqli_query($conn, $sql);
$row_produtos = mysqli_fetch_assoc($resultado_produtos);
$total_produtos = $row_produtos['total_produtos'];

// Geração do relatório
$relatorio = "Relatório do Sistema:\n";
$relatorio .= "Data: " . date('Y-m-d H:i:s') . "\n";
$relatorio .= "Total de Usuários Registrados: " . $total_usuarios . "\n";
$relatorio .= "Total de Produtos Disponíveis: " . $total_produtos . "\n";

// Exibe o relatório na tela
echo "<pre>";
echo $relatorio;
echo "</pre>";

// Gera um arquivo de texto com o relatório
$nomeArquivo = 'relatorio.txt';
$file = fopen($nomeArquivo, 'w');
fwrite($file, $relatorio);
fclose($file);

echo "Relatório gerado com sucesso! <a href='$nomeArquivo'>Baixar</a>";
?>
