<?php

//Checa se o usuario esta logado
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

#Executa o login
//Necessita do email, senha e uma instancia da classe Mysqli
function login(string $email, string $pwd, mysqli $conn): void {

    if(isset($_SESSION['login']) && $_SESSION['login'] === true) throw new Exception('Usuario já logado');
    //Filtra os dados
    if (!isset($email) || !isset($pwd)) throw new Exception('Campos de email e senha devem ser preenchidos');
    if (!isset($conn)) throw new Exception('Ausencia do objeto mysqli como parametro');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception ('Email em formato incorreto');
    if (strlen($pwd) < 8) throw new Exception('Senha deve conter pelo menos 8 caracteres');

    //Prepara uma declaracao SQL
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE user_email = ?');

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
        throw new Exception($conn->error);
    endif;

    //ID do usuario
    $id = $row['user_id'];

    //Verifica se o usuario esta cadastrado e realiza o login
    if (verify_password($pwd, $row['user_senha'])) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $row['user_id'];
        $_SESSION['username'] = $row['user_nome'];
        $_SESSION['email'] = $row['user_email'];
        $_SESSION['number'] = $row['user_tel'];

        //gera um novo ID para a sessao
        session_regenerate_id();

        //tempo limite ate a sessao expirar
        session_set_cookie_params(3600);

        //fecha a conexao com o banco de dados
        $stmt->close();
        $conn->close();

        //limpa o array
        $row = array();
    }
    else {
        //em caso de falha a mensagem é jo
        throw new Exception('Nome de usuario ou senha não encontrado');
    }
}

//Limpa os dados da sessao
function logout(): void {
    $_SESSION = array();
    session_destroy();
    exit;
}

?>
