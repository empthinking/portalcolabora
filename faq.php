<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <title>Colabora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.17/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

</head>

  <body class="bg-gray-100">
    <nav class="navbar shadow-lg">
        <div class="container px-6 py-4 mx-auto md:flex md:items-center">
                <div class="flex items-center justify-between">
                <div>
                    <a class="text-xl font-bold text-gray-800 md:text-2xl hover:text-gray-700" href="index.html">
                    <img src="img/Ativo 1 black.png" style="max-height: 3.75rem">
                    </a>
                </div>
                <div class="flex md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
                    <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm16 4H4v2h16v-2z"></path>
                    </svg>
                    </button>
                </div>
                </div>
                <div class="md:flex items-center">
                <div class="flex flex-col md:flex-row md:mx-6">
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="#">Início</a>
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="#">Produtos</a>
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="#">Contato</a>
                    <a class="my-1 text-gray-700 font-medium md:mx-4 md:my-0 hover:text-gray-900" href="#">FAQ</a>
                </div>
                <div class="flex items-center py-2 -mx-4 md:mx-4">
                    <div class="relative mr-10 md:mx-0">
                    <input class="bg-gray-200 rounded-full border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 pl-4 pr-10 py-2 w-80" type="text" placeholder="Pesquisar...">
                    <button class="absolute right-0 top-0 mt-3 mr-4">
                        <svg class="h-4 w-4 fill-current text-gray-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66667 12.6667C9.89961 12.6667 12.6667 9.89961 12.6667 6.66667C12.6667 3.43373 9.89961 0.666672 6.66667 0.666672C3.43373 0.666672 0.666672 3.43373 0.666672 6.66667C0.666672 9.89961 3.43373 12.6667 6.66667 12.6667ZM6.66667 11.3333C8.91693 11.3333 10.6667 9.58357 10.6667 6.66667C10.6667 3.74976 8.91693 2.00001 6.66667 2.00001C4.4164 2.00001 2.66667 3.74976 2.66667 6.66667C2.66667 9.58357 4.4164 11.3333 6.66667 11.3333Z"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6667 14L11.3333 10.6667L14.6667 7.33337L13.3333 6.00004L10 9.33337L6.66667 6.00004L5.33333 7.33337L8.66667 10.6667L5.33333 14L6.66667 15.3334L10 12.0001L13.3333 15.3334L14.6667 14Z"/>
                        </svg>
                    </button>
                    </div>
                </div>
                
                <div class="flex items-center ml-5">
                    <button href="#" class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full ml-4">Cadastrar</button>
                    <button  class="bg-green-200 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full ml-2" onclick="document.getElementById('singIn').style.display='block'">Entrar</button>
                        <div id="singIn" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen">
                            <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
                                <h1 class="text-3xl font-bold mb-8 text-center">Login</h1>
                                <form  method="POST" action="home">
                                <div class="mb-4 form-group" method="POST" action="home">
                                    <label class="block font-bold mb-2" for="email">
                                    Email
                                    </label>
                                    <input class="appearance-none border border-gray-300 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" placeholder="exemplo@exemplo.com" id="email">
                                </div>
                        
                                <div class="mb-6 form-group">
                                    <label class="block font-bold mb-2" for="password">
                                    Senha
                                    </label>
                                    <input class="appearance-none border border-gray-300 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******" id="senha">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                        
                                <div class="flex items-center justify-between">
                                    <button type="submit"class="bg-green-200 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                    Entrar
                                    </button>
                                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
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
                </div>
                </div>
        
    </nav>
    
<main>
  <section class="bg-gray-100 py-12">
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Perguntas frequentes</h1>
    <h2 class="text-lg font-medium mb-8">Aqui estão algumas das perguntas mais frequentes que recebemos.</h2>

    <div class="border-t border-gray-300 py-8">
      <div class="mb-4">
        <h3 class="text-lg font-medium mb-2">Como faço para fazer uma compra?</h3>
        <p class="text-gray-600">Para fazer uma compra, basta se cadastrar em nossa loja, escolher os produtos desejados e finalizar a compra seguindo as instruções na tela.</p>
      </div>

      <div class="mb-4">
        <h3 class="text-lg font-medium mb-2">Quais são as formas de pagamento disponíveis?</h3>
        <p class="text-gray-600">Aceitamos pagamentos com cartão de crédito, boleto bancário e transferência bancária.</p>
      </div>

      <div class="mb-4">
        <h3 class="text-lg font-medium mb-2">Qual é o prazo de entrega?</h3>
        <p class="text-gray-600">O prazo de entrega pode variar de acordo com a região e a forma de envio escolhida. Consulte as informações na tela de finalização da compra.</p>
      </div>
    </div>
  </div>
</section>

  
</main>
  </body>
  </html>