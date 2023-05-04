<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'):	
	// Verifique se o nome de usuário está vazio
	if (empty(trim($_POST["email"]))): 
		$email_err = "Por favor, insira o e-mail.";
	// Verifique se a senha está vazia
	elseif (empty(trim($_POST["password"]))):
		$password_err = "Por favor, insira sua senha.";
	endif;
endif


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<title>Colabora</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/main.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,300,0,0" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
</head>

<body class="bg-gray-100">
	<nav class="navbar py-2">
		<div class="mx-auto px-4 sm:px-6 lg:px-8 md:flex  md:items-center justify-between w-full">
			<div class="flex items-center w-2/5">
				<div>
					<a class="" href="index.php">
						<img src="img/Ativo 1 black.png" style="max-height: 3.75rem; max-width :10rem" class="flex-shrink-0">
					</a>
				</div>
				<div class="flex flex-col md:flex-row md:mx-6 justify-start">
					<a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="index.php">Início</a>
					<a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="contato.php">Contato</a>
					<a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="faq.php">FAQ</a>
				</div>
				<div class="flex  navbar-toggle md:hidden">
					<button type="button" class="navbarToggle text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
						<svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm16 4H4v2h16v-2z"></path>
						</svg>
					</button>
				</div>
			</div>
			<div class="flex items-center w-3/5">

				<div class="flex items-center py-2 -mx-4 md:mx-4">
					<div class="relative mr-10 md:mx-0">
						<input class="bg-gray-200 rounded-full border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 pl-4 pr-10 py-2 w-9/10" type="text" placeholder="Pesquisar...">
						<button class="absolute right-0 mt-2 mr-2">
							<span class="material-symbols-outlined ">
								search
							</span>
						</button>
					</div>
				</div>
				<div class="flex items-center ml-5  w-1/5">
					<a href="cadastro.php"><button class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4">Cadastrar</button></a>

					<!-- Botão de login -->
					<button class="bg-green-200 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('singIn').style.display='block'">
						Entrar
					</button>
					<div id="singIn" class=" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): 
														isset($_SESSION['login_error']) ? 'block' : 'modal hidden fixed z-10 inset-0 overflow-y-auto'; 
														$_SESSION['login_error'] = true;
													endif;
												?>">
						<div class="flex items-center justify-center min-h-screen menu-overlay absolute inset-0 	bg-gray-900" style="opacity: 0.9;">
							<div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
								<h1 class="text-3xl font-bold mb-8 text-center">
									Login
								</h1>
								<!-- Formulário de login -->
								<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
									<div class="mb-4 form-group">
										<label class="block font-bold mb-2" for="email">
											Email:
										</label>	
										<input class="appearance-none border border-gray-300 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" placeholder="exemplo@exemplo.com" id="email" name="email" class="form-control">
										<?php if (isset($email_err)) { echo '<span>' . $email_err . '</span>'; } ?>

										
									</div>
									<div class="mb-6 form-group">
										<label class="block font-bold mb-2" for="password">
											Senha:<span><?php echo $password_err ?></span>
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
				<script>
					function toggleDropdown() {
						var dropdownMenu = document.getElementById("dropdown-menu");
						dropdownMenu.classList.toggle("hidden");
					}
					var elementos = document.getElementsByClassName('navbar');
					var el = elementos[0];
					el.style.backgroundColor = '#63f253';


					var btn = document.querySelector('.fa-eye')

					btn.addEventListener('click', () => {
						let inputSenha = document.querySelector('#senha')

						if (inputSenha.getAttribute('type') == 'password') {
							inputSenha.setAttribute('type', 'text')
						} else {
							inputSenha.setAttribute('type', 'password')
						}
					})
				</script>
			</div>
		</div>
	</nav>
	<script>
		var elementos = document.getElementsByClassName('navbar');
		var el = elementos[0];
		el.style.backgroundColor = '#63f253';

		let btn = document.querySelector('.fa-eye')



		// Seleciona o botão hamburger e o menu do navbar
		const navbarToggle = document.querySelector('.navbar-toggle');
		const navbarMenu = document.querySelector('.navbar-menu');

		// Adiciona um evento de clique no botão hamburger
		navbarToggle.addEventListener('click', () => {
			// Adiciona ou remove a classe 'show' do menu do navbar
			navbarMenu.classList.toggle('hidden');
		});



		btn.addEventListener('click', () => {
			let inputSenha = document.querySelector('#senha')

			if (inputSenha.getAttribute('type') == 'password') {
				inputSenha.setAttribute('type', 'text')
			} else {
				inputSenha.setAttribute('type', 'password')
			}
		})
	</script>


	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>