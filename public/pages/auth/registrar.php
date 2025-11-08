<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);

// Lista de UFs (movida para cima para organizar o HTML)
$estados = [
    'AC' => 'Acre (AC)', 'AL' => 'Alagoas (AL)', 'AP' => 'Amapá (AP)',
    'AM' => 'Amazonas (AM)', 'BA' => 'Bahia (BA)', 'CE' => 'Ceará (CE)',
    'DF' => 'Distrito Federal (DF)', 'ES' => 'Espírito Santo (ES)', 'GO' => 'Goiás (GO)',
    'MA' => 'Maranhão (MA)', 'MT' => 'Mato Grosso (MT)', 'MS' => 'Mato Grosso do Sul (MS)',
    'MG' => 'Minas Gerais (MG)', 'PA' => 'Pará (PA)', 'PB' => 'Paraíba (PB)',
    'PR' => 'Paraná (PR)', 'PE' => 'Pernambuco (PE)', 'PI' => 'Piauí (PI)',
    'RJ' => 'Rio de Janeiro (RJ)', 'RN' => 'Rio Grande do Norte (RN)', 'RS' => 'Rio Grande do Sul (RS)',
    'RO' => 'Rondônia (RO)', 'RR' => 'Roraima (RR)', 'SC' => 'Santa Catarina (SC)',
    'SP' => 'São Paulo (SP)', 'SE' => 'Sergipe (SE)', 'TO' => 'Tocantins (TO)'
];
$selectedUf = $old_input['estado'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se - trampoAqui</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    
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
                        'trampo-dark-orange': '#E56D00', // Laranja mais escuro para o degradê
                        'trampo-light-orange': '#FFD7A0' // Laranja mais claro para o header dos termos
                    }
                }
            }
        }
    </script>
</head>

<body class="font-poppins bg-gray-100 flex flex-col min-h-screen">

    <main class="flex-1 flex items-center justify-center py-8 px-4">

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-6xl">
            <div class="flex flex-col md:flex-row">

                    <div class="w-full md:w-7/12 p-6 md:p-10 overflow-y-auto">
                    <form action="../../auth/registerSubmit.php" method="POST" class="space-y-4">
                        
                        <div class="text-center md:text-left mb-6">
                            <a href="../../index.php">
                                <img src="../../assets/images/logo-trampo-aqui.png" alt="Logo TrampoAqui" class="w-28 mx-auto md:mx-0">
                            </a>
                        </div>

                        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Crie sua conta</h2>

                        <div>
                            <label for="nome" class="block text-gray-700 text-sm font-semibold mb-2">Nome Completo</label>
                            <input type="text" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                id="nome" name="nome" placeholder="João da Silva"
                                value="<?= htmlspecialchars($old_input['nome'] ?? '') ?>">
                            <?php if (isset($errors['nome'])): ?>
                                <div class="text-red-500 text-xs mt-1"><?= $errors['nome'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                id="email" name="email" placeholder="seu.email@example.com"
                                value="<?= htmlspecialchars($old_input['email'] ?? '') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="text-red-500 text-xs mt-1"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="cpf" class="block text-gray-700 text-sm font-semibold mb-2">CPF</label>
                            <input type="text" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                id="cpf" name="cpf" placeholder="000.000.000-00"
                                value="<?= htmlspecialchars($old_input['cpf'] ?? '') ?>">
                            <?php if (isset($errors['cpf'])): ?>
                                <div class="text-red-500 text-xs mt-1"><?= $errors['cpf'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="data_nascimento" class="block text-gray-700 text-sm font-semibold mb-2">Data de Nascimento</label>
                            <input type="date" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                id="data_nascimento" name="data_nascimento" placeholder="dd/mm/aaaa"
                                value="<?= htmlspecialchars($old_input['data_nascimento'] ?? '') ?>">
                            <?php if (isset($errors['data_nascimento'])): ?>
                                <div class="text-red-500 text-xs mt-1"><?= $errors['data_nascimento'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="telefone" class="block text-gray-700 text-sm font-semibold mb-2">Telefone</label>
                            <input type="tel" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX"
                                value="<?= htmlspecialchars($old_input['telefone'] ?? '') ?>">
                            <?php if (isset($errors['telefone'])): ?>
                                <div class="text-red-500 text-xs mt-1"><?= $errors['telefone'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="estado" class="block text-gray-700 text-sm font-semibold mb-2">UF</label>
                                <select class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                    id="estado" name="estado">
                                    <option value="">Selecione um estado</option>
                                    <?php foreach ($estados as $uf_abbr => $uf_nome): ?>
                                        <option value="<?= $uf_abbr ?>" <?= ($selectedUf === $uf_abbr) ? 'selected' : '' ?>>
                                            <?= $uf_nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['estado'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= $errors['estado'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <label for="cidade" class="block text-gray-700 text-sm font-semibold mb-2">Cidade</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                    id="cidade" name="cidade" placeholder="Digite sua cidade..."
                                    value="<?= htmlspecialchars($old_input['cidade'] ?? '') ?>">
                                <?php if (isset($errors['cidade'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= $errors['cidade'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="senha" class="block text-gray-700 text-sm font-semibold mb-2">Senha</label>
                                <input type="password" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                    id="senha" name="senha" placeholder="Digite uma senha...">
                                <?php if (isset($errors['senha'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= $errors['senha'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <label for="confirma-senha" class="block text-gray-700 text-sm font-semibold mb-2">Confirme sua senha</label>
                                <input type="password" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-trampo-orange"
                                    id="confirma-senha" name="confirma-senha" placeholder="Confirme sua senha...">
                                <?php if (isset($errors['senhasDiferentes'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= $errors['senhasDiferentes'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="pt-2">
                            <div class="flex items-start">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-trampo-orange rounded focus:ring-trampo-orange mt-1"
                                    id="terms" name="terms" value="1"
                                    <?= isset($old_input['terms']) ? 'checked' : '' ?>>
                                <label class="ml-2 text-sm text-gray-600" for="terms">Eu concordo com os termos de <a href="privacidade.php" class="text-trampo-blue hover:underline">privacidade</a> do trampoAqui.</label>
                            </div>
                            <?php if (isset($errors['terms'])): ?> 
                                <div class="text-red-500 text-xs mt-1 ml-6"><?= $errors['terms'] ?></div>
                            <?php elseif (isset($errors['privacidade'])): ?> 
                                <div class="text-red-500 text-xs mt-1 ml-6"><?= $errors['privacidade'] ?></div>
                            <?php endif; ?>
                        </div>
                        

                        <button type="submit"
                            class="w-full bg-trampo-blue text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-trampo-blue focus:ring-offset-2 !mt-6">
                            Finalizar Cadastro
                        </button>
                        
                        <p class="text-center text-sm text-gray-600 !mt-4">Já tem uma conta? <a href="login.php" class="text-trampo-blue hover:underline">Faça login</a></p>

                    </form>
                </div>

                <div class="hidden md:block md:w-5/12 bg-gradient-to-br from-trampo-orange to-trampo-dark-orange text-white p-8 overflow-y-auto max-h-[800px] rounded-r-xl">
                    
                    <div class="bg-trampo-light-orange bg-opacity-20 backdrop-filter backdrop-blur-sm p-4 -mx-8 -mt-8 mb-6 rounded-t-xl md:rounded-tl-none md:rounded-tr-xl sticky top-0">
                        <h3 class="text-xl font-bold text-white">Termos de Privacidade - TrampoAqui</h3>
                    </div>
                    
                    <div class="space-y-4 text-sm leading-relaxed">
                        <p>
                            <strong>1. Introdução</strong><br>Bem-vindo(a) ao TrampoAqui! Estes Termos de Privacidade explicam como coletamos, utilizamos e protegemos as informações pessoais
                            dos usuários. Nosso compromisso é garantir a transparência, a segurança e o uso responsável dos seus dados.
                        </p>

                        <p>
                            <strong>2. Informações que Coletamos</strong><br>Ao criar uma conta no TrampoAqui, podemos solicitar as seguintes informações:
                            <ul class="list-disc pl-5 mt-1">
                                <li>Dados de cadastro: nome completo, e-mail, telefone, senha, cidade, e outras informações para
                                    identificação de perfil.</li>
                                <li>Dados de uso: registros de acesso, buscas, mensagens, avaliações e interações realizadas no site.</li>
                                <li>Dados de pagamento (quando aplicável): caso futuramente sejam incluídas transações financeiras.</li>
                                <li>Cookies e dados de navegação: coletados para melhorar a experiência do usuário e personalizar
                                    recomendações.</li>
                            </ul>
                        </p>
                        
                        <p>
                            <strong>3. Como Usamos suas Informações</strong><br>Os dados coletados têm como finalidade:
                            <ul class="list-disc pl-5 mt-1">
                                <li>Criar e gerenciar sua conta de usuário;</li>
                                <li>Exibir e divulgar seus serviços, produtos ou avaliações;</li>
                                <li>Facilitar a comunicação entre clientes e prestadores por meio do chat interno;</li>
                                <li>Manter a segurança e autenticidade das informações;</li>
                                <li>Cumprir obrigações legais e regulatórias;</li>
                                <li>Enviar notificações sobre atividades, atualizações e novidades da plataforma.</li>
                            </ul>
                        </p>
                        
                        <p>
                            <strong>4. Compartilhamento de Informações</strong><br>O TrampoAqui não vende, aluga nem compartilha seus dados pessoais com terceiros para fins comerciais.
                        </p>
                        <p>
                            <strong>5. Segurança dos Dados</strong><br>Adotamos medidas de segurança técnicas e administrativas para proteger suas informações.
                        </p>
                        <p>
                            <strong>6. Direitos do Usuário (LGPD)</strong><br>De acordo com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018), você tem o direito de:
                            <ul class="list-disc pl-5 mt-1">
                                <li>Confirmar se seus dados são tratados pelo TrampoAqui;</li>
                                <li>Solicitar o acesso, correção ou exclusão de seus dados;</li>
                                <li>Revogar o consentimento para uso de informações pessoais;</li>
                                <li>Solicitar a portabilidade dos dados a outro serviço.</li>
                            </ul>
                            <br>Contato: privacidade@trampoaqui.com.
                        </p>
                        <p>
                            <strong>7. Retenção e Exclusão de Dados</strong><br>Os dados pessoais serão mantidos enquanto sua conta estiver ativa.
                        </p>
                        <p>
                            <strong>8. Uso de Cookies</strong><br>Utilizamos cookies para aprimorar o desempenho do site.
                        </p>
                        <p>
                            <strong>9. Alterações Nesta Política</strong><br>O TrampoAqui poderá atualizar este documento periodicamente.
                        </p>
                        <p>
                            <strong>10. Contato</strong><br>📩 privacidade@trampoaqui.com<br>🌐 trampoaqui.com<br><br>&copy 2025 - TrampoAqui - Todos os direitos reservados
                        </p>
                    </div>

                </div>

            </div>
        </div>

    </main> 
    <footer class="w-full bg-gray-800 text-gray-300 text-center p-8">
        &copy; Todos os Direitos Reservados - trampoAqui 2025
    </footer>

</body>
</html>