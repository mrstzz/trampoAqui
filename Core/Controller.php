<?php
// core/Controller.php

namespace App\Core;

/**
 * Controller base do qual todos os outros controllers herdarão.
 * Contém métodos úteis como renderização de views e redirecionamento.
 */
class Controller {
    /**
     * Renderiza uma view.
     * @param string $view O nome do arquivo da view (sem .php).
     * @param array $data Dados a serem extraídos e disponibilizados para a view.
     */
    protected function view($view, $data = []) {
        // Transforma as chaves do array em variáveis
        extract($data);

        // O caminho completo para o arquivo da view
        $viewPath = __DIR__ . "/../app/Views/{$view}.php";

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            // Lida com o caso de a view não existir
            die("View não encontrada: {$viewPath}");
        }
    }

    /**
     * Redireciona o usuário para uma nova URL.
     * @param string $path O caminho para o qual redirecionar.
     */
    protected function redirect($path) {
        header("Location: {$path}");
        exit();
    }

    /**
     * Middleware de autenticação simples.
     * Verifica se o usuário está logado na sessão. Se não, redireciona para o login.
     */
    protected function authCheck() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}
