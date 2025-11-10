<?php

require_once __DIR__ . '../../../../vendor/autoload.php';
use Classes\Cliente;
use Classes\Anuncio;


session_start();
extract($_SESSION);

$cliente = new Cliente();
$cliente->pesquisaCliente($user_id);
// Simulação de dados (substituir dps )


$anuncio = new Anuncio ();
$anunciosContratados = $anuncio->pesquisaAnunciosContratados($user_id);


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .carousel-track::-webkit-scrollbar {
            height: 8px;
        }
        .carousel-track::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 10px;
        }
        .carousel-track::-webkit-scrollbar-thumb {
            background-color: #f97316; 
            border-radius: 10px;
        }
        .carousel-track::-webkit-scrollbar-thumb:hover {
            background-color: #ea580c; 
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        <aside class="w-64 bg-white shadow-xl flex flex-col">
            <div class="p-6 border-b">
                <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">
                    Meu Painel
                </h1>
                <span class="text-sm text-gray-500">Cliente</span>
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="nav-link active flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors" data-target="dashboard">
                    <i class="bi bi-house-door-fill w-5"></i>
                    <span>Início</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors" data-target="anuncios">
                    <i class="bi bi-star-fill w-5"></i>
                    <span>Anúncios Contratados</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors" data-target="chat">
                    <i class="bi bi-chat-dots-fill w-5"></i>
                    <span>Chat</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors" data-target="configuracoes">
                    <i class="bi bi-gear-fill w-5"></i>
                    <span>Configurações</span>
                </a>
            </nav>

            <a href="../../index.php" target="_blank" class=" p-4 bordet-t flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors">
                <i class="bi bi-house-fill w-5"></i>
                <span>Pagina Inicial</span>
            </a>
            
            <div class="p-4 border-t">
                <a href="../../auth/logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-500 font-medium hover:bg-red-50 transition-colors">
                    <i class="bi bi-box-arrow-right w-5"></i>
                    <span>Sair</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-8 h-screen overflow-y-auto">

            <div id="content-dashboard" class="content-section">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Bem-vindo,<?=htmlspecialchars($user_name);?>!</h1>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-700">Selecione uma opção no menu ao lado para começar.</p>
                </div>
            </div>

            <div id="content-anuncios" class="content-section hidden">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Seus Anúncios Contratados</h1>
                
                <div class="relative w-full">
                    <div class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth carousel-track pb-4">
                        
                        <?php foreach ($anunciosContratados as $key => $anuncio): ?>
                        <div class="snap-center flex-shrink-0 w-full sm:w-1/2 lg:w-1/3 p-3">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full flex flex-col">
                                <img src="../../uploads/<?= htmlspecialchars($anuncio->caminho_arquivo) ?>" alt="<?= htmlspecialchars($anuncio->titulo) ?>" class="w-full h-48 object-cover">
                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($anuncio->titulo) ?></h3>
                                    <p class="text-gray-600 mb-4 flex-1"><?= htmlspecialchars($anuncio->descricao) ?></p>
                                    <a href="/comerciante/<?= $anuncio->idAnuncio?>" class="text-center bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                                        Ver Comerciante
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                    </div>
                </div>
            </div>

            <div id="content-chat" class="content-section hidden">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Chat</h1>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-700">Ainda em desenvolvimento.</p>
                    </div>
            </div>

            <div id="content-configuracoes" class="content-section hidden">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Configurações da Conta</h1>
                
                <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
                    <form action="/cliente/atualizar" method="POST" class="space-y-6">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                            <input type="text" id="nome" name="nome" value="[Nome do Cliente]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="[email@cliente.com]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Nova Senha</label>
                                <input type="password" id="senha" name="senha" placeholder="Deixe em branco para não alterar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            <div>
                                <label for="senha_confirma" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nova Senha</label>
                                <input type="password" id="senha_confirma" name="senha_confirma" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600 transition-colors">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const contentSections = document.querySelectorAll('.content-section');

            const activeClasses = 'bg-gradient-to-r from-orange-50 to-orange-100 text-orange-600 border-r-4 border-orange-500'.split(' ');
            const inactiveClasses = 'text-gray-700'.split(' ');

            function setLinkActive(activeLink) {
                navLinks.forEach(link => {
                    link.classList.remove(...activeClasses);
                    link.classList.add(...inactiveClasses);
                });
                activeLink.classList.add(...activeClasses);
                activeLink.classList.remove(...inactiveClasses);
            }

            setLinkActive(document.querySelector('.nav-link.active'));

            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    const targetId = this.getAttribute('data-target');
                    
                    contentSections.forEach(section => {
                        section.classList.add('hidden');
                    });
                    
                    const targetSection = document.getElementById('content-' + targetId);
                    if (targetSection) {
                        targetSection.classList.remove('hidden');
                    }
                    setLinkActive(this);
                });
            });
        });
    </script>

</body>
</html>