<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    public static function create(string $username, string $email, string $password): bool {
        $pdo = Database::getConnection();
        $hashed = hash('sha256', $password);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed);

        return $stmt->execute();
    }

    public static function findByEmail(string $email): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }
}
