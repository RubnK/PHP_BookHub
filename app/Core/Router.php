<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, callable $action): void {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, callable $action): void {
        $this->routes['POST'][$path] = $action;
    }

    public function run(): void {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $action = $this->routes[$method][$uri] ?? null;

        if ($action) {
            call_user_func($action);
        } else {
            http_response_code(404);
            echo "404 - Page not found";
        }
    }
}
