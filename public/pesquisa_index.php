<?php



require_once __DIR__ . '../../vendor/autoload.php';
require_once  './functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


extract($_POST);
extract($_GET);


use Classes\Cliente;
use Classes\Comerciante;


// Validação
if (empty($pesquisa) || empty($tipo)) {
    header("Location: ../index.php?msg=Termo de pesquisa ou tipo inválido!");
    exit;
}

// Instanciação e busca
$busca = []; // Inicializa como array vazio
$cliente = new Cliente();
$comerciante = new Comerciante();

if ($tipo == 'cliente') {
    $busca = $cliente->pesquisaCliente(false, $pesquisa);
} else if ($tipo == 'comerciante') {
    $busca = $comerciante->pesquisaComerciante(NULL, $pesquisa);
} else if ($tipo == 'anuncio') {
    // $anuncio = new Anuncio();
    // $busca = $anuncio->pesquisaAnuncio(false, $pesquisa);
} else if ($tipo == 'tags') {
    // $tag = new Tag();
    // $busca = $tag->pesquisaPorTag($pesquisa);
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados para <?=htmlspecialchars($tipo)?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <?php include_once '../partials/_header.php'?>


    <div class="container mx-auto px-4 py-8 max-w-7xl">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Resultados da Busca</h1>
        <p class="text-lg text-gray-600 mb-6">
            Exibindo resultados para "<?=htmlspecialchars($pesquisa)?>" em "<?=htmlspecialchars($tipo)?>"
        </p>

        <?php if (!empty($pesquisa)) :?>
            
            <?php if (count($busca) > 0) :?>
                
                <div class="columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
                    
                    <?php foreach ($busca as $item) : ?>
                        
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden break-inside-avoid">
                        
                        <div class="p-5 border-b border-gray-200 text-center">
                            <img class="h-24 w-24 rounded-full mx-auto mb-3 shadow-md" 
                                 src="https://ui-avatars.com/api/?name=<?php echo urlencode($item['nome']); ?>&background=e0e7ff&color=4338ca&size=128" 
                                 alt="Foto de <?php echo htmlspecialchars($item['nome']); ?>">
                            
                            <h3 class="text-xl font-semibold text-gray-800">
                                <?php echo htmlspecialchars($item['nome']); ?>
                            </h3>
                            <p class="text-sm text-orange-600">ID: <?php echo htmlspecialchars($item['id']); ?></p>
                        </div>
                        
                        <div class="p-5 text-sm text-gray-600 space-y-3">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C6.84 18 2 13.16 2 8V3z" /></svg>
                                <span class="ml-2"><?php echo htmlspecialchars($item['telefone']); ?></span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                                <span class="ml-2">
                                    Membro desde: <?php echo date_create($item['criado_em'])->format('d/m/Y'); ?>
                                </span>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 text-right">
                            <a href="perfil.php?tipo=<?php echo htmlspecialchars($tipo)?>&id=<?php echo $item['id'] ?? ''?>" 
                               class="px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all duration-200">
                                Ver Perfil
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>

            <?php else : ?>

                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-lg shadow-md" role="alert">
                    <p class="font-bold text-lg">Nenhum resultado encontrado</p>
                    <p>Nenhum <?php echo htmlspecialchars($tipo)?> foi encontrado com o termo "<?php echo htmlspecialchars($pesquisa); ?>". Tente uma busca diferente.</p>
                </div>

            <?php endif; ?>

        <?php else: ?>
            
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg shadow-md" role="alert">
                <p class="font-bold text-lg">Faça uma busca</p>
                <p>Ocorreu um erro ou a busca estava vazia. Por favor, volte ao início e tente novamente.</p>
            </div>

        <?php endif; ?>

    </div>
    
    </body>
</html>