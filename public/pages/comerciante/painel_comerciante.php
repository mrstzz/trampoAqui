<?php
// Lógica para iniciar sessão e buscar dados

require_once __DIR__ . '../../../../vendor/autoload.php';
require_once '../../functions.php';
use Classes\Comerciante;
use Classes\Arquivo;
use Classes\Anuncio;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

extract($_SESSION);



if (isset($_SESSION['alert'])) {

    echo '<script>
            const flashMessage = ' . json_encode($_SESSION['alert']) . ';
          </script>';
    
    unset($_SESSION['alert']);
}


$comerc = new Comerciante();
$comerciante = $comerc->pesquisaComerciante($user_id);

$anuncio = new Anuncio();
$anunciosAtivos = $anuncio->pesquisarPeloId($user_id);

$categorias = $anuncio->pesquisaTodasCategorias();


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Comerciante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/alert.js"></script>
    <script src="../../js/chat.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        <aside class="w-64 bg-white shadow-xl flex flex-col">
            <div class="p-6 border-b">
                <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">
                    Meu Painel
                </h1>
                <span class="text-sm text-gray-500">Comerciante</span>
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="nav-link active flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors" data-target="dashboard">
                    <i class="bi bi-house-door-fill w-5"></i>
                    <span>Início</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors" data-target="criar-anuncio">
                    <i class="bi bi-plus-circle-fill w-5"></i>
                    <span>Criar Anúncio</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-orange-50 hover:text-orange-600 transition-colors" data-target="anuncios-ativos">
                    <i class="bi bi-megaphone-fill w-5"></i>
                    <span>Seus Anúncios</span>
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
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Bem-vindo, <?=htmlspecialchars($user_name)?>!</h1>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-700">Selecione uma opção no menu ao lado para gerenciar seu negócio.</p>
                </div>
            </div>

            <div id="content-criar-anuncio" class="content-section hidden">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Criar Novo Anúncio</h1>
                
                <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl">
                    <form action="./cad_painel_comerciante.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="anuncio" value="1">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título do Anúncio</label>
                            <input type="text" id="titulo" name="titulo" placeholder="Ex: Promoção de Picanha" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>

                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Localidade</label>
                            <input type="text" id="localidade" name="localidade" placeholder="Ex: Caratinga-MG" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>

                        <div>
                            <label for="valor" class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                            <input type="number" id="valor" name="valor" placeholder="Ex: 10.00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        
                        <div>
                            <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                            <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva sua promoção ou produto..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                        </div>


                        <div>
                            <label for="imagem" class="block text-sm font-medium text-gray-700 mb-1">Imagem do Anúncio</label>
                            <input type="file" id="imagem" name="imagem" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                        </div>

                        <div class="mt-4">

                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                            Categoria
                        </label>
                        
                        <select id="categoria" name="categoria_id" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            
                            <option value="">-- Selecione uma Categoria --</option>
                            
                            <?php foreach ($categorias as $categoria): ?>
                                
                                <option value="<?php echo htmlspecialchars($categoria->id); ?>">
                                    <?php echo htmlspecialchars($categoria->nome); ?>
                                </option>

                            <?php endforeach; ?>
                            
                        </select>
                    </div>



                        <div class="text-right">
                            <button type="submit" class="bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600 transition-colors">
                                Publicar Anúncio
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="content-anuncios-ativos" class="content-section hidden">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Seus Anúncios</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <?php 
                // Verifica se $anunciosAtivos não está vazio antes de tentar o loop
                if (!empty($anunciosAtivos)): 
                    foreach ($anunciosAtivos as $key => $anuncio):
                ?>
                    
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        
                        <img src="../../uploads/<?= htmlspecialchars($anuncio->caminho_arquivo)?>" alt="<?= htmlspecialchars($anuncio->titulo) ?>" class="w-full h-48 object-cover">
                        
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                
                                <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($anuncio->titulo) ?></h3>
                                
                                <?php if ($anuncio->status === 'ativo'): // Corrigido para 'ativo' minúsculo, como no seu DB ?>
                                    <span class="text-xs font-bold bg-green-100 text-green-600 px-2 py-0.5 rounded-full">Ativo</span>
                                <?php elseif( $anuncio->status === 'contratado'): ?>
                                    <span class="text-xs font-bold bg-orange-200 text-orange-500 px-2 py-0.5 rounded-full">Contratado</span>
                                <?php elseif ($anuncio->status === 'concluido'): ?>
                                    <span class="text-xs font-bold bg-orange-100 text-orange-400 px-2 py-0.5 rounded-full">Concluído </span>
                                <?php elseif ($anuncio->status === 'desativado'): ?>
                                    <span class="text-xs font-bold bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full">Desativado</span>
                                <?php else: ?>
                                    <span class="text-xs font-bold bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Desativado</span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="text-gray-600 mb-4">Descrição: <?= htmlspecialchars($anuncio->descricao) ?></p>
                                <h1 class="text-xl font-semibold py-3  text-gray-800">Valor: R$<?= htmlspecialchars($anuncio->valor) ?></h1>

                            <div class="flex justify-end space-x-2">
                                
                                <?php if ($anuncio->status == 'desativado'): ?>
                                    
                                <a href="./cad_painel_comerciante.php?ativar=1&anuncio_id=<?= $anuncio->idAnuncio ?>" class=" w-right  text-center text-green-600 border border-green-600 font-semibold py-2 px-4 rounded-lg hover:bg-green-500 hover:text-white transition-colors">
                                    Ativar
                                </a>
                                <?php else: ?>
                                <a href="./cad_painel_comerciante.php?desativar=1&anuncio_id=<?= $anuncio->idAnuncio ?>" class=" w-right  text-center text-red-600 border border-red-600 font-semibold py-2 px-4 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                                    Desativar
                                </a>
                                <?php endif; ?>
                            </div>





                        </div>
                    </div>
                    
                <?php 
                    endforeach; 
                else:
                ?>
                    <div class="col-span-full bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-700 text-center">Você ainda não tem nenhum anúncio ativo.</p>
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
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Configurações do Comerciante</h1>
                
                <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
                    <form action="./cad_painel_comerciante.php" method="POST" class="space-y-6">
                        <input type="hidden" name="config" value="1">
                        <div>
                            <label for="nome_config" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                            <input type="text" id="nome_config" name="nome_config" value="<?=htmlspecialchars($comerciante['nome']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        
                        <div>
                            <label for="email_config" class="block text-sm font-medium text-gray-700 mb-1">Email de Contato</label>
                            <input type="email" id="email_config" name="email_config" value="<?=htmlspecialchars($comerciante['email']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>

                        <div>
                            <label for="telefone_config" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                            <input type="number" id="telefone_config" name="telefone_config" value="<?=htmlspecialchars($comerciante['telefone'])?>" maxlength="11" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
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


<!-- <div id="modal-edita" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
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
    <script src="../../js/ajaxEdita.js"></script> -->



</body>
</html>