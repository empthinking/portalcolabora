<?php
session_start();
require_once "dbconn.php";

$usuario_id = $_SESSION["id"];

// Obtém as informações do usuário a partir do ID armazenado na sessão
$query = "SELECT * FROM usuarios WHERE user_id = $usuario_id";
$result = mysqli_query($conn, $query);

// Verifica se o usuário existe no banco de dados
if (mysqli_num_rows($result) != 1) {
    header("Location: logout.php");
    exit();
}

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $confirma_senha = isset($_POST['confirma_senha']) ? $_POST['confirma_senha'] : '';

    // Valida os campos do formulário
    $erros = array();
    if (empty($nome)) {
        $erros[] = "O campo Nome é obrigatório.";
    }
    if (empty($email)) {
        $erros[] = "O campo Email é obrigatório.";
    }
    if (!empty($senha) && strlen($senha) < 6) {
        $erros[] = "A senha deve ter pelo menos 6 caracteres.";
    }
    if ($senha != $confirma_senha) {
        $erros[] = "As senhas não conferem.";
    }

    // Verifica se foi enviada uma imagem
    $imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : null;
    $caminho_imagem = null;
    if (!empty($imagem)) {
        $nome_imagem = uniqid() . '-' . $imagem['name'];
        $caminho_imagem = 'uploads/' . $nome_imagem;
    }

    // Atualiza as informações do usuário no banco de dados
    if (count($erros) == 0) {
        $query = "UPDATE usuarios SET user_nome = '$nome', user_email = '$email'";
        if (!empty($senha)) {
            $query .= ", user_senha = '" . md5($senha) . "'";
        }
        if (!empty($caminho_imagem)) {
            $query .= ", user_imagem = '$caminho_imagem'";
        }
        $query .= " WHERE user_id = '$usuario_id'";
        $result = mysqli_query($conn, $query);

        // Verifica se a atualização foi bem-sucedida
        if ($result) {
            // Atualiza as informações do usuário na sessão
            $_SESSION["usuario_nome"] = $nome;

            // Verifica se foi enviada uma imagem
            if (!empty($imagem)) {
                // Move a imagem para o diretório de uploads
                move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_imagem);
            }

            // Exibe mensagem de sucesso
            $_SESSION["sucesso"] = "Edição realizada com sucesso!";

            // Redireciona o usuário para a página de perfil
            header("Location: perfil.php");
            exit();
        } else {
            $erro = "Erro ao atualizar informações.";
        }
    }
}

// Obtém as informações do usuário a partir do banco de dados
$query = "SELECT * FROM usuarios WHERE user_id = '$usuario_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

?>
<div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900">
<div class="bg-white rounded-lg w-full max-w-md mx-auto p-8" style="max-height: 90vh; overflow-y: auto;">

    <h1 class="text-2xl font-bold mb-4">Editar perfil</h1>

    <?php if (!empty($erros)) : ?>
      <ul class="list-disc list-inside mb-4">
        <?php foreach ($erros as $erro) : ?>
          <li><?php echo $erro; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if (!empty($erro)) : ?>
      <p class="text-red-500 mb-4"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="nome" class="block font-medium mb-2">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $row['user_nome']; ?>" class="border rounded py-2 px-3 w-full">
      </div>
      <div class="mb-4">
        <label for="email" class="block font-medium mb-2">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $row['user_email']; ?>" class="border rounded py-2 px-3 w-full">
      </div>
      <div class="mb-4">
        <label for="senha" class="block font-medium mb-2">Senha:</label>
        <input type="password" name="senha" id="senha" class="border rounded py-2 px-3 w-full">
      </div>
      <div class="mb-4">
        <label for="confirma_senha" class="block font-medium mb-2">Confirmar senha:</label>
        <input type="password" name="confirma_senha" id="confirma_senha" class="border rounded py-2 px-3 w-full">
      </div>
      <div class="mb-4">
        <?php if ($row['user_imagem']) : ?>
          <img src="<?php echo htmlentities($row['user_imagem']); ?>" alt="Imagem do perfil" width="150" height="150" class="mb-4">
          <label for="apagar_imagem" class="block font-medium mb-2">Apagar imagem:</label>
          <input type="checkbox" name="apagar_imagem" id="apagar_imagem" class="mr-2">
          <label for="imagem" class="block font-medium mb-2">Editar imagem:</label>
          <input type="file" name="imagem" id="imagem" class="mb-4">
        <?php else : ?>
          <label for="imagem" class="block font-medium mb-2">Imagem:</label>
          <input type="file" name="imagem" id="imagem" class="mb-4">
        <?php endif; ?>
      </div>
      <div>
        <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Salvar alterações</button>
      </div>
    </form>

    <button type="button" onclick="document.getElementById('editPerfil').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
        Cancelar
                </button>
            </div>
            </div>