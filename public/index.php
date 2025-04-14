<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BookController;

$router = new Router();

$router->get('/', [new HomeController(), 'index']);

// Auth
$router->get('/login', [new AuthController(), 'login']);
$router->post('/login', [new AuthController(), 'doLogin']);
$router->get('/register', [new AuthController(), 'register']);
$router->post('/register', [new AuthController(), 'doRegister']);
$router->get('/logout', [new AuthController(), 'logout']);

// Books
$router->get('/books', [new BookController(), 'index']);
$router->get('/book/add', [new BookController(), 'add']);
$router->post('/book/add', [new BookController(), 'store']);
$router->get('/book/(\d+)', function ($id) {
    (new BookController())->show($id);
});

$router->run();
