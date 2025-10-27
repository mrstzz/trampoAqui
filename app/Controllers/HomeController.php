<?php

namespace App\Controllers;

// use Core\Controller;

class HomeController /*extends Controller*/ {

    public function index() {
        // Carrega a view da página inicial
        require_once __DIR__ . '/../Views/home.php';
    }

    // contatos... sobre... caso precise
}