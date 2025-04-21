<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\Author;

use App\Core\Database;

class BookController {
    public function index() {
        $title = 'Liste des livres | BookHub';
        if (isset($_GET['q'])) {
            $query = trim($_GET['q']);
            $books = Book::searchBooks($query);
        } else {
            $books = Book::getAllBooks();
        }
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/index.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function show($id, $error = null) {
        $book = Book::getBookById($id);
        $title = $book['title'].' | BookHub';
        $reviews = Review::getByBookId($id);
        $hasBook = false;
        if (isset($_SESSION['user'])) {
            $hasBook = Book::userHasBook($_SESSION['user']['id'], $id);
        }

        if ($book['publication_date']) {
            $mois = [
                1 => 'janvier', 2 => 'février', 3 => 'mars',
                4 => 'avril', 5 => 'mai', 6 => 'juin',
                7 => 'juillet', 8 => 'août', 9 => 'septembre',
                10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
            ];
        
            $date = new \DateTime($book['publication_date']);
            $jour = $date->format('j');
            $moisNom = $mois[(int)$date->format('n')];
            $annee = $date->format('Y');
        
            $book['publication_date'] = "$jour $moisNom $annee";
        } else {
            $book['publication_date'] = '';
        }
        

        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/show.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function add() {
        $title = 'Ajouter un livre | BookHub';
        $authors = Author::getAllAuthors();
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
            $targetDir = __DIR__ . '/../../public/uploads/';
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
        $authors = Author::getAllAuthors();
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
    
        $pdo = Database::getConnection();
    
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
    
        $pdo = Database::getConnection();
    
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

    public function storeReview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit;
        }
    
        if (!isset($_SESSION['user'])) {
            echo "Vous devez être connecté pour laisser un avis.";
            return;
        }
    
        $user_id = $_SESSION['user']['id'];
        $book_id = (int) ($_POST['book_id'] ?? 0);
        $rating = (int) ($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');
    
        if ($book_id <= 0 || $rating < 1 || $rating > 5) {
            $error = "Données invalides.";
        }
    
        if (Review::hasUserAlreadyReviewed($book_id, $user_id)) {
            $error = "Vous avez déjà laissé un avis pour ce livre.";
        }

        if (isset($error) && $error) {
            $this->show($book_id, $error);
            return;
        }
    
        Review::add($book_id, $user_id, $rating, $comment);
    
        header("Location: /books/$book_id");
        exit;
    }

    public function deleteReview($id) {
        if (!isset($_SESSION['user'])) {
            echo "Vous devez être connecté pour supprimer un avis.";
            return;
        }
    
        $review = Review::getById($id);
    
        if ($review && $review['user_id'] == $_SESSION['user']['id']) {
            Review::delete($id);
            header("Location: /books/{$review['book_id']}");
            exit;
        } else {
            echo "Vous ne pouvez pas supprimer cet avis.";
        }
    }

    public function addToList($id) {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    
        Book::addToUserList($_SESSION['user']['id'], $id);
        header("Location: /books/$id");
        exit;
    }
    
    public function myBooks() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    
        $title = 'Ma bibliothèque | BookHub';
        $books = Book::getBooksOwnedByUser($_SESSION['user']['id']);
    
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/book/my_books.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function removeFromList($id) {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    
        Book::removeFromUserList($_SESSION['user']['id'], $id);
        header('Location: /my_books');
        exit;
    }
}
