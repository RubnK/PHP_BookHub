<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();

$router = new Router();
$router->run();