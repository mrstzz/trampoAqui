<?php
require __DIR__ . '../../../vendor/autoload.php';
require  '../functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


use Classes\Cliente; 
use Classes\Comerciante; 

$clienteModel = new Cliente();
$comercianteModel = new Comerciante();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/auth/login.php"); 
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'];
$errors = [];

// --- 1. Validação Campos Vazios ---
if (empty($email) || empty($senha)) {
    $errors['input'] = 'Email e senha são obrigatórios.';
    $_SESSION['errors'] = $errors;
    $_SESSION['old_input'] = ['email' => $email]; 
    header("Location: ../pages/auth/login.php");
    exit; 
}

// Tento logar como Comerciante, SOMENTE se não logou como cliente
$comerciante = $comercianteModel->buscaEmailComerciante($email);
if ($comerciante && password_verify($senha, $comerciante['senha'])) {
    // Login como comerciante bem-sucedido
    $_SESSION['user_id'] = $comerciante['id'];
    $_SESSION['user_name'] = $comerciante['nome']; 
    $_SESSION['user_type'] = 'comerciante';
    header("Location: ../pages/comerciante/painel_comerciante.php");
    exit();
}

// Tento logar como Cliente
$cliente = $clienteModel->buscaEmailCliente($email);
if ($cliente && password_verify($senha, $cliente['senha'])) {  
    // Login como cliente bem-sucedido
    $_SESSION['user_id'] = $cliente['id'];
    $_SESSION['user_name'] = $cliente['nome'];
    $_SESSION['user_email'] = $cliente['email'];
    $_SESSION['user_type'] = 'cliente';
    header("Location: ../pages/cliente/painel_cliente.php");
    exit();
}

// --- Login Falhou (Credenciais Inválidas) ---
if (!$cliente && !$comerciante) {
    // o email/senha não correspondem a cliente nem a comerciante
    $errors['input'] = 'Email ou senha inválidos.';
    $_SESSION['errors'] = $errors;
    // Mantém o email para pré-preenchimento
    $_SESSION['old_input'] = ['email' => $email]; 
    header("Location: ../pages/auth/login.php");
    exit;
}
