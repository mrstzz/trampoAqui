<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Comerciante;
use Classes\Cliente;
use Classes\Conexao;

$cliente = new Cliente();
$comerciante = new Comerciante();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registrar.php");
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$uf = trim($_POST['estado'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmaSenha = $_POST['confirma-senha'] ?? '';
$termos = isset($_POST['terms']); // Checkbox


// Salva dados na sessão para repopular em caso de erro (exceto senhas)
$_SESSION['old_input'] = $_POST;
unset($_SESSION['old_input']['senha'], $_SESSION['old_input']['confirma-senha']);

    // --- Validações ---
    $errors = [];
    if (empty($nome)) $errors[] = 'O nome é obrigatório.';
    if (empty($email)) $errors[] = 'O email é obrigatório.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'O email invlálido.';
    if (empty($senha)) $errors[] = 'A senha é obrigatória.';
    if ($senha !== $confirmaSenha) $errors[] = 'As senhas não são iguais.';
    if (empty($telefone)) $errors[] = 'O telefone é obrigatório.';
    if (empty($cpf)) $errors[] = 'O CPF é obrigatório.';
    if ($comerciante->buscaCpfComerciante($cpf)) {
        $errors[] = 'Este CPF já está cadastrado.';
    }
    if ($comerciante->buscaEmailComerciante($email)) {
        $errors[] = 'Este Email já está cadastrado.';
    }
    if (empty($uf)) $errors[] = 'O estado (UF) é obrigatório.';
    if (empty($cidade)) $errors[] = 'A cidade é obrigatória.';
    if (!$termos) $errors[] = 'Você deve aceitar os termos de privacidade.';
    // --- Fim Validações ---


    // Se houver erros, redireciona de volta com os erros e dados antigos
    if (!empty($errors)) {
        $_SESSION['flash_error'] = implode('<br>', $errors);
        header("Location: registrar.php"); // Os dados antigos já estão na sessão
        exit();
    }

// --- Criação do Cliente ---
// Hash da senha ANTES de passar para o Model
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    if ($senhaHash === false) {
        $_SESSION['flash_error'] = 'E-mail ou senha inválidos.';
        header("Location: registrar.php"); // Os dados antigos já estão na sessão
        exit();
    }

$result = $cliente->insereCliente($nome, $email, $senhaHash, $telefone, $uf, $cidade,$termos); 

if ($result['status'] === 'success') {
        unset($_SESSION['old_input']); // Limpa dados antigos em caso de sucesso
        $_SESSION['flash_success'] = 'Cadastro realizado com sucesso! Faça o login.';
        header("Location: login-page.php");
        exit();
} else {
    $_SESSION['flash_error'] = $result['message'] ?? 'Erro inesperado ao cadastrar. Tente novamente.';
        header("Location: ../pages/registrar.php"); // Os dados antigos já estão na sessão
        exit();
}