<?php
// public/index.php

// Exibe erros para depuração (REMOVER na etapa final, somente pra debug )
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Carrega o autoloader do Composer
$autoloader = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloader)) {
    die("Erro: Execute 'composer install'. Autoloader não encontrado.");
}
require_once $autoloader;

// 2. Carrega as variáveis de ambiente
try {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)); // Aponta para a raiz do projeto
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    die("Erro: Arquivo .env não encontrado na raiz do projeto.");
}

// 3. Inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// 6. Roteamento
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
// Remove query string da URI, se houver
$uri = strtok($uri, '?');
$method = $_SERVER['REQUEST_METHOD'];

try {
    Core\Router::load(dirname(__DIR__) . '/routes.php') // Carrega o arquivo de rotas da raiz
        ->direct($uri, $method); // Tenta direcionar para a rota correta
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    die("Erro no Roteamento: " . $e->getMessage());
}

?>