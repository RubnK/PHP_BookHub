<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, callable $action): void {
        $this->routes['GET'][] = ['path' => $path, 'action' => $action];
    }

    public function post(string $path, callable $action): void {
        $this->routes['POST'][] = ['path' => $path, 'action' => $action];
    }

    public function run(): void {
        $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if ($uri === '') {
            $uri = '/';
        }
        
        foreach ($this->routes[$method] ?? [] as $route) {
            $pattern = "@^" . $route['path'] . "$@";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // supprime le match complet
                call_user_func_array($route['action'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Page not found";
    }
}
