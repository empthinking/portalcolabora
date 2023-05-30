<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Colabora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="navbar py-2">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 md:flex md:items-center justify-between">
            <div class="flex items-center">
                <div>
                    <a class="" href="index.php">
                        <img src="img/Ativo 1 black.png" style="max-height: 3.75rem; max-width :10rem" class="flex-shrink-0">
                    </a>
                </div>
                <div class="flex  navbar-toggle md:hidden">
                    <button type="button" class="navbarToggle text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm16 4H4v2h16v-2z"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-col md:flex-row md:mx-6">
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="index.php">Início</a>
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="contato.php">Contato</a>
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="faq.php">FAQ</a>
                </div>
            </div>
            <div class="flex items-center py-2 -mx-4 md:mx-4">
                <form method="post" action="pesquisa.php">
                    <div class="relative mr-10 md:mx-0">
                        <input class="bg-gray-200 rounded-full border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 pl-4 pr-10 py-2 w-120" type="text" name="search" placeholder="Pesquisar...">
                        <button type="submit" class="absolute right-0 mt-2 mr-2">
                            <i class="fas fa-search"></i>
                        </button>

                    </div>
                </form>
            </div>           
        </div>
    </nav>
    <script>
        var elementos = document.getElementsByClassName('navbar');
        var el = elementos[0];
        el.style.backgroundColor = '#63f253';

        var btn = document.querySelector('.toggle-password');
        btn.addEventListener('click', () => {
            let inputSenha = document.querySelector('#senha');
            if (inputSenha.getAttribute('type') === 'password') {
                inputSenha.setAttribute('type', 'text');
            } else {
                inputSenha.setAttribute('type', 'password');
            }
        });
    </script>
</body>

</html>