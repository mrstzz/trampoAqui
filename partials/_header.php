<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
            
            <a href="../index.php">
                <img src="../assets/images/logo-trampo-aqui.png" alt="trampoAqui Logo" class="h-10"> </a>

            <div class="hidden md:flex flex-grow max-w-xl mx-4">
                <form class="search-bar w-full flex" action="../pages/pesquisa-index.php" method="post">
                    <input type="text" name="pesquisa" placeholder="Pesquise aqui..." class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <select name="tipo" class="px-3 py-2 border-t border-b border-gray-300 bg-gray-50 focus:outline-none">
                        <option value="anuncio">Anúncio</option>
                        <option value="prestador">Prestador</option>
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

            <div class="flex items-center space-x-20">
                
                <div class="hidden lg:block group relative">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 font-medium">Categorias</a>
                    
                    <div class="box-item hidden group-hover:block absolute z-10 -left-1/2 top-full w-max max-w-4xl pt-2">
                        
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
                <a href="#" class="hidden lg:block text-gray-600 hover:text-indigo-600 font-medium">Torne-se um prestador</a>
                <?php ?>
                <?php if (!isset($_SESSION['user_name'])){?>
                <div class="flex items-center space-x-2 border-l pl-4">
                    <a href="../pages/login.php">
                        <img src="../icons/user-circle-check.svg" alt="Usuário" class="">
                    </a>
                    <a href="../pages/auth/login.php" class="hidden md:block text-sm font-semibold text-gray-700">Faça Login</a>
                </div>
                <?php }else{?>
                    <div class="flex items-center space-x-2 border-l pl-4">
                        <span class="text-sm font-semibold text-indigo-600">
                            Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                        </span>
                    </div>
                <?php } ?>
                <button class="lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>

        </nav>
    </header>