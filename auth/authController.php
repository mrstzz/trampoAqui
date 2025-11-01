<?php

/**
 * AuthController TrampoAqui
 * @author Matheus Montovaneli
 * @since 27/10/2025
 */


namespace App\Controllers;
use Classes\Cliente; // Usará o model Cliente para autenticação
use Classes\Comerciante; // Pode precisar para diferenciar login
use Classes\Conexao;      // Para obter a conexão PDO

class AuthController {

    private $db;
    private $clienteModel;
    private $comercianteModel; 

    public function __construct() {
        $this->db = new Conexao();
        $this->clienteModel = new Cliente($this->db);
        $this->comercianteModel = new Comerciante($this->db);
    }

    public function showLoginForm() {

        $error = $_SESSION['flash_error'] ?? null;
        $success = $_SESSION['flash_success'] ?? null;
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);

        require_once __DIR__ . '/../Views/login.php';
    }

    // Processa o envio do formulário de login
    public function login_Submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (empty($email) || empty($senha)) {
             $_SESSION['flash_error'] = 'Email e senha são obrigatórios.';
             $this->redirectWithPostData('/login', $_POST); // Redireciona mantendo o POST
        }


        // Tenta logar como Cliente
        $cliente = $this->clienteModel->buscaEmailCliente($email);

        if ($cliente && password_verify($senha, $cliente['senha'])) {
            // Login como cliente bem-sucedido
            $_SESSION['user_id'] = $cliente['id'];
            $_SESSION['user_name'] = $cliente['nome'];
            $_SESSION['user_type'] = 'cliente'; // Define o tipo de usuário

            $this->redirect('/painel-cliente'); // Redireciona para o painel do cliente
        }

        // Tenta logar como Comerciante (ADAPTAR  Comerciante ainda)
        
        $comerciante = $this->comercianteModel->buscaEmailComerciante($email); // Supondo que exista esse método
         if ($comerciante && password_verify($senha, $comerciante['senha'])) {
             // Login como comerciante bem-sucedido
             $_SESSION['user_id'] = $comerciante['id'];
             $_SESSION['user_name'] = $comerciante['nome']; // Ou nome da empresa
             $_SESSION['user_type'] = 'comerciante';

             $this->redirect('/painel-comerciante'); // Redireciona para o painel do comerciante
         }
        

        // Se chegou aqui, o login falhou
        $_SESSION['flash_error'] = 'Email ou senha inválidos.';
        // Redireciona de volta para o login, mantendo o email preenchido
        $this->redirectWithPostData('/login', ['email' => $email]);


    }

    // Exibe o formulário de cadastro
    public function showSignupForm() {
         $error = $_SESSION['flash_error'] ?? null;
         $old_input = $_SESSION['old_input'] ?? []; // Recupera dados antigos
         unset($_SESSION['flash_error'], $_SESSION['old_input']);

        require_once __DIR__ . '/../Views/registrar.php';
    }

    // Processa o envio do formulário de cadastro
    public function Signup_Submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/signup');
        }

        // --- Coleta e Limpeza dos Dados ---
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirmaSenha = $_POST['confirma-senha'] ?? '';
        $telefone = trim($_POST['telefone'] ?? '');
        $cpf = trim($_POST['cpf'] ?? '');
        $uf = trim($_POST['estado'] ?? ''); // Corrigido nome do campo
        $cidade = trim($_POST['cidade'] ?? '');
        $termos = isset($_POST['terms']); // Checkbox

         // Salva dados na sessão para repopular em caso de erro (exceto senhas)
         $_SESSION['old_input'] = $_POST;
         unset($_SESSION['old_input']['senha'], $_SESSION['old_input']['confirma-senha']);


         // --- Validações ---
         $errors = [];
         if (empty($nome)) $errors[] = 'O nome é obrigatório.';
         if (empty($email)) $errors[] = 'O email é obrigatório.';
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'O email fornecido não é válido.';
         if (empty($senha)) $errors[] = 'A senha é obrigatória.';
         if ($senha !== $confirmaSenha) $errors[] = 'As senhas não coincidem.';
         if (empty($telefone)) $errors[] = 'O telefone é obrigatório.';
         // Adicionar validação de formato de telefone se necessário
         if (empty($cpf)) $errors[] = 'O CPF é obrigatório.';
          // Adicionar validação de formato e existência de CPF (implementar no Model)
         if ($this->comercianteModel->buscaCpfComerciante($cpf) /*|| $this->comercianteModel->findByCpf($cpf)*/) {
             $errors[] = 'Este CPF já está cadastrado.';
         }
         if ($this->comercianteModel->buscaEmailComerciante($email) /*|| $this->comercianteModel->findByEmail($email)*/) {
             $errors[] = 'Este Email já está cadastrado.';
         }
         if (empty($uf)) $errors[] = 'O estado (UF) é obrigatório.';
         if (empty($cidade)) $errors[] = 'A cidade é obrigatória.';
         if (!$termos) $errors[] = 'Você deve aceitar os termos de privacidade.';
         // --- Fim Validações ---


         // Se houver erros, redireciona de volta com os erros e dados antigos
         if (!empty($errors)) {
             $_SESSION['flash_error'] = implode('<br>', $errors);
             $this->redirect('/signup'); // Os dados antigos já estão na sessão
         }


        // --- Criação do Cliente ---
        // Hash da senha ANTES de passar para o Model
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
         if ($senhaHash === false) {
              $_SESSION['flash_error'] = 'Erro ao processar a senha.';
              $this->redirect('/signup');
         }


        $result = $this->clienteModel->insereCliente($nome,$email,$senha,$telefone,$uf,$cidade,$termos); 

        if ($result['status'] === 'success') {
             unset($_SESSION['old_input']); // Limpa dados antigos em caso de sucesso
            $_SESSION['flash_success'] = 'Cadastro realizado com sucesso! Faça o login.';
            $this->redirect('/login');
        } else {
            $_SESSION['flash_error'] = $result['message'] ?? 'Erro desconhecido ao cadastrar. Tente novamente.';
             $this->redirect('/signup'); // Os dados antigos já estão na sessão
        }
    }

     // Método de Logout
     public function logout() {
         session_unset();
         session_destroy();
         $this->redirect('/login');
     }


     // Função helper para redirecionar
     private function redirect(string $path) {
         header("Location: " . $path);
         exit;
     }

    // Função helper para redirecionar mantendo dados do POST (para repopular forms)
    private function redirectWithPostData(string $path, array $postData) {
        $_SESSION['old_input'] = $postData; // Salva na sessão
        header("Location: " . $path);
        exit;
    }

}