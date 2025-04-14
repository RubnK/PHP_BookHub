<?php
namespace App\Core;

class Router {
    public function run() {
        $uri = $_GET['url'] ?? 'home/index';
        [$controllerName, $method] = explode('/', $uri);
        $controllerClass = 'App\\Controllers\\' . ucfirst($controllerName) . 'Controller';

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $method)) {
                $controller->$method();
                return;
            }
        }
        http_response_code(404);
        echo "Page not found.";
    }
}