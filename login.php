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
        $_SESSION['login_error'] = 'Email ou senha não encontrado';
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
        $_SESSION['login_success'] = 'Login realizado com sucesso!';
    else:
        //em caso de falha a mensagem é jo
        //throw new Exception('Nome de usuario ou senha não encontrado');
        $_SESSION['login_error'] = 'Email ou senha não encontrado';
    endif;

    #Falta colocar a condição para fechar o banco, caso o contrario, ele fecha 2x.
    //$mysqli->close();
    header('location: index.php');

endif;

//fecha a conexao com o banco de dados
$mysqli->close();
?>

<?php
require_once 'header.php';
?>
<div class="flex items-center ml-5  w-1/5">
					<a href="cadastro.php"><button class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4">Cadastrar</button></a>
					<button class="bg-green-200 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('singIn').style.display='block'">Entrar</button>
					<div id="singIn" class="<?php echo isset($_SESSION['login_error']) ? 'block' : 'modal hidden fixed z-10 inset-0 overflow-y-auto'; ?>">
						<div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 bg-gray-900" style="opacity: 0.9;">
							<div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
								<h1 class="text-3xl font-bold mb-8 text-center">Login</h1>
								<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
									<div class="mb-4 form-group">
										<label class="block font-bold mb-2" for="email">
											Email
										</label>
										<input class="appearance-none border border-gray-300 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" placeholder="exemplo@exemplo.com" id="email" name="email">
									</div>
									<div class="mb-6 form-group">
										<label class="block font-bold mb-2" for="password">
											Senha
										</label>
										<input class="appearance-none border border-gray-300 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="password" id="senha" name="password">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</div>
									<div class="flex items-center justify-between">
										<button type="submit" class=" bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
											Entrar
										</button>
										<a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#####falta_fazer#####">
											Não consigo entrar
										</a>
									</div>
								</form>
								<button type="button" onclick="document.getElementById('singIn').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
									Cancelar
								</button>
							</div>
						</div>
					</div>
				</div>