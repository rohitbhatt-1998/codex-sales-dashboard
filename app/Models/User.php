<?php
namespace App\Models;

use App\Core\Database;

class User
{
    public static function create(array $data): bool
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())');
        return $stmt->execute([$data['name'], $data['email'], password_hash($data['password'], PASSWORD_BCRYPT), $data['role'] ?? 'user']);
    }

    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function exists(): bool
    {
        $pdo = Database::connection();
        return (bool)$pdo->query('SELECT id FROM users LIMIT 1')->fetch();
    }
}
