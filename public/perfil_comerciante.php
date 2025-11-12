<?php
// perfil_comerciante.php (Página Pública)
require_once __DIR__ . '/../vendor/autoload.php';
use Classes\Comerciante;
use Classes\Anuncio;
use Classes\Reputacao;

$comerc_id = (int)($_GET['id'] ?? 0);
if ($comerc_id === 0) {
    die("Perfil não encontrado.");
}

// 2. Busca todos os dados
$comerc = new Comerciante();
$anuncio = new Anuncio();
$rep = new Reputacao();

$dadosComerc = $comerc->pesquisaComerciante($comerc_id);
$anunciosAtivos = $anuncio->pesquisaAnuncioAtivo($comerc_id); 
$dadosReputacao = $rep->getReputacao($comerc_id);

$caminhoFoto = (!empty($dadosComerc['foto_perfil'])) 
                ? "../uploads/" . htmlspecialchars($dadosComerc['foto_perfil']) 
                : "./icons/user-default.svg"; // Fallback ícone padrão

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Perfil de <?= htmlspecialchars($dadosComerc['nome']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        @keyframes animatedGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        body.bg-gray-100 {
            background: linear-gradient(270deg, #f3f4f6, #fff7ed, #f3f4f6);
            background-size: 400% 400%;
            animation: animatedGradient 25s ease infinite;
        }
    </style>

    <style>
        body {
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed; 
            top: -100px;
            left: -150px;
            width: 400px;  
            height: 400px;
            background: radial-gradient(circle, rgba(0, 32, 78, 0.1), transparent 40%);
            filter: blur(100px); 
            z-index: -1;     
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -150px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(29, 9, 143, 0.45), transparent 40%);
            filter: blur(100px);
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gray-100 relative overflow-x-hidden">

     <?php include_once '../partials/_header.php'?>

    <div class="max-w-4xl mt-8 py-2 mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        
        <div class="p-8">
            <div class="flex flex-col md:flex-row items-center">
                
                <img src="<?= $caminhoFoto ?>" 
                     alt="Foto de <?= htmlspecialchars($dadosComerc['nome']) ?>" 
                     class="w-32 h-32 rounded-full border-4 border-orange-500 object-cover bg-gray-200">
                
                <div class="md:ml-8 mt-4 md:mt-0 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($dadosComerc['nome']) ?></h1>
                    
                    <?php if ($dadosReputacao): ?>
                        <div class="flex items-center justify-center md:justify-start mt-2 space-x-2">
                            <span class="text-2xl font-bold text-yellow-500">
                                <?= number_format($dadosReputacao['nota_media'], 1) ?>
                            </span>
                            <i class="bi bi-star-fill text-yellow-500 text-xl"></i>
                            <span class="text-gray-500 text-lg">
                                (<?= $dadosReputacao['total_avaliacoes'] ?> avaliações)
                            </span>
                        </div>
                    <?php else: ?>
                        <span class="text-gray-500 mt-2">Nenhuma avaliação ainda.</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="p-8 border-t border-gray-200">
            
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sobre Mim</h2>
            <p class="text-gray-700 leading-relaxed">
                <?= htmlspecialchars($dadosComerc['sobre'] ?? 'Este comerciante ainda não escreveu sobre si.') ?>
            </p>
            
            <?php if ($dadosReputacao): ?>
                <div class="my-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Estatísticas</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <span class="block text-2xl font-bold text-orange-600"><?= $dadosReputacao['total_contratos_concluidos'] ?></span>
                            <span class="text-sm text-gray-500">Contratos Concluídos</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <span class="block text-2xl font-bold text-orange-600"><?= number_format($dadosReputacao['taxa_conclusao_percent'], 0) ?>%</span>
                            <span class="text-sm text-gray-500">Taxa de Conclusão</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <span class="block text-2xl font-bold text-orange-600"><?= $dadosReputacao['total_avaliacoes'] ?></span>
                            <span class="text-sm text-gray-500">Total de Avaliações</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <h2 class="text-2xl font-semibold text-gray-800 mb-6 mt-10">Anúncios Ativos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <?php if (!empty($anunciosAtivos)): ?>
                    <?php foreach ($anunciosAtivos as $anuncio): ?>
                        <div class="modal-ajax bg-white rounded-lg shadow-md overflow-hidden border">
                            <img src="../uploads/<?= htmlspecialchars($anuncio->caminho_arquivo) ?>" alt="<?= htmlspecialchars($anuncio->titulo) ?>" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($anuncio->titulo) ?></h3>
                                <p class="text-xl font-bold text-gray-700 mt-2">R$<?= htmlspecialchars($anuncio->valor) ?></p>
                                <button type="button" 
                                        data-id="<?= htmlspecialchars($anuncio->idAnuncio); ?>"
                                        class="btn-contratar block mx-auto mt-3 px-3 py-1.5 bg-orange-600 text-white text-sm font-medium rounded-md shadow-md hover:bg-orange-500 transition">
                                    Ver detalhes
                                </button>
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">Este comerciante não possui anúncios ativos no momento.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>

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
    <script src="./js/ajaxComerciante.js"></script>

</body>
</html>