<?php
session_start();
// Verificação de sessão
if ($_SESSION['user_type'] != 'cliente') {
    header("Location: ../../login.php");
    exit();
}

// Includes e setup do modelo
include_once '../../../vendor/autoload.php';
use Classes\Anuncio;


print_r($_SESSION);

$anuncioModel = new Anuncio();
$anuncios = $anuncioModel->pesquisaTodosAnuncios();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anúncios - Painel do Cliente</title>
    <link rel="stylesheet" href="css/painel-cliente.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <nav class="bg-white shadow-md mb-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex-1">
                    <a class="text-xl font-bold text-gray-900">Painel do Cliente</a>
                </div>
                <div class="flex-none">
                    <a href="../../auth/logout.php"
                        class="inline-block px-3 py-1 border border-red-500 text-red-500 rounded text-sm font-semibold hover:bg-red-500 hover:text-white transition-colors">
                        Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="create-announce-bar">

        <div id="btn-create" class="btn-create">
            <div class="add-btn">
                <img src="images/add-btn.png" alt="">
            </div>

            <h1>Adicionar um Anúncio</h1>
        </div>

    </div>



    <main class="container mx-auto px-4 pb-8">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">Anúncios Disponíveis</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php foreach ($anuncios as $value): ?>

                <div
                    class="bg-white rounded-lg shadow-xl overflow-hidden transition-transform hover:shadow-2xl hover:-translate-y-1">

                    <div class="h-48">
                        <img src="https://sintricomb.com.br/wp-content/uploads/2018/12/curso.jpg" alt="Imagem do Anúncio"
                            class="w-full h-full object-cover" />
                    </div>

                    <div class="p-6">

                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex-shrink-0">
                                <img src="default-user.jpg" alt="Avatar do comerciante"
                                    class="w-12 h-12 rounded-full ring-2 ring-orange-600 ring-offset-2" />
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($value['nome']); ?>, 22
                                </h2>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($value['localidade']); ?></p>
                            </div>
                        </div>

                        <h3 class="font-semibold text-gray-800">Descrição do Anúncio:</h3>
                        <p class="text-gray-700 mb-4 text-sm h-20 overflow-y-auto">
                            <?= htmlspecialchars($value['descricao']); ?>
                        </p>

                        <div class="mb-4">
                            <span class="font-bold text-sm text-gray-800">Categoria:</span>
                            <span
                                class="ml-2 inline-block px-3 py-1 text-xs font-semibold text-orange-600 border border-orange-600 rounded-full">
                                <?= htmlspecialchars($value['categoria']); ?>
                            </span>
                        </div>

                        <div class="mb-4 p-4 bg-gray-100 rounded-lg text-center">
                            <span class="text-xs uppercase font-semibold text-gray-600">Valor do Serviço</span>
                            <div class="text-3xl font-bold text-orange-600">
                                R$ <?= htmlspecialchars($value['valor']); ?>
                                <span class="text-lg font-normal text-gray-600">/diária</span>
                            </div>
                        </div>

                        <div class="flex justify-end items-center mt-4 gap-2">
                            <button
                                class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-orange-600 transition-colors"
                                aria-label="Favoritar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>

                            <form action="#" method="post" class="inline">
                                <button type="submit"
                                    class="inline-block px-5 py-2 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-colors">
                                    Contratar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($anuncios)): ?>
            <div class="bg-white rounded-lg shadow-md mt-6 text-center p-16">
                <div class="max-w-md mx-auto">
                    <h1 class="text-3xl font-bold text-gray-800">Nenhum anúncio encontrado.</h1>
                    <p class="py-6 text-gray-600">Volte mais tarde para ver as novidades!</p>
                </div>
            </div>
        <?php endif; ?>

    </main>

    <div id="modal" class="modal">
        
        <div id="exit" class="exit-btn">
            <img src="images/exit-btn.png" alt="">
        </div>
        
        <form action="" method="post" class="form-box">
            
            <h1 style="font-weight: bold; font-size: 25px">Criar um anúncio</h1>

            <div class="input-box">
                <p>Foto do anúncio (.png .jpeg):</p>
                <input type="file" placeholder="Descreva brevemente seu anúncio...">
            </div>

            <div class="input-box">
                <p style="font-weight: bold;">Titulo do Anúncio:</p>
                <input type="text" placeholder="Titúlo do anúncio...">
            </div>

            <div class="input-box">
                <p style="font-weight: bold;">Descrição do Anúncio:</p>
                <input style="height: 100px;" type="text" placeholder="Descreva brevemente seu anúncio...">
            </div>

            <div class="input-box">
                <p style="font-weight: bold;">Valor (R$):</p>
                <input type="number" placeholder="Valor do serviço...">
            </div>


            <button type="submit">Adicionar</button>


        </form>





    </div>

    <script>
        document.getElementById("btn-create").addEventListener("click",function(){
            document.getElementById("modal").style.display="flex";
        });

        document.getElementById("exit").addEventListener("click",function(){
            document.getElementById("modal").style.display="none";
        });


    </script>


</body>



</html>