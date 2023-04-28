<?php

//estabelece a conexao com o banco de dados
//objeto $mysqli
require_once 'database.php';

//caso o usuario nao esteja logado, realiza o login e redireciona para a pagina principal
if(!isUserLoggedIn()):
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    
    //Prepara uma declaracao SQL
    $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE user_email = ?');

    //Adiciona a string de email na variavel '?'
    $stmt->bind_param('s', $email);

    //Executa a declaracao e checa se foi executada com sucesso
    if ($stmt->execute()):

        //cria um objeto contendo os resultados da requisicao
        $result = $stmt->get_result();
        
        //cria um array associativo contendo as informacoes obtidas
        $row = $result->fetch_assoc();

        //limpa os resultados do objeto
        $result->free_result();
    else: 
        //Em caso de falha, envia o respectivo erro
        throw new Exception($mysqli->error);
    endif;


    //Verifica se o usuario esta cadastrado e realiza o login
    if (password_verify($password, $row['user_senha'])):
        $_SESSION['login'] = true;
        $_SESSION['id'] = $row['user_id'];
        $_SESSION['username'] = $row['user_nome'];
        $_SESSION['email'] = $row['user_email'];
        $_SESSION['number'] = $row['user_tel'];

        //tempo limite ate a sessao expirar
        session_set_cookie_params(3600);

        //fecha a conexao com o banco de dados
        $stmt->close();
        $mysqli->close();

        //limpa o array
        $row = [];
    else:
        //em caso de falha a mensagem é jo
        throw new Exception('Nome de usuario ou senha não encontrado');
    endif;

    #Falta colocar a condição para fechar o banco, caso o contrario, ele fecha 2x.
    //$mysqli->close();
    header('location: index.php');

endif;

//fecha a conexao com o banco de dados
$mysqli->close();
?>

