<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Book {
    public static function getAllBooks(): array {
        $pdo = Database::getConnection();

        $sql = "SELECT books.*, authors.name AS author_name, genres.name AS genre_name
                FROM books
                LEFT JOIN authors ON books.author_id = authors.id
                LEFT JOIN genres ON books.genre_id = genres.id
                ORDER BY books.title ASC";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function getAllGenres(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM genres ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public static function getAllAuthors(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM authors ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public static function getBookById($id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT books.*, authors.name AS author_name, genres.name AS genre_name
                                FROM books
                                LEFT JOIN authors ON books.author_id = authors.id
                                LEFT JOIN genres ON books.genre_id = genres.id
                                WHERE books.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }

    public static function addBook($title, $author_id, $genre_id, $description, $publication_date, $cover_image = null): bool {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO books (title, author_id, genre_id, description, publication_date, cover_image)
                VALUES (:title, :author_id, :genre_id, :description, :publication_date, :cover_image)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':genre_id', $genre_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':publication_date', $publication_date);
        $stmt->bindParam(':cover_image', $cover_image);

        return $stmt->execute();
    }

    public static function updateBook($id, $title, $author_id, $genre_id, $description): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE books SET title = :title, author_id = :author_id, genre_id = :genre_id, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':genre_id', $genre_id);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public static function deleteBook($id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function searchBooks($query): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT books.*, authors.name AS author_name, genres.name AS genre_name
                                FROM books
                                LEFT JOIN authors ON books.author_id = authors.id
                                LEFT JOIN genres ON books.genre_id = genres.id
                                WHERE books.title ILIKE :query OR authors.name ILIKE :query OR genres.name ILIKE :query
                                ORDER BY books.title ASC");
        $searchQuery = "%$query%";
        $stmt->bindParam(':query', $searchQuery);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
