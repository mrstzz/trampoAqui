<?php
use Classes\Cliente;
use Classes\Comerciante;
use Classes\AuthController;

$clienteModel = new Cliente();
$comercianteModel = new Comerciante();

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
$cliente = $clienteModel->buscaEmailCliente($email);

if ($cliente && password_verify($senha, $cliente['senha'])) {
    // Login como cliente bem-sucedido salva sessão
    $_SESSION['user_id'] = $cliente['id'];
    $_SESSION['user_name'] = $cliente['nome'];
    $_SESSION['user_type'] = 'cliente'; // Define o tipo de usuário

    $this->redirect('/painel-cliente'); // Redireciona para o painel do cliente
}

// Se não der cento, tento logar como Comerciante
$comerciante = $comercianteModel->buscaEmailComerciante($email);
    if ($comerciante && password_verify($senha, $comerciante['senha'])) {
        // Login como comerciante bem-sucedido
        $_SESSION['user_id'] = $comerciante['id'];
        $_SESSION['user_name'] = $comerciante['nome']; 
        $_SESSION['user_type'] = 'comerciante';

        // Redireciona para o painel do comerciante
        header('Location: /painel-comerciante');
        exit();
    }


// Se chegou aqui, o login falhou
$_SESSION['flash_error'] = 'Email ou senha inválidos.';
// Redireciona de volta para o login, mantendo o email preenchido
$this->redirectWithPostData('/login', ['email' => $email]);
