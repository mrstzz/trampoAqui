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
    <title>Cadastre-se - trampoAqui</title>
    <link rel="stylesheet" href="../assets/css/signup-page.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
        }

        .signup-card {
            width: 100%;
            max-width: 1500px;
            height: 100%;
            border: none;
            border-radius: 8px;
            overflow: hidden; 
        }   
        .terms-column {
            background-color: #e5993e;
            color: #fff;
            padding: 2rem;
            max-height: 750px;
            overflow-y: auto;
        }
        .terms-column .terms-header {
            background-color: #cd853f; 
            padding: 10px 1rem;
            margin: -2rem -2rem 1.5rem -2rem; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

        .logo-image {
            width: 150px;
            height: auto;
            margin-bottom: 2rem;
        }

        .error-inline {
            color: #dc3545;
            font-size: 0.875em;
            display: block;
        }
        
        .form-label {
            font-weight: 500;
        }
        
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        
        <div class="card shadow-lg signup-card">
            
            <div class="row g-0">
                
                <div class="col-md-7 p-4 p-md-5 form-column-content">

                    <form action="../auth/registerSubmit.php" method="POST" class="needs-validation" novalidate>
                        
                        <div class="text-center text-md-start mb-4">
                            <img src="../assets/images/logo-trampo-aqui.png" alt="Logo TrampoAqui" class="logo-image">
                        </div>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="João da Silva"
                                value="<?= htmlspecialchars($_SESSION['nome'] ?? '') ?>" required>
                            <?php if (isset($errors['nome'])): ?>
                                <div class="error-inline"><?= $errors['nome'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email..."
                                value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="error-inline"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF..."
                                value="<?= htmlspecialchars($_SESSION['cpf'] ?? '') ?>" required>
                            <?php if (isset($errors['cpf'])): ?>
                                <div class="error-inline"><?= $errors['cpf'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Telefone..."
                                value="<?= htmlspecialchars($_SESSION['telefone'] ?? '') ?>" required>
                            <?php if (isset($errors['telefone'])): ?>
                                <div class="error-inline"><?= $errors['telefone'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="estado" class="form-label">UF</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="">Selecione um estado</option>
                                    <?php $selectedUf = $_SESSION['estado'] ?? ''; ?>
                                    <?php
                                        // Lista de UFs para repetição
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
                                        foreach ($estados as $uf_abbr => $uf_nome): ?>
                                            <option value="<?= $uf_abbr ?>" <?= ($selectedUf === $uf_abbr) ? 'selected' : '' ?>>
                                                <?= $uf_nome ?>
                                            </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['uf'])): ?>
                                    <div class="error-inline"><?= $errors['uf'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Digite sua cidade..."
                                    value="<?= htmlspecialchars($_SESSION['cidade'] ?? '') ?>" required>
                                <?php if (isset($errors['cidade'])): ?>
                                    <div class="error-inline"><?= $errors['cidade'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite uma senha..." required>
                                <?php if (isset($errors['senha'])): ?>
                                    <div class="error-inline"><?= $errors['senha'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="confirma-senha" class="form-label">Confirme sua senha</label>
                                <input type="password" class="form-control" id="confirma-senha" name="confirma-senha" placeholder="Confirme sua senha..." required>
                                <?php if (isset($errors['senhasDiferentes'])): ?>
                                    <div class="error-inline"><?= $errors['senhasDiferentes'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" value="1"
                                <?= isset($_SESSION['terms']) ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="terms">Eu concordo com os termos de <a href="privacidade.php">privacidade</a> do trampoAqui.</label>
                            <?php if (isset($errors['privacidade'])): ?>
                                <div class="error-inline"><?= $errors['privacidade'] ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 mt-3" style="background-color: #343a40;">Finalizar Cadastro</button>
                    </form>
                </div>

                <div class="col-md-5 d-none d-md-block terms-column">
                    
                    <div class="terms-header text-light">
                        Termos de Privacidade - TrampoAqui
                    </div>
                    
                    <div class=" col-12 termos-privacidade px-3 d-md-block">
                        <p>
                            <strong>1. Introdução</strong>
                            <br>Bem-vindo(a) ao TrampoAqui!
                            <br>Estes Termos de Privacidade explicam como coletamos, utilizamos e protegemos as informações pessoais
                            dos usuários. Nosso compromisso é garantir a transparência, a segurança e o uso responsável dos seus dados.
                        </p>

                        <p>
                            <strong>2. Informações que Coletamos</strong>
                            <br>Ao criar uma conta no TrampoAqui, podemos solicitar as seguintes informações:
                            <ul>
                                <li>Dados de cadastro: nome completo, e-mail, telefone, senha, cidade, e outras informações para
                                    identificação de perfil.</li>
                                <li>Dados de uso: registros de acesso, buscas, mensagens, avaliações e interações realizadas no site.</li>
                                <li>Dados de pagamento (quando aplicável): caso futuramente sejam incluídas transações financeiras.</li>
                                <li>Cookies e dados de navegação: coletados para melhorar a experiência do usuário e personalizar
                                    recomendações.</li>
                            </ul>
                        </p>
                        
                        <p>
                            <strong>3. Como Usamos suas Informações</strong>
                            <br>Os dados coletados têm como finalidade:
                            <ul>
                                <li>Criar e gerenciar sua conta de usuário;</li>
                                <li>Exibir e divulgar seus serviços, produtos ou avaliações;</li>
                                <li>Facilitar a comunicação entre clientes e prestadores por meio do chat interno;</li>
                                <li>Manter a segurança e autenticidade das informações;</li>
                                <li>Cumprir obrigações legais e regulatórias;</li>
                                <li>Enviar notificações sobre atividades, atualizações e novidades da plataforma.</li>
                            </ul>
                        </p>
                        
                        <p>
                            <strong>4. Compartilhamento de Informações</strong>
                            <br>O TrampoAqui não vende, aluga nem compartilha seus dados pessoais com terceiros para fins comerciais.
                        </p>
                        <p>
                            <strong>5. Segurança dos Dados</strong>
                            <br>Adotamos medidas de segurança técnicas e administrativas para proteger suas informações.
                        </p>
                        <p>
                            <strong>6. Direitos do Usuário (LGPD)</strong>
                            <br>De acordo com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018), você tem o direito de:
                            <ul>
                                <li>Confirmar se seus dados são tratados pelo TrampoAqui;</li>
                                <li>Solicitar o acesso, correção ou exclusão de seus dados;</li>
                                <li>Revogar o consentimento para uso de informações pessoais;</li>
                                <li>Solicitar a portabilidade dos dados a outro serviço.</li>
                            </ul>
                            <br>Contato: privacidade@trampoaqui.com.
                        </p>
                        <p>
                            <strong>7. Retenção e Exclusão de Dados</strong>
                            <br>Os dados pessoais serão mantidos enquanto sua conta estiver ativa.
                        </p>
                        <p>
                            <strong>8. Uso de Cookies</strong>
                            <br>Utilizamos cookies para aprimorar o desempenho do site.
                        </p>
                        <p>
                            <strong>9. Alterações Nesta Política</strong>
                            <br>O TrampoAqui poderá atualizar este documento periodicamente.
                        </p>
                        <p>
                            <strong>10. Contato</strong>
                            <br>📩 privacidade@trampoaqui.com
                            <br>🌐 trampoaqui.com
                            <br><br>&copy 2025 - TrampoAqui - Todos os direitos reservados
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>