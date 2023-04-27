<?php

//Retorna uma string contendo a mensagem de erro embutida no html
function errorPopUp(string $msg) {
    return "
        <div id='popup' class='fixed mx-auto top-0 left-0 right-0 z-10 w-1/4'>
          <div class='mx-auto mt-4 bg-yellow-100 rounded-lg p-4'>
            <button id='closeBtn' class='float-right text-gray-700 hover:text-gray-800 focus:outline-none'>
              <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' viewBox='0 0 20 20' fill='currentColor'>
            <path fill-rule='evenodd' d='M13.414 6.586a2 2 0 112.828 2.828L12.828 10l3.414 3.414a2 2 0 11-2.828 2.828L10 12.828l-3.414 3.414a2 2 0 11-2.828-2.828L7.172 10 3.758 6.586a2 2 0 112.828-2.828L10 7.172l3.414-3.414z' clip-rule='evenodd' />
              </svg>
            </button>
            <p class='font-bold'>Erro</p>
            <p>$msg</p>
          </div>
        </div>
        <script src='scripts/msg.js'></script>
    ";
}
?>
