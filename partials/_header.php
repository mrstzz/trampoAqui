<?php

require_once 'functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

extract($_SESSION);
// pr($_SESSION);

$painel = ($user_type == 'comerciante') ? 'painel_comerciante.php' : 'painel_cliente.php';

$categorias = [
    'Construção e Reformas' => ['Pedreiro', 'Pintor', 'Eletricista', 'Encanador', 'Gesseiro', 'Serralheiro', 'Marceneiro', 'Azuleijista'],
    'Manutenção e Reparos' => ['Técnico de Informática', 'Manutenção de Eletrodomésticos', 'Mecânico de Autos e Motos', 'Chaveiro', 'Vidraceiro'],
    'Limpeza e Conservação' => ['Diarista', 'Faxineiro(a)', 'Jardinagem', 'Detetização', 'Lavagem de Sofás', 'Piscineiro'],
    'Consultoria e Serviços' => ['Contador', 'Advogado', 'Designer Gráfico', 'Marketing Digital', 'Consultoria Empresarial', 'Desenvolvedor de Sites'],
    'Saúde e Bem-estar' => ['Personal Trainer', 'Massoterapeuta', 'Cabeleireiro', 'Esteticista', 'Manicure', 'Nutricionista', 'Psicólogo'],
    'Eventos e Entretenimento' => ['Fotógrafo', 'Filmagem', 'DJ', 'Banda/Músicos', 'Cerimonialista', 'Decoração de Festas', 'Buffet'],
    'Transportes' => ['Motorista Particular', 'Frete / Carretos', 'Mudanças', 'Motoboy / Entregador'],
    'Serviços Domésticos' => ['Babá', 'Cuidador de Idosos', 'Passeador de Cães', 'Adestrador de Animais', 'Costureira'],
    'Educação' => ['Professor Particular', 'Aulas de Dança', 'Aulas de Informática', 'Cursos Profissionalizantes']
];
?>
<link rel="shortcut icon" href="../../assets/images/logo-trampo-aqui-white-new50.png" type="image/x-icon">

<header class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex items-center justify-between space-x-4">
        <div class="flex-shrink-0">
            <a href="index.php">
                <img src="../assets/images/logo-trampo-aqui.png" alt="trampoAqui Logo" class="h-10"> 
            </a>
        </div>

        <div class="hidden md:flex flex-grow justify-center px-4"> 
            <form class="search-bar w-full max-w-3xl flex" action="pesquisa_index.php" method="post">
                <input type="text" name="pesquisa" placeholder="Pesquise aqui..." class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <select name="tipo" class="px-3 py-2 border-t border-b border-gray-300 bg-gray-50 focus:outline-none">
                    <option value="anuncio">Anúncio</option>
                    <option value="comerciante">Comerciante</option>
                    <option value="cliente">Cliente</option>
                    <option value="tags">Tags</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>

        <div class="flex-shrink-0 flex items-center space-x-6">
            
            <div class="hidden lg:block group relative">
                <a href="#" class="text-gray-600 hover:text-indigo-600 font-medium whitespace-nowrap">Categorias</a>
                
                <div class="box-item hidden group-hover:block absolute z-10 right-0 top-full w-max max-w-4xl pt-2">
                    <div class="bg-white shadow-lg rounded-md p-6">
                        <div class="grid grid-cols-3 gap-x-12 gap-y-6">
                            <?php foreach ($categorias as $titulo => $servicos): ?>
                            <ul class="space-y-2">
                                <h1 class="font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($titulo); ?></h1>
                                <?php foreach ($servicos as $servico): ?>
                                <li>
                                    <a href="#" class="text-sm text-gray-600 hover:text-indigo-600"><?php echo htmlspecialchars($servico); ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block border-l border-gray-300 h-6"></div>

            <div class="flex items-center space-x-4">
                <?php if (!isset($_SESSION['user_name'])){?>
                    <a href="pages/auth/login.php" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 hover:text-indigo-600">
                        <img src="../icons/user-circle-check.svg" alt="Usuário" class="h-6 w-6">
                        <span class="hidden md:block whitespace-nowVrap">Faça Login</span>
                    </a>
                <?php }else{?>
                    <span class="hidden lg:block text-sm font-semibold text-indigo-600 whitespace-nowrap">
                        Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                    </span>
                    
                    <a href="pages/<?=$user_type?>/<?=$painel?>" class="flex items-center space-x-2 text-sm text-gray-500 hover:text-indigo-600" title="Acessar Meu Perfil">
                        <img src="../icons/user-default.svg" alt="Usuário" class="h-6 w-6">
                        <span class="hidden xl:block whitespace-nowrap"> Meu Perfil</span> 
                    </a>

                    <a href="auth/logout.php" class="flex items-center space-x-2 text-sm text-red-500 hover:text-red-700" title="Sair">
                        <img src="../icons/sign-in.svg" alt="Sair" class="h-6 w-6">
                        <span class="hidden xl:block whitespace-nowrap"> Sair</span>
                    </a>
                <?php } ?>
            </div>

            <button class="lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

    </nav>
</header>