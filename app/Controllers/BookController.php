<?php
namespace App\Controllers;

class BookController {
    public function index() {
        $title = 'Livres | BookHub';
        // TODO: récupérer les livres via Book model
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/index.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function show($id) {
        $title = 'Détail du livre | BookHub';
        // TODO: récupérer les infos du livre via Book model
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/show.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function add() {
        $title = 'Ajouter un livre | BookHub';
        // TODO: récupérer les genres et auteurs
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/add.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function store() {
        // TODO: traitement du formulaire d'ajout
        echo "TODO: ajout livre";
    }
}
