<?php
namespace App\Models;

use App\Core\Database;

class Review {
    public static function getByBookId($bookId): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT reviews.*, users.username 
            FROM reviews
            JOIN users ON users.id = reviews.user_id
            WHERE reviews.book_id = :book_id
            ORDER BY reviews.created_at DESC
        ");
        $stmt->bindParam(':book_id', $bookId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
