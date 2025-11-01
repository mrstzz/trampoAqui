<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use Classes\Cliente; //login como cliente
use Classes\Comerciante; // ou login como comerciante
use Classes\Conexao; //conexao pdo

$db = new Conexao();
$clienteModel = new Cliente($db);
$comercianteModel = new Comerciante($db);


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /login");
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    $_SESSION['flash_error'] = 'Email e senha são obrigatórios.';
    header("Location: /login");
    exit; 
}

// Tento logar como Cliente
$cliente = $clienteModel->buscaEmailCliente($email);

if ($cliente && password_verify($senha, $cliente['senha'])) {
    // Login como cliente bem-sucedido salva sessão
    $_SESSION['user_id'] = $cliente['id'];
    $_SESSION['user_name'] = $cliente['nome'];
    $_SESSION['user_type'] = 'cliente'; // Define o tipo de usuário

    header("Location: /painel-cliente");
    exit;
}

// Se não der cento, tento logar como Comerciante
$comerciante = $comercianteModel->buscaEmailComerciante($email);
    if ($comerciante && password_verify($senha, $comerciante['senha'])) {
        // Login como comerciante bem-sucedido
        $_SESSION['user_id'] = $comerciante['id'];
        $_SESSION['user_name'] = $comerciante['nome']; 
        $_SESSION['user_type'] = 'comerciante';

        // Redireciona para o painel do comerciante
        header("Location: /painel-comerciante");
        exit;
    }
// Se chegou aqui, o login falhou
$_SESSION['flash_error'] = 'Email ou senha inválidos.';
header("Location: /login");
exit;
