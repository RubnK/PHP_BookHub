<?php
namespace App\Models;

use App\Core\Database;
use PDO;

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

    public static function hasUserAlreadyReviewed(int $bookId, int $userId): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE book_id = :book_id AND user_id = :user_id");
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public static function add(int $bookId, int $userId, int $rating, string $comment): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO reviews (book_id, user_id, rating, comment)
            VALUES (:book_id, :user_id, :rating, :comment)
        ");
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        return $stmt->execute();
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function getAverageRating(int $bookId): float {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT AVG(rating) AS average_rating 
            FROM reviews 
            WHERE book_id = :book_id
        ");
        $stmt->bindParam(':book_id', $bookId);
        $stmt->execute();
        return (float) $stmt->fetchColumn() ?: 0.0;
    }

    public static function getReviewCount(int $bookId): int {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS review_count 
            FROM reviews 
            WHERE book_id = :book_id
        ");
        $stmt->bindParam(':book_id', $bookId);
        $stmt->execute();
        return (int) $stmt->fetchColumn() ?: 0;
    }

    public static function getById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT reviews.*, users.username 
            FROM reviews
            JOIN users ON users.id = reviews.user_id
            WHERE reviews.id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }
}
