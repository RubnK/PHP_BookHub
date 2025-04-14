<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BookController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

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
$router->get('/books/add', [new BookController(), 'add']);
$router->post('/books/add', [new BookController(), 'store']);
$router->get('/books/add_author', [new BookController(), 'addAuthor']);
$router->post('/books/add_author', [new BookController(), 'storeAuthor']);
$router->get('/books/add_genre', [new BookController(), 'addGenre']);
$router->post('/books/add_genre', [new BookController(), 'storeGenre']);
$router->post('/reviews/add', [new BookController(), 'storeReview']);

$router->get('/books/(\d+)', function ($id) {
    (new BookController())->show($id);
});
$router->get('/books/(\d+)/edit', function ($id) {
    (new BookController())->edit($id);
});
$router->post('/books/(\d+)/edit', function ($id) {
    (new BookController())->update($id);
});
$router->post('/books/(\d+)/delete', function ($id) {
    (new BookController())->delete($id);
});

$router->run();
