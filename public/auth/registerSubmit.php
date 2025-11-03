<?php
session_start();
require_once __DIR__ . '../../../vendor/autoload.php';

use Classes\Comerciante;
use Classes\Cliente;

$cliente = new Cliente();
$comerciante = new Comerciante();

// print_r($_POST);die;

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
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
    if (empty($nome)) $errors['nome'] = 'O nome é obrigatório.';
    if (empty($email)) $errors['email'] = 'O email é obrigatório.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'O email invlálido.';
    if (empty($senha)) $errors['senha'] = 'A senha é obrigatória.';
    if ($senha !== $confirmaSenha) $errors['senhaDiferentes'] = 'As senhas não são iguais.';
    if (empty($telefone)) $errors['telefone'] = 'O telefone é obrigatório.';
    if (empty($cpf)) $errors['cpf'] = 'O CPF é obrigatório.';
    if ($comerciante->buscaCpfComerciante($cpf)) {
        $errors['cpf'] = 'Este CPF já está cadastrado.';
    }
    if ($comerciante->buscaEmailComerciante($email)) {
        $errors['cpf'] = 'Este Email já está sendo utilizado por outro usuário.';
    }
    if ($cliente->buscaCpfCliente($cpf)) {
        $errors['cpf'] = 'Este CPF já está cadastrado.';
    }
    if ($cliente->buscaEmailCliente($email)) {
        $errors['cpf'] = 'Este Email já está sendo utilizado por outro usuário.';
    }
    if (empty($uf)) $errors['uf'] = 'O estado (UF) é obrigatório.';
    if (empty($cidade)) $errors['cidade'] = 'A cidade é obrigatória.';
    if (!$termos) $errors['privacidade'] = 'Você deve aceitar os termos de privacidade.';
    // --- Fim Validações ---

    // Se houver erros, redireciona de volta com os erros e dados antigos
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        unset($_SESSION['old_input']['senha'], $_SESSION['old_input']['confirma-senha']);
        header("Location: /pages/registrar.php");
        exit();
    }

// --- Criação do Cliente ---
// Hash da senha ANTES de passar para o Model
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    if ($senhaHash === false) {
        $_SESSION['flash_error'] = 'E-mail ou senha inválidos.';
        header("Location: /pages/registrar.php"); // Os dados antigos já estão na sessão
        exit();
    }

$result = $cliente->insereCliente($nome, $email, $senhaHash, $telefone, $cpf, date('Y-m-d H:i:s')); 

if ($result) {
        unset($_SESSION['old_input']); // Limpa dados antigos em caso de sucesso
        $_SESSION['success'] = 'Cadastro realizado com sucesso! Faça o login.';
        header("Location: /pages/login.php");
        exit();
} else {
    $_SESSION['flash_error'] = $result['message'] ?? 'Erro inesperado ao cadastrar. Tente novamente.';
        header("Location: /pages/registrar.php"); // Os dados antigos já estão na sessão
        exit();
}