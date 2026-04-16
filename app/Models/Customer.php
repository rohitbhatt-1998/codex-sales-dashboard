<?php
namespace App\Models;

use App\Core\Database;

class Customer
{
    public static function allByUser(int $userId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM customers WHERE user_id = ? ORDER BY id DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function findByUser(int $id, int $userId): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM customers WHERE id = ? AND user_id = ? LIMIT 1');
        $stmt->execute([$id, $userId]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): bool
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO customers (user_id, name, phone, custom_fields, call_status, created_at, updated_at) VALUES (?, ?, ?, ?, "Not Called", NOW(), NOW())');
        return $stmt->execute([$data['user_id'], $data['name'], $data['phone'], json_encode($data['custom_fields'] ?? [])]);
    }

    public static function update(int $id, int $userId, array $data): bool
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('UPDATE customers SET name=?, phone=?, custom_fields=?, updated_at=NOW() WHERE id=? AND user_id=?');
        return $stmt->execute([$data['name'], $data['phone'], json_encode($data['custom_fields'] ?? []), $id, $userId]);
    }

    public static function delete(int $id, int $userId): bool
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('DELETE FROM customers WHERE id=? AND user_id=?');
        return $stmt->execute([$id, $userId]);
    }

    public static function markStatus(int $id, string $status): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('UPDATE customers SET call_status=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([$status, $id]);
    }

    public static function findByIdsForUser(array $ids, int $userId): array
    {
        if (empty($ids)) {
            return [];
        }
        $pdo = Database::connection();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $params = array_merge($ids, [$userId]);
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE id IN ($placeholders) AND user_id = ?");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function dashboardStats(int $userId): array
    {
        $pdo = Database::connection();
        $stats = [
            'total' => 0,
            'completed' => 0,
            'pending' => 0,
            'failed' => 0,
        ];
        $stmt = $pdo->prepare('SELECT COUNT(*) AS count FROM customers WHERE user_id=?');
        $stmt->execute([$userId]);
        $stats['total'] = (int)$stmt->fetch()['count'];

        foreach (['Completed' => 'completed', 'Not Called' => 'pending', 'Failed' => 'failed'] as $db => $k) {
            $s = $pdo->prepare('SELECT COUNT(*) AS count FROM customers WHERE user_id=? AND call_status=?');
            $s->execute([$userId, $db]);
            $stats[$k] = (int)$s->fetch()['count'];
        }

        return $stats;
    }
}
