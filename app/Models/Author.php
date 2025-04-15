<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Author {
    public static function getById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM authors WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function getBooks(int $authorId): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT books.*, genres.name AS genre_name
            FROM books
            LEFT JOIN genres ON books.genre_id = genres.id
            WHERE books.author_id = :id
            ORDER BY books.title ASC
        ");
        $stmt->execute(['id' => $authorId]);
        return $stmt->fetchAll();
    }

    public static function getAllAuthors(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM authors ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
