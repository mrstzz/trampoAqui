<?php

require_once __DIR__ . '../../../../vendor/autoload.php';
use Classes\Cliente;
use Classes\Anuncio;


session_start();
extract($_SESSION);

$cliente = new Cliente();
$cliente->pesquisaCliente($user_id);

$anuncio = new Anuncio ();
$anunciosContratados = $anuncio->pesquisaAnunciosContratados($user_id);


if (isset($_SESSION['alert'])) {

    echo '<script>
            const flashMessage = ' . json_encode($_SESSION['alert']) . ';
          </script>';
    
    unset($_SESSION['alert']);
}



?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/alert.js"></script>
    <script src="../../js/chat.js"></script>
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
                
                <div class="grid grid-cols-1 md:grid-cols-2 md:grid-cols-3 gap-6">
                
            <?php 
            if (!empty($anunciosContratados)): 
                foreach ($anunciosContratados as $key => $anuncio):
            ?>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    
                    <img src="../../uploads/<?= htmlspecialchars($anuncio->caminho_arquivo)?>" alt="<?= htmlspecialchars($anuncio->titulo) ?>" class="w-full h-48 object-cover">
                    
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($anuncio->titulo) ?></h3>
                        <h3 class="text-md font-sm text-gray-800 mb-2"><?= htmlspecialchars($anuncio->comercNome) ?></h3>
                        
                        <div class="flex justify-end space-x-2 mt-4">
                            
                            <?php 
                            if ($anuncio->status === 'contratado'): 
                            ?>
                                <button type="button"
                                        class="btn-avaliar text-green-600 border border-green-600 font-semibold py-2 px-4 rounded-lg hover:bg-green-500 hover:text-white transition-colors"
                                        data-contrato-id="<?= htmlspecialchars($anuncio->idContrato) ?>"
                                        data-comerciante-id="<?= htmlspecialchars($anuncio->comerc_id) ?>"
                                        data-anuncio-id="<?= htmlspecialchars($anuncio->idAnuncio) ?>"
                                        data-anuncio-titulo="<?= htmlspecialchars($anuncio->titulo) ?>">
                                    Avaliar
                                </button>
                            
                            <?php elseif ($anuncio->status === 'concluido'): ?>
                                <span class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
                                    <i class="bi bi-check-circle-fill text-green-500"></i> Avaliado
                                </span>
                            
                            <?php endif; ?>
                            
                            
                            <a href="../../perfil_comerciante.php?id=<?=htmlspecialchars($anuncio->comerc_id)?>" class="text-blue-600 border border-blue-600 text-center font-semibold py-2 px-4 rounded-lg hover:bg-blue-500 hover:text-white transition-colors">
                                Ver Comerciante
                            </a>
                        </div>
                    </div>
                </div>
                
            <?php 
                endforeach;
                else:
                ?>
                    <div class="col-span-full bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-700 text-center">Você ainda não tem nenhum anúncio contratado.</p>
                    </div>
                <?php
                endif; 
                ?>

            </div>
            </div>

            <div id="content-chat" class="content-section hidden">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Chat</h1>
                
                <div class="flex bg-white rounded-lg shadow-md" style="height: 70vh;">
                    
                    <div class="w-1/3 border-r border-gray-200 overflow-y-auto" id="chat-list-container">
                        <div class="p-4 text-center text-gray-500">Carregando conversas...</div>
                    </div>

                    <div class="w-2/3 flex flex-col" id="chat-window">
                        
                        <div class="p-4 border-b border-gray-200">
                            <h2 id="chat-header-name" class="text-lg font-semibold text-gray-700">Selecione uma conversa</h2>
                        </div>

                        <div class="flex-1 p-4 space-y-4 overflow-y-auto bg-gray-50" id="chat-history">
                            <div class="text-center text-gray-400" id="chat-placeholder">
                                Selecione uma conversa ao lado para começar.
                            </div>
                        </div>

                        <div class="p-4 border-t border-gray-200 bg-white">
                            <form id="chat-send-form" class="flex space-x-3">
                                <input type="hidden" id="chat-conversation-id" name="conversation_id" value="">
                                
                                <input type="text" id="chat-message-input" name="message_text" 
                                    placeholder="Digite sua mensagem..." 
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" disabled>
                                
                                <button type="submit" id="chat-send-button"
                                        class="bg-orange-500 text-white font-bold py-2 px-5 rounded-lg hover:bg-orange-600 transition-colors disabled:opacity-50" disabled>
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
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

    <div id="avaliacao-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 p-6 relative">
        
        <button id="modal-close-btn-avaliacao" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <h2 class="text-2xl font-bold mb-4 text-gray-800" id="avaliacao-modal-title">Avaliar Serviço</h2>
        
        <form id="avaliacao-form" action="../../api/avaliar.php" method="POST" class="space-y-4">
            
            <input type="hidden" id="hidden-contrato-id" name="contrato_id">
            <input type="hidden" id="hidden-comerciante-id" name="comerc_id">
            <input type="hidden" id="hidden-anuncio-id" name="anuncio_id">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sua Nota</label>
                <div class="flex items-center justify-center space-x-1 star-rating">
                    <input type="radio" id="star5" name="nota" value="5" class="hidden"><label for="star5" title="5 estrelas" class="star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" id="star4" name="nota" value="4" class="hidden"><label for="star4" title="4 estrelas" class="star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" id="star3" name="nota" value="3" class="hidden"><label for="star3" title="3 estrelas" class="star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" id="star2" name="nota" value="2" class="hidden"><label for="star2" title="2 estrelas" class="star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" id="star1" name="nota" value="1" class="hidden"><label for="star1" title="1 estrela"  class="star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400"><i class="bi bi-star-fill"></i></label>
                </div>
            </div>

            <div>
                <label for="comentario" class="block text-sm font-medium text-gray-700 mb-1">Comentário (Opcional)</label>
                <textarea id="comentario" name="comentario" rows="4" placeholder="Descreva sua experiência com o comerciante..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600 transition-colors">
                    Enviar Avaliação
                </button>
            </div>
        </form>
    </div>
</div>
<style>
    .star-rating { direction: rtl; } /* Faz as estrelas acenderem da direita p/ esquerda */
    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #f59e0b; /* text-yellow-500 */
    }
    .star-rating input[type="radio"]:checked + label {
        color: #f59e0b;
    }
</style>

<script src="../../js/avaliaComerciante.js"></script>

</body>
</html>