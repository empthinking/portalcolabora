<?php if (!isUserLoggedIn()): ?>    
    <div class="bg-white rounded-lg w-full max-w-md mx-auto p-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <span class="text-red-500">Para entrar em contato com o vendedor, você precisa estar logado.</span>
        <div class="mt-4">
          <a href="cadastro.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cadastrar</a>
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4" onclick="document.getElementById('singIn').style.display='block'; document.getElementById('contactOptions').style.display='none'">Login</button>
        </div>
            </div>
            <button type="button" onclick="document.getElementById('contactOptions').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mt-4 w-full">
                Cancelar
                </button>
            </div>
            </div>
        </div> 
    
<style>.product-card {
  width: 820px;
  max-width: 100%;
  height: 500px;
  margin: 0 auto;
  background-color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 0.5rem;
  padding: 20px;
  display: flex;
}

.image-container {
  width: 60%;
  text-align: center;
  padding-right: 20px;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 0.5rem;
}

.product-details {
  width: 40%;
}

.product-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.product-description {
  font-size: 16px;
  color: #666666;
  margin-bottom: 20px;
}

.product-price {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 20px;
}

.contact-button {
  background-color: #a2d9aa;
  color: #ffffff;
  font-weight: bold;
  font-size: 20px;
  padding: 16px 24px;
  border-radius: 0.5rem;
  cursor: pointer;
  align-self: flex-start;
}

  </style>

    <script>
      function showContactOptions() {
        const contactOptions = document.getElementById('contactOptions');
        contactOptions.style.display = 'block';
      }
    </script>

    <?php
  } else {
    echo "Produto não encontrado.";
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
} else {
  echo "ID do produto não fornecido na URL.";
}
?>

</body></html>

