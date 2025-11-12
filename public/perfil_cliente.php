<?php
// perfil_cliente.php (Página Pública)
require_once __DIR__ . '/../vendor/autoload.php';
require_once './functions.php';
use Classes\Cliente;

$cliente_id = (int)($_GET['id'] ?? 0);
if ($cliente_id === 0) {
    die("Perfil não encontrado.");
}

// 2. Busca todos os dados
$cliente = new Cliente();

$dadoscliente = $cliente->pesquisaCliente($cliente_id);

$caminhoFoto = (!empty($dadoscliente['foto_perfil'])) 
                ? "../uploads/" . htmlspecialchars($dadoscliente['foto_perfil']) 
                : "./icons/user-default.svg"; // Fallback ícone padrão

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Perfil de <?= htmlspecialchars($dadoscliente['nome']) ?></title>
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
                     alt="Foto de <?= htmlspecialchars($dadoscliente['nome']) ?>" 
                     class="w-32 h-32 rounded-full border-4 border-orange-500 object-cover bg-gray-200">
                
                <div class="md:ml-8 mt-4 md:mt-0 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($dadoscliente['nome']) ?></h1>
            </div>
        </div>
        
        <div class="p-8 border-t border-gray-200">
            
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sobre Mim</h2>
            <p class="text-gray-700 leading-relaxed">
                <?= htmlspecialchars($dadoscliente['sobre'] ?? 'Este cliente ainda não escreveu sobre si.') ?>
            </p>
            </div>
        </div>
    </div>
</body>

</html>