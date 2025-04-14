<?php
namespace App\Controllers;

class HomeController {
    public function index() {
        $title = 'Accueil | BookHub';
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/home/index.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }
}