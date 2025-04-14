<?php
namespace App\Controllers;

use App\Models\Book;

class BookController {
    public function index() {
        $title = 'Liste des livres | BookHub';
        $books = Book::getAllBooks();
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/index.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function show($id) {
        $title = 'Détail du livre | BookHub';
        $book = Book::getBookById($id);
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/show.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function add() {
        $title = 'Ajouter un livre | BookHub';
        $authors = Book::getAllAuthors();
        $genres = Book::getAllGenres();
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/add.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /books/add');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $author_id = (int) ($_POST['author_id'] ?? 0);
        $genre_id = (int) ($_POST['genre_id'] ?? 0);
        $publication_date = $_POST['publication_date'] ?? null;

        $cover_image = null;
        if (!empty($_FILES['cover_image']['name'])) {
            $targetDir = __DIR__ . '/../../uploads/';
            $filename = uniqid() . '_' . basename($_FILES['cover_image']['name']);
            $targetFile = $targetDir . $filename;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileType, $allowed)) {
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetFile)) {
                    $cover_image = $filename;
                }
            }
        }

        Book::addBook($title, $author_id, $genre_id, $description, $publication_date, $cover_image);
        header('Location: /books');
        exit;
    }

    public function edit($id) {
        $title = 'Modifier un livre | BookHub';
        $book = Book::getBookById($id);
        $authors = Book::getAllAuthors();
        $genres = Book::getAllGenres();
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/edit.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function update($id) {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $author_id = (int) ($_POST['author_id'] ?? 0);
        $genre_id = (int) ($_POST['genre_id'] ?? 0);

        Book::updateBook($id, $title, $author_id, $genre_id, $description);
        header('Location: /books/' . $id);
        exit;
    }

    public function delete($id) {
        Book::deleteBook($id);
        header('Location: /books');
        exit;
    }

    public function addAuthor() {
        $title = 'Ajouter un auteur | BookHub';
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/add_author.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function storeAuthor() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /books/add_author');
            exit;
        }
    
        $name = trim($_POST['name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $birth_date = $_POST['birth_date'] ?? null;
        $death_date = $_POST['death_date'] ?? null;
    
        if (!$name) {
            echo "Le nom de l’auteur est obligatoire.";
            return;
        }
    
        $pdo = \App\Core\Database::getConnection();
    
        $stmt = $pdo->prepare("INSERT INTO authors (name, bio, birth_date, death_date)
                               VALUES (:name, :bio, :birth_date, :death_date)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':death_date', $death_date);
    
        $stmt->execute();
    
        header('Location: /books/add');
        exit;
    }
    

    public function addGenre() {
        $title = 'Ajouter un genre | BookHub';
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/add_genre.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function storeGenre() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /books/add_genre');
            exit;
        }
    
        $name = trim($_POST['name'] ?? '');
    
        if (!$name) {
            echo "Le nom du genre est obligatoire.";
            return;
        }
    
        $pdo = \App\Core\Database::getConnection();
    
        // Vérifie que le genre n’existe pas déjà (optionnel mais propre)
        $check = $pdo->prepare("SELECT COUNT(*) FROM genres WHERE LOWER(name) = LOWER(:name)");
        $check->bindParam(':name', $name);
        $check->execute();
    
        if ($check->fetchColumn() > 0) {
            echo "Ce genre existe déjà.";
            return;
        }
    
        $stmt = $pdo->prepare("INSERT INTO genres (name) VALUES (:name)");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    
        header('Location: /books/add');
        exit;
    }    
}
