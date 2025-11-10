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


$comerc = new Comerciante();
$comerc->pesquisaComerciante($user_id);
// Simulação de dados (substitua pela sua lógica)


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
                    <span>Seus Anúncios Ativos</span>
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
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Seus Anúncios Ativos</h1>
            
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
                                    <span class="text-xs font-medium bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Ativo</span>
                                <?php else: ?>
                                    <span class="text-xs font-medium bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">Pendente</span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="text-gray-600 mb-4">Descrição: <?= htmlspecialchars($anuncio->descricao) ?></p>
                                <h1 class="text-xl font-semibold py-3  text-gray-800">Valor: R$<?= htmlspecialchars($anuncio->valor) ?></h1>

                            
                            <div class="flex space-x-2">
                                
                                <a href="/anuncio/editar/<?= $anuncio->idAnuncio ?>" class="text-center w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                                    Editar
                                </a>
                                <a href="/anuncio/excluir/<?= $anuncio->idAnuncio ?>" class="text-center w-full bg-orange-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 transition-colors">
                                    Excluir
                                </a>
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
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-700">Ainda em Desenvolvimento.</p>
                </div>
            </div>

            <div id="content-configuracoes" class="content-section hidden">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Configurações do Comerciante</h1>
                
                <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
                    <form action="/comerciante/atualizar" method="POST" class="space-y-6">
                        <div>
                            <label for="nome_fantasia" class="block text-sm font-medium text-gray-700 mb-1">Nome Fantasia</label>
                            <input type="text" id="nome_fantasia" name="nome_fantasia" value="[Nome Fantasia]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        
                        <div>
                            <label for="email_contato" class="block text-sm font-medium text-gray-700 mb-1">Email de Contato</label>
                            <input type="email" id="email_contato" name="email_contato" value="[contato@comerciante.com]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>

                        <div>
                            <label for="endereco" class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                            <input type="text" id="endereco" name="endereco" value="[Endereço do Comerciante]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
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