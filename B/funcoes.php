<?php
function uploadImagem($imagem, $nome_imagem) {
    $caminho = "upload/" . $nome_imagem;
    move_uploaded_file($imagem["tmp_name"], $caminho);
    return $caminho;
}
function inserirProduto($nome, $descricao, $preco, $imagem, $imagem_nome, $usuario_id) {
    require_once "dbconn.php";
    $caminho_imagem = uploadImagem($imagem, $imagem_nome);
    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem, imagem_nome, usuario_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdssi", $nome, $descricao, $preco, $caminho_imagem, $imagem_nome, $usuario_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function listarProdutos() {
    require_once "dbconn.php";
    $sql = "SELECT * FROM produtos";
    $result = mysqli_query($conn, $sql);
    $produtos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }
    mysqli_free_result($result);
    mysqli_close($conn);
    return $produtos;
}
// Função para buscar os dados de um produto pelo ID
function buscarProdutoPorId($id) {
	require_once "dbconn.php";
	$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3306);

	$query = "SELECT id, nome, descricao, preco, imagem_nome FROM produtos WHERE id = '$id'";
	$resultado = mysqli_query($conn, $query);

	if (mysqli_num_rows($resultado) == 1) {
		$produto = mysqli_fetch_assoc($resultado);
		return $produto;
	} else {
		return false;
	}
}

// Função para atualizar os dados de um produto
function atualizarProduto($id, $nome, $descricao, $preco, $imagem, $imagem_nome) {
	require_once "dbconn.php";
	$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3306);

	// Verifica se a imagem do produto foi alterada
	if ($imagem["name"] != "") {
		// Remove a imagem antiga do servidor
		$produtoAntigo = buscarProdutoPorId($id);
		$imagemAntiga = $produtoAntigo["imagem_nome"];
		unlink("upload/$imagemAntiga");

		// Envia a nova imagem para o servidor
		move_uploaded_file($imagem["tmp_name"], "upload/$imagem_nome");

		// Atualiza os dados do produto no banco de dados
		$query = "UPDATE produtos SET nome = '$nome', descricao = '$descricao', preco = '$preco', imagem_nome = '$imagem_nome' WHERE id = '$id'";
	} else {
		// Atualiza os dados do produto no banco de dados sem alterar a imagem
		$query = "UPDATE produtos SET nome = '$nome', descricao = '$descricao', preco = '$preco' WHERE id = '$id'";
	}

	mysqli_query($conn, $query);
}

// Função para mostrar todos os produtos na página de edição
function mostrarProdutos() {
	require_once "dbconn.php";
	$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3306);

	$query = "SELECT id, nome FROM produtos";
	$resultado = mysqli_query($conn, $query);

	while ($produto = mysqli_fetch_assoc($resultado)) {
		echo "<option value='" . $produto["id"] . "'>" . $produto["nome"] . "</option>";
	}
}
// Limpa a entrada de dados recebidos por formulários
function limpar_entrada($entrada) {
    $entrada = trim($entrada);
    $entrada = stripslashes($entrada);
    $entrada = htmlspecialchars($entrada);
    return $entrada;
  }
  
  // Salva uma imagem enviada por um formulário
  function salvar_imagem($imagem) {
    // Verifica se o arquivo de imagem foi enviado com sucesso
    if ($imagem['error'] !== UPLOAD_ERR_OK) {
      return null;
    }
  
    // Verifica se a imagem é válida
    $tipo = exif_imagetype($imagem['tmp_name']);
    if ($tipo === false || ($tipo !== IMAGETYPE_JPEG && $tipo !== IMAGETYPE_PNG)) {
      return null;
    }
  
    // Define o caminho e o nome do arquivo de imagem
    $caminho = 'upload/';
    $nome_arquivo = uniqid() . '_' . $imagem['name'];
  
    // Salva a imagem no diretório de imagens
    if (move_uploaded_file($imagem['tmp_name'], $caminho . $nome_arquivo)) {
      return $caminho . $nome_arquivo;
    } else {
      return null;
    }
  }
  


  function listar_produtos_por_usuario($usuario_id) {
    include "conexao.php";

    $sql = "SELECT * FROM produtos WHERE usuario_id = $usuario_id";
    $result = mysqli_query($conn, $sql);

    $produtos = array();
    while ($row = mysqli_fetch_array($result)) {
        $produto = array(
            "id" => $row['id'],
            "nome" => $row['nome'],
            "descricao" => $row['descricao'],
            "preco" => $row['preco'],
            "imagem" => $row['imagem']
        );
        $produtos[] = $produto;
    }

    mysqli_close($conn);
    return $produtos;
}

?>