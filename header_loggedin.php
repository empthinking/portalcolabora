<?php
require_once "dbconn.php";

$usuario_id = $_SESSION['id'] ?? null;
if ($usuario_id === null) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM usuarios WHERE user_id = $usuario_id";
$result = mysqli_query($conn, $query);
// Obtém as informações do usuário
$user = mysqli_fetch_assoc($result);
// Verifica se a foto de perfil está vazia
if ($user['user_imagem'] == null) {
    $caminho_imagem = "img/perfil.png";
} else {
    $caminho_imagem = $user['user_imagem'];
}

$permissao_publicar = $user['permissao_publicar'] ?? false;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Colabora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,300,0,0" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <style>
    .navbar {
        position: relative;
        z-index: 9999;
    }
    </style>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js">
    </script>
</head>

<body class="bg-gray-100">
    <nav class="navbar py-2">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 md:flex  md:items-center">
            <div class="flex items-center justify-between">
                <div>
                    <a class="" href="index.php">
                        <img src="img/Ativo 1 black.png" style="max-height: 3.75rem; max-width :10rem"
                            class="flex-shrink-0">
                    </a>
                </div>
                <div class="flex  navbar-toggle md:hidden">
                    <button type="button"  onclick="toggleMenu()"
                        class="navbarToggle text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600"
                        aria-label="toggle menu">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm16 4H4v2h16v-2z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- container dos conteúdos do hamburgue -->
            <div id="menu_hamb" class="navbar-menu md:flex items-center hidden">
                <div class="flex flex-col md:flex-row md:mx-6">
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900"
                        href="index.php">Início</a>
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900"
                        href="contato.php">Contato</a>
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="faq.php">FAQ</a>
                </div>
                <div class="flex items-center py-2 -mx-4 md:mx-4">
                    <form method="post" action="pesquisa.php">
                        <div class="relative mr-10 md:mx-0">
                            <input
                                class="bg-gray-200 rounded-full border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 pl-4 pr-10 py-2 w-40"
                                type="text" name="search" placeholder="Pesquisar...">
                            <button type="submit" class="absolute right-0 mt-2 mr-2">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="relative">
                    <div class="flex items-center cursor-pointer" onclick="toggleDropdown()">
                        <img src="<?php echo $caminho_imagem; ?>" alt="Imagem de Perfil"
                            class="w-10 h-10 rounded-full mr-2">
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                        <ul class="list-none">
                            <li class="px-4 py-2 hover:bg-gray-100"><a href="perfil.php">Perfil</a></li>
                            <li class="px-4 py-2 hover:bg-gray-100"><a href="historico.php">Histórico</a></li>
                            <?php if ($permissao_publicar) { ?>
                            <li class="px-4 py-2 hover:bg-gray-100"><a href="addproduto.php">Anunciar</a></li>
                            <?php } ?>
                            <li class="px-4 py-2 hover:bg-gray-100"><a href="logout.php">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById("dropdown-menu");
        dropdownMenu.classList.toggle("hidden");
    }
    var elementos = document.getElementsByClassName('navbar');
    var el = elementos[0];
    el.style.backgroundColor = '#63f253';

    // função para exibir e ocultar o conteúdo do botão hamburgue
    function toggleMenu() {
        var menu = document.getElementById('menu_hamb');
        if (menu.style.display === 'none') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }
    </script>
</body>

</html>