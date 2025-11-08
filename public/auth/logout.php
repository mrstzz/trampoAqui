<?php
// 1. INICIA A SESSÃO: Essencial para acessar e manipular a sessão existente.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. LIMPA AS VARIÁVEIS: Remove os dados armazenados no array $_SESSION.
$_SESSION = array(); // Mais robusto do que session_unset()

// 3. EXPIRA O COOKIE DE SESSÃO (A CHAVE PARA O SEU PROBLEMA):
// Isso define o cookie com um tempo no passado (-42000 segundos), forçando o navegador a deletá-lo.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. DESTROI A SESSÃO NO SERVIDOR: Remove o arquivo de sessão.
session_destroy();

// 5. REDIRECIONA: Leva o usuário para a tela de login.
header("Location: ../pages/auth/login.php");
exit;
?>