<?php
namespace App\Controllers;
use App\Models\Book;

class HomeController {
    public function index() {
    $title = 'Accueil | BookHub';
    $featured = Book::getRandomBook();
    $topBooks = Book::getTopRatedBooks();

    require_once __DIR__ . '/../Views/includes/header.php';
    require_once __DIR__ . '/../Views/home/index.php';
    require_once __DIR__ . '/../Views/includes/footer.php';
}

}