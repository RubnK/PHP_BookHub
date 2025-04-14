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
}
