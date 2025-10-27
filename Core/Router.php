<?php
// core/Router.php
namespace Core; // Adicionado Namespace

use Exception; // Para lançar exceções

class Router {
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Carrega as definições de rotas de um arquivo.
     *
     * @param string $file Caminho para o arquivo de rotas.
     * @return Router Instância do Router para encadeamento.
     */
    public static function load(string $file): Router {
        // Cria uma nova instância do router
        $router = new static; // Permite herança se necessário

        // Inclui o arquivo de rotas. O arquivo deve usar $router->get(...) etc.
        require $file;

        return $router;
    }

    /**
     * Define uma rota GET.
     *
     * @param string $uri Rota URI.
     * @param string $controllerAction Controller@metodo.
     */
    public function get(string $uri, string $controllerAction) {
        $this->routes['GET'][$uri] = $controllerAction;
    }

    /**
     * Define uma rota POST.
     *
     * @param string $uri Rota URI.
     * @param string $controllerAction Controller@metodo.
     */
    public function post(string $uri, string $controllerAction) {
        $this->routes['POST'][$uri] = $controllerAction;
    }

    /**
     * Direciona a requisição para o controller/método correto.
     *
     * @param string $uri URI da requisição atual.
     * @param string $requestType Método HTTP (GET, POST).
     * @return mixed Resultado da execução do método do controller.
     * @throws Exception Se a rota não for encontrada ou o controller/método for inválido.
     */
    public function direct(string $uri, string $requestType) {
        
        // Tenta encontrar uma rota exata
        if (array_key_exists($uri, $this->routes[$requestType])) {
            $actionParts = explode('@', $this->routes[$requestType][$uri]);
            $controller = $actionParts[0];
            $action = $actionParts[1];

            return $this->callAction(
                $controller,
                $action,
                [] // Passa um array vazio pois não há parâmetros de URL
            );
        }

        // Tenta encontrar uma rota com parâmetros (ex: perfil/(\d+))
        foreach ($this->routes[$requestType] as $route => $controllerAction) {
            // Converte a rota em uma regex (simplificado)
            $pattern = preg_replace('/\(.+?\)/', '([^/]+)', $route);
            $pattern = "#^" . str_replace('/', '\/', $pattern) . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                // Remove a string completa da URI dos matches
                array_shift($matches);

                // Separa controller e ação para rotas com regex
                $actionParts = explode('@', $controllerAction);
                $controller = $actionParts[0];
                $action = $actionParts[1];

                // Chama a ação COM os parâmetros capturados ($matches)
                return $this->callAction(
                    $controller,
                    $action,
                    $matches // Passa os parâmetros capturados pela regex
                );
            }
        }

        // Nenhuma rota encontrada
        $this->notFound();
}

    /**
     * Chama o método do controller especificado.
     *
     * @param string $controller Nome do Controller (sem namespace completo ainda).
     * @param string $action Nome do método.
     * @param array $params Parâmetros da rota (opcional).
     * @return mixed Resultado da execução do método.
     * @throws Exception Se o controller ou método não existir.
     */
    protected function callAction(string $controller, string $action, array $params = []) {
        // Adiciona o namespace padrão dos controllers
        $controller = "App\\Controllers\\{$controller}";

        if (!class_exists($controller)) {
            throw new Exception("Controller {$controller} não encontrado.");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception(
                "O controller {$controller} não responde à ação {$action}."
            );
        }

        // Chama o método, passando os parâmetros da rota
        return $controllerInstance->$action(...$params);
    }

     // Método para tratar rotas não encontradas (opcional, como na versão anterior)
     private function notFound() {
         http_response_code(404);
         echo "Erro 404: Página não encontrada!";
         // Pode carregar uma view de erro 404:
         // require_once __DIR__ . '/../app/Views/errors/404.php';
         exit;
     }
}