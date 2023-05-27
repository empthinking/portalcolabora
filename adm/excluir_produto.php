<!DOCTYPE html>
<html>
<head>
    <title>Excluir Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function confirmarExclusao() {
            return confirm("Tem certeza que deseja excluir esse produto?");
        }
    </script>
</head>
<body class="bg-gray-200">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Excluir Produto</h2>
            <p>Deseja realmente excluir o produto "Nome do Produto"?</p>
            <div class="flex justify-between mt-4">
                <a href="#" onclick="return confirmarExclusao()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Excluir</a>
                <a href="#" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancelar</a>
            </div>
        </div>
        <a href="admin.php" class="block mt-4 text-blue-500 hover:text-blue-700">Voltar</a>

    </div>
    
</body>
</html>
