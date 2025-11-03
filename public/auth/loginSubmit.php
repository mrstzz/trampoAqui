<?php
require __DIR__ . '../../../vendor/autoload.php';
session_start();

use Classes\Cliente; 
use Classes\Comerciante; 

$clienteModel = new Cliente();
$comercianteModel = new Comerciante();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/login.php"); 
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$errors = [];

// --- 1. Validação Campos Vazios ---
if (empty($email) || empty($senha)) {
    $errors['input'] = 'Email e senha são obrigatórios.';
    $_SESSION['errors'] = $errors;
    $_SESSION['old_input'] = ['email' => $email]; 
    header("Location: ../pages/login.php");
    exit; 
}

// --- 2. Tentativa de Login ---
$logado = false;

// Tento logar como Cliente
$cliente = $clienteModel->buscaEmailCliente($email);
print_r($cliente);
print_r($senha);die;

if ($cliente && password_verify($senha, $cliente['senha'])) {

    print_r('a');die;

    
    // Login como cliente bem-sucedido
    $_SESSION['user_id'] = $cliente['id'];
    $_SESSION['user_name'] = $cliente['nome'];
    $_SESSION['user_type'] = 'cliente';
    $logado = true;
    header("Location: ../pages/cliente/painel-cliente.php");
    exit();
}

// Tento logar como Comerciante, SOMENTE se não logou como cliente
if (!$logado) {
    $comerciante = $comercianteModel->buscaEmailComerciante($email);
    if ($comerciante && isset($cliente['senha']) && password_verify($senha, $comerciante['senha'])) {
        // Login como comerciante bem-sucedido
        $_SESSION['user_id'] = $comerciante['id'];
        $_SESSION['user_name'] = $comerciante['nome']; 
        $_SESSION['user_type'] = 'comerciante';
        $logado = true;
        header("Location: ../pages/areaLogada/cliente/painel-comerciante.php");
        exit();
    }
}

// --- 3. Login Falhou (Credenciais Inválidas) ---
if (!$logado) {
    // o email/senha não correspondem a cliente nem a comerciante
    $errors['input'] = 'Email ou senha inválidos.';
    $_SESSION['errors'] = $errors;
    // Mantém o email para pré-preenchimento
    $_SESSION['old_input'] = ['email' => $email]; 
    header("Location: ../pages/login.php");
    exit;
}
