<?php
namespace Core;

class Router {
    private $rotas = [];

    public function add($rota, $callback) {
        $this->rotas[$rota] = $callback;
    }

    public function dispatch($rota) {
        if (isset($this->rotas[$rota])) {
            call_user_func($this->rotas[$rota]);
        } else {
            echo "Erro: Rota não encontrada!";
        }
    }
}
