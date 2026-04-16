<?php
namespace App\Models;

use App\Core\Database;

class Setting
{
    public static function get(string $key, ?string $default = null): ?string
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1');
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row['setting_value'] ?? $default;
    }

    public static function set(string $key, string $value): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()');
        $stmt->execute([$key, $value]);
    }

    public static function all(): array
    {
        $pdo = Database::connection();
        $rows = $pdo->query('SELECT setting_key, setting_value FROM settings')->fetchAll();
        $mapped = [];
        foreach ($rows as $row) {
            $mapped[$row['setting_key']] = $row['setting_value'];
        }
        return $mapped;
    }
}
