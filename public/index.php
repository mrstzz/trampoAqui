<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../vendor/autoload.php';
include_once './functions.php';
use Classes\Anuncio;


if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    $bgColor = ($message['type'] === 'success') 
        ? 'bg-green-100 border-green-400 text-green-700' // Sucesso
        : 'bg-red-100 border-red-400 text-red-700';      // Erro

    echo '<div class="' . $bgColor . ' border px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">' . htmlspecialchars($message['message']) . '</span>
          </div>';
    unset($_SESSION['flash_message']);
}

$categorias_destaque = [
            ['nome' => 'Construção e Reformas', 'img' => 'https://plus.unsplash.com/premium_photo-1681691423422-bcaa3eaad7e8?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170', 'link' => '#'],
            ['nome' => 'Aulas e Consultorias', 'img' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop', 'link' => '#'],
            ['nome' => 'Limpeza e Conservação', 'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=2070&auto=format&fit=crop', 'link' => '#'],
            ['nome' => 'Design e UI UX Design', 'img' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop', 'link' => '#'],
            ['nome' => 'Técnico de Informática', 'img' => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop', 'link' => '#'],
            ['nome' => 'ㅤㅤSaúde eㅤㅤㅤ Bem-estar', 'img' => 'https://images.unsplash.com/photo-1477332552946-cfb384aeaf1c?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170', 'link' => '#']
             
        ];

$anuncioModel = new Anuncio();
$carrossel = '1';
$anuncios = $anuncioModel->pesquisaTodosAnuncios($carrossel);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trampoAqui - Seu trampo você encontra aqui!</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/index.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="shortcut icon" href="assets/images/logo-trampo-aqui-white-new50.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #4F46E5;
        }
        .swiper-pagination-bullet-active {
            background-color: #4F46E5;
        }
    </style>
</head>
<body class="bg-gray-100">

    <?php include_once '../partials/_header.php'?>

    <main class="container mx-auto px-4 mt-8">

        <section class="bg-indigo-700 rounded-lg p-12 text-white text-center" style="background-image: url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center;">
            <div class="bg-indigo-700 bg-opacity-70 rounded-lg p-8">
                <h1 class="text-4xl font-bold mb-4">Encontre o profissional certo para sua demanda!</h1>
                <p class="text-lg mb-8">De reformas a aulas particulares, conectamos você aos melhores prestadores.</p>
                <a href="#" class="bg-white text-indigo-700 font-bold py-3 px-8 rounded-full text-lg hover:bg-gray-100 transition duration-300">
                    Comece a Buscar
                </a>
            </div>
        </section>

        <section class="mt-16">

        <h2 class="text-3xl font-bold mb-6 text-gray-800 mt-12">Categorias em destaque</h2>

        <div class="swiper categorias-carousel overflow-hidden relative pb-10 md:pb-12">
            
            <div class="swiper-wrapper">

                <?php foreach ($categorias_destaque as $categoria): ?>
                    <div class="swiper-slide h-auto p-2">
                        <a href="<?= htmlspecialchars($categoria['link']); ?>" 
                           class="block bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:shadow-xl hover:-translate-y-1 group">
                            
                            <div class="h-40 overflow-hidden">
                                <img src="<?= htmlspecialchars($categoria['img']); ?>" alt="<?= htmlspecialchars($categoria['nome']); ?>" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            </div>
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($categoria['nome']); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div> <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>
        
        
        
        <h1 class="text-3xl font-bold mb-6 text-gray-800 mt-12">Anúncios Recentes</h1>

        <div class="swiper anuncios-carousel overflow-hidden relative pb-10 md:pb-12">

            <div class="swiper-wrapper">

                <?php foreach ($anuncios as $key => $value): ?>
                    <div class="swiper-slide h-auto p-2">
                        
                        <div class="bg-white rounded-lg shadow-xl overflow-hidden transition-transform hover:shadow-2xl hover:-translate-y-1 flex flex-col">
                            
                            <?php if (!empty($value->caminho_arquivo)): ?>
                                <div class="h-48 flex-shrink-0">
                                    <img src="./uploads/<?= htmlspecialchars($value->caminho_arquivo);?>" alt="Imagem do Anúncio"
                                        class="w-full h-full object-cover" />
                                </div>
                            <?php else:?>
                                <div class="h-48 flex-shrink-0">
                                    <img src="./assets/images/semImagem.png" alt="Imagem do Anúncio" class="w-full h-full object-cover" />
                                </div>
                            <?php endif?>

                            <div class="p-6 flex flex-col flex-grow">

                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex-shrink-0">
                                        <img src="./icons/user-default.svg" alt="Avatar do comerciante"
                                            class="w-12 h-12 rounded-full ring-2 ring-orange-600 ring-offset-2" />
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($value->nome); ?>, 22
                                        </h2>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($value->localidade); ?></p>
                                    </div>
                                </div>

                                <h3 class="font-semibold text-gray-800">Descrição do Anúncio:</h3>
                                <p class="text-gray-700 mb-4 text-sm h-20 overflow-y-auto">
                                    <?= htmlspecialchars($value->descricao); ?>
                                </p>

                                <div class="mb-4">
                                    <span class="font-bold text-sm text-gray-800">Categoria:</span>
                                    <span
                                        class="ml-2 inline-block px-3 py-1 text-xs font-semibold text-orange-600 border border-orange-600 rounded-full">
                                        <?= htmlspecialchars($value->nomeCategoria); ?>
                                    </span>
                                </div>

                                <div class="mb-4 p-4 bg-gray-100 rounded-lg text-center">
                                    <span class="text-xs uppercase font-semibold text-gray-600">Valor do Serviço</span>
                                    <div class="text-3xl font-bold text-orange-600">
                                        R$ <?= htmlspecialchars($value->valor); ?>
                                        <span class="text-lg font-normal text-gray-600">/diária</span>
                                    </div>
                                </div>

                                <div class="flex justify-end items-center mt-auto gap-2">
                                    <button
                                        class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-orange-600 transition-colors"
                                        aria-label="Favoritar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>

                                    <button type="button" 
                                        data-id="<?= htmlspecialchars($value->anuncioID); ?>"
                                        class="btn-contratar inline-block px-5 py-2 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-colors">
                                        Contratar
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div> <?php endforeach; ?>

            </div> <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div> <?php if (empty($anuncios)): ?>
            <div class="bg-white rounded-lg shadow-md mt-6 text-center p-16">
                <div class="max-w-md mx-auto">
                    <h1 class="text-3xl font-bold text-gray-800">Nenhum anúncio encontrado.</h1>
                    <p class="py-6 text-gray-600">Volte mais tarde para ver as novidades!</p>
                </div>
            </div>
        <?php endif; ?>
        </section>

        <section class="mt-16 bg-white rounded-lg shadow-lg p-10">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-10">Como o trampoAqui funciona?</h2>
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="flex justify-center items-center mb-4 w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">1. Busque o Serviço</h3>
                    <p class="text-gray-600">Use nossa barra de busca ou navegue pelas categorias para encontrar o que precisa.</p>
                </div>
                <div>
                    <div class="flex justify-center items-center mb-4 w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-2.87m-1.428 5.74a3 3 0 01-5.356-2.87m-1.428 5.74a3 3 0 00-5.356-2.87M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">2. Compare Prestadores</h3>
                    <p class="text-gray-600">Veja perfis, avaliações, portfólios e escolha o melhor profissional para você.</p>
                </div>
                <div>
                    <div class="flex justify-center items-center mb-4 w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">3. Contrate e Avalie</h3>
                    <p class="text-gray-600">Entre em contato, negocie e, após o serviço, deixe sua avaliação para ajudar a comunidade.</p>
                </div>
            </div>
        </section>

    </main>

    <footer class="mt-16 bg-gray-800 text-gray-300 text-center p-8">
        &copy; Todos os Direitos Reservados - trampoAqui 2025
    </footer>
    <?php include_once '../partials/_chat_widget.php' ?>

        
    <script>
        const swiperAnuncios = new Swiper('.anuncios-carousel', {
            slidesPerView: 1,
            spaceBetween: 20,
            autoHeight: true,
            loop: true,

            breakpoints: {
                768: { // 'md'
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: { // 'lg'
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },

            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },

            pagination: {
                el: '.anuncios-carousel .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.anuncios-carousel .swiper-button-next',
                prevEl: '.anuncios-carousel .swiper-button-prev',
            },
        });

        const swiperCategorias = new Swiper('.categorias-carousel', {
            slidesPerView: 2, // 2 no mobile
            spaceBetween: 20,
            loop: true,
            autoHeight: true,

            breakpoints: {
                640: { // 'sm'
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: { // 'md'
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1024: { // 'lg'
                    slidesPerView: 6,
                    spaceBetween: 30,
                },
            },

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            pagination: {
                el: '.categorias-carousel .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.categorias-carousel .swiper-button-next',
                prevEl: '.categorias-carousel .swiper-button-prev',
            },
        });
    </script>


    <!-- MODAL -->
    <div id="contratar-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 p-6 relative">
            
            <button id="modal-close-btn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <h2 class="text-2xl font-bold mb-4 text-gray-800" id="modal-title">Detalhes do Anúncio</h2>
            
            <div id="modal-content-area">
                <p class="text-center text-gray-600 py-8">Carregando...</p>
            </div>
        </div>
    </div>
    <script src="./js/ajaxContrata.js"></script>

</body>

</html>