<?php
session_start();

if (isset($_POST['perfil'])) {
    $perfil = $_POST['perfil'];

    // 1. Salva a escolha na sessão
    $_SESSION['perfil'] = $perfil;

    // 2. Redireciona para a página do formulário de cadastro
    header("Location: ../pages/auth/registrar.php"); 
    exit();
} else {
    // Redireciona de volta se a requisição não for válida
    header("Location: ../pages/auth/cliente_comerciante.php");
    exit();
}
