
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trampoAqui - Seu trampo você encontra aqui!</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #4F46E5; /* Cor indigo-600 do Tailwind */
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
                <h1 class="text-4xl font-bold mb-4">Encontre o profissional certo para seu trampo!</h1>
                <p class="text-lg mb-8">De reformas a aulas particulares, conectamos você aos melhores prestadores.</p>
                <a href="#" class="bg-white text-indigo-700 font-bold py-3 px-8 rounded-full text-lg hover:bg-gray-100 transition duration-300">
                    Comece a Buscar
                </a>
            </div>
        </section>

        <section class="mt-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Serviços em Destaque</h2>
            
            <div class="swiper popular-services">
                <div class="swiper-wrapper">
                    <div class="swiper-slide bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=2070&auto=format&fit=crop" alt="Limpeza" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">Limpeza e Diaristas</h3>
                        </div>
                    </div>
                    <div class="swiper-slide bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544725176-7c40e5a71c3e?q=80&w=2070&auto=format&fit=crop" alt="Reformas" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">Reformas e Reparos</h3>
                        </div>
                    </div>
                    <div class="swiper-slide bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop" alt="Aulas" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">Aulas e Consultorias</h3>
                        </div>
                    </div>
                    <div class="swiper-slide bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop" alt="TI" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">Técnico de Informática</h3>
                        </div>
                    </div>
                    <div class="swiper-slide bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519494026892-2ba52bc411a-?q=80&w=2070&auto=format&fit=crop" alt="Saúde" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">Saúde e Bem-estar</h3>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination mt-4"></div>
                
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
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


    <script>
        const swiper = new Swiper('.popular-services', {
            // Quantidade de slides por view
            slidesPerView: 1,
            spaceBetween: 20, // Espaço entre os slides

            // Breakpoints responsivos
            breakpoints: {
                // >= 640px
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                // >= 1024px
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },

            // Loop
            loop: true,

            // Autoplay (carrossel "passando sozinho")
            autoplay: {
                delay: 3000, // 3 segundos
                disableOnInteraction: false,
            },

            // Paginação (bolinhas)
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navegação (setas)
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

</body>
</html>