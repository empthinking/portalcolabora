<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <title>Colabora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.17/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="container px-6 py-4 mx-auto md:flex md:justify-between md:items-center">
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
                <div class="flex items-center py-2 -mx-1 md:mx-0">
                    <div class="relative mx-1 md:mx-0">
                    <input class="bg-gray-200 rounded-full border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 pl-4 pr-10 py-2 w-80" type="text" placeholder="Pesquisar...">
                    <button class="absolute right-0 top-0 mt-3 mr-4">
                        <svg class="h-4 w-4 fill-current text-gray-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66667 12.6667C9.89961 12.6667 12.6667 9.89961 12.6667 6.66667C12.6667 3.43373 9.89961 0.666672 6.66667 0.666672C3.43373 0.666672 0.666672 3.43373 0.666672 6.66667C0.666672 9.89961 3.43373 12.6667 6.66667 12.6667ZM6.66667 11.3333C8.91693 11.3333 10.6667 9.58357 10.6667 6.66667C10.6667 3.74976 8.91693 2.00001 6.66667 2.00001C4.4164 2.00001 2.66667 3.74976 2.66667 6.66667C2.66667 9.58357 4.4164 11.3333 6.66667 11.3333Z"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6667 14L11.3333 10.6667L14.6667 7.33337L13.3333 6.00004L10 9.33337L6.66667 6.00004L5.33333 7.33337L8.66667 10.6667L5.33333 14L6.66667 15.3334L10 12.0001L13.3333 15.3334L14.6667 14Z"/>
                        </svg>
                    </button>
                </div>
                
                <div class="flex items-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Cadastrar</button>
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md" onclick="document.getElementById('singIn').style.display='block'">Entrar</a>
                        <div id="singIn" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen">
                            <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
                                <h1 class="text-3xl font-bold mb-8 text-center">Login</h1>
                                <form>
                                <div class="mb-4">
                                    <label class="block font-bold mb-2" for="email">
                                    Email
                                    </label>
                                    <input class="appearance-none border border-gray-300 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" placeholder="exemplo@exemplo.com" id="email">
                                </div>
                        
                                <div class="mb-6">
                                    <label class="block font-bold mb-2" for="password">
                                    Senha
                                    </label>
                                    <input class="appearance-none border border-gray-300 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******" id="password">
                                </div>
                        
                                <div class="flex items-center justify-between">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                    Entrar
                                    </button>
                                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                                    Não consigo entrar
                                    </a>
                                </div>
                                </form>
                                <button type="button" onclick="document.getElementById('singIn').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                                Cancelar
                                </button>
                            </div>
                            </div>
                        </div>
                          
                </div>
                </div>
                </div>
        </div>
    </nav>
    <!-- fim do nav -->
    <div class="bg-primary text-white">
        <div class="container mx-auto py-16 px-4">
          <h1 class="text-4xl font-bold">Bem-vindo ao Colabora</h1>
          <p class="text-lg mt-4">Portal para auxiliar as vendas.</p>
        </div>
      </div>
      
      <!-- Filtro -->
<main class="container flex">
      <div class="container mx-auto py-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
          <div>
            <h2 class="text-lg font-bold mb-4">Filtros</h2>
            <hr class="mb-4">
            <h3 class="text-base font-bold mb-2">Categoria</h3>
            <div class="relative">
              <select class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>Todos</option>
                <option>Categoria 1</option>
                <option>Categoria 2</option>
                <option>Categoria 3</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.95 7.95a1 1 0 01-1.41 0L10 4.91 6.46 8.46a1 1 0 01-1.41-1.41l4-4a1 1 0 011.41 0l4 4a1 1 0 010 1.41z"/></svg>
              </div>
            </div>
            <br>
            <h3 class="text-base font-bold mb-2">Preço</h3>
            <div class="flex flex-wrap">
              <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2">Até R$ 50</button>
              <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2">R$ 50 - R$ 100</button>
              <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2">R$ 100 - R$ 200</button>
              <button class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full mr-2 mb-2">Mais de R$ 200</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Produtos -->
      <div>

          <section class="bg-gray-100 py-12">
              <div class="container mx-auto">
                  <h2 class="text-2xl font-bold mb-8">Nossos Produtos</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
              <div class="relative">
                <img src="https://picsum.photos/id/1/400/300" alt="Produto 1" class="w-full h-64 object-cover">
              </div>
              <div class="p-6">
                  <h3 class="text-lg font-semibold mb-2">Produto 1</h3>
                <p class="text-gray-700 font-medium mb-2">$19.99</p>
                <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.</p>
              </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
              <div class="relative">
                <img src="https://picsum.photos/id/2/400/300" alt="Produto 2" class="w-full h-64 object-cover">
              </div>
              <div class="p-6">
                <h3 class="text-lg font-semibold mb-2">Produto 2</h3>
                <p class="text-gray-700 font-medium mb-2">$29.99</p>
                <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.</p>
              </div>
            </div>
          </div>
          <div class="flex justify-center mt-8">
            <nav class="flex rounded-md bg-white shadow">
              <a href="#" class="py-2 px-4 bg-gray-200 text-gray-700 rounded-l-md"><i class="fas fa-chevron-left"></i></a>
              <a href="#" class="py-2 px-4 bg-gray-200 text-gray-700"><span class="hidden md:inline">1</span><span class="inline md:hidden">01</span></a>
              <a href="#" class="py-2 px-4 bg-gray-200 text-gray-700"><span class="hidden md:inline">2</span><span class="inline md:hidden">02</span></a>
              <a href="#" class="py-2 px-4 bg-gray-200 text-gray-700"><span class="hidden md:inline">3</span><span class="inline md:hidden">03</span></a>
              <a href="#" class="py-2 px-4 bg-gray-200 text-gray-700 rounded-r-md"><i class="fas fa-chevron-right"></i></a>
            </nav>
          </div>
        </div>
    </div>


      </section>
      
      
        </main>            
    </body>
</html>
          