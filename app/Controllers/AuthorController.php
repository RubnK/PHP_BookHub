<?php

namespace App\Controllers;

use App\Models\Author;

class AuthorController {
    public function show($id) {
        $author = Author::getById($id);
        if (!$author) {
            http_response_code(404);
            echo "Auteur introuvable.";
            return;
        }

        $books = Author::getBooks($id);
        $title = $author['name'] . " | BookHub";

        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/author_show.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }
}
