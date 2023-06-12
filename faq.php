<?php
session_start();
require_once 'db.php';
require_once 'header.php';
?>

<main>
  <section class="bg-gray-100 py-12">
    <div class="container">
      <h1 class="text-center mt-3 text-3xl font-bold mb-4">Perguntas frequentes</h1>
      <h2 class="text-lg font-medium mb-8">Aqui estão algumas das perguntas mais frequentes que recebemos.</h2>

      <div class="border-top border-gray-300 py-8">
        <div class="mb-4">
          <h3 class="text-lg font-medium mb-2">Como faço para fazer uma compra?</h3>
          <p class="text-gray-600">Para fazer uma compra, basta se cadastrar em nosso portal, escolher os produtos desejados e finalizar a compra entrando em contato com o vendedor, seguindo as instruções na tela.</p>
        </div>

        <div class="mb-4">
          <h3 class="text-lg font-medium mb-2">Quais são as formas de pagamento disponíveis?</h3>
          <p class="text-gray-600">O portal colabora não se responsabiliza pelos pagamentos, isso é entre os métodos que o comprador e o vendedor escolherem.</p>
        </div>

        <div class="mb-4">
          <h3 class="text-lg font-medium mb-2">Qual é o prazo de entrega?</h3>
          <p class="text-gray-600">O portal colabora não realiza entregas, o prazo de entrega pode variar de acordo com a região e a forma de envio escolhida. Consulte as informações com o vendedor.</p>
        </div>

        <div class="mb-4">
          <h3 class="text-lg font-medium mb-2">Como faço para enviar uma pergunta?</h3>
          <p class="text-gray-600">Envie uma mensagem para nós por meio do <a href="contato.php" class="text-blue-700">contato</a>.</p>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once 'footer.php';
