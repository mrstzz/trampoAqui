<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trampoAqui - Bem vindo de volta!</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif']
                    },
                    colors: {
                        'trampo-orange': '#FF7F00', // Laranja principal
                        'trampo-blue': '#2563EB', // Azul principal
                        'trampo-dark-orange': '#E56D00' // Laranja mais escuro para o degradê
                    }
                }
            }
        }
    </script>
</head>
<body class="font-poppins">

    <div class="flex min-h-screen">
        
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-trampo-orange to-trampo-dark-orange items-center justify-center p-12 relative overflow-hidden">
            <h1 class="text-white text-6xl font-extrabold z-10 drop-shadow-lg">trampoAqui</h1>
            
            <div class="absolute inset-0 bg-black opacity-10"></div>
            
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-white opacity-5 rounded-full filter blur-3xl"></div>
            <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-white opacity-5 rounded-full filter blur-3xl"></div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-100 p-8">
            
            <form class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md" action="/auth/loginSubmit.php" method="POST">
                
                <div class="flex justify-center mb-6">
                    <img src="../assets/images/logo-trampo-aqui.png" alt="TrampoAqui Logo" class="w-32">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input 
                        type="text" 
                        id="email"
                        name="email" 
                        placeholder="Insira seu e-mail..." 
                        value="<?= htmlspecialchars($old_input['email'] ?? '') ?>"
                        class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                    >
                </div>

                <div class="mb-6">
                    <label for="senha" class="block text-gray-700 text-sm font-semibold mb-2">Senha</label>
                    <input 
                        type="password" 
                        id="senha"
                        name="senha" 
                        placeholder="Digite sua senha..."
                        class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                    >
                </div>

                <?php if (isset($errors['input'])): ?> 
                    <div class="text-red-500 text-sm mb-4 text-center font-medium">
                        <?= $errors['input'] ?>
                    </div>
                <?php endif; ?>

                <button 
                    type="submit"
                    class="w-full bg-trampo-blue text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-trampo-blue focus:ring-offset-2"
                >
                    Entrar
                </button>
                
                <div class="text-center mt-6">
                    <a href="registrar.php" class="text-sm text-trampo-blue hover:text-blue-800 transition-colors">
                        Criar uma Conta
                    </a>
                </div>

            </form>
        </div>

    </div>
    <footer class="w-full bg-gray-800 text-gray-300 text-center p-8">
        &copy; Todos os Direitos Reservados - trampoAqui 2025
    </footer>


</body>
</html>