<?php
namespace App\Models;

use App\Core\Database;

class CallLog
{
    public static function create(array $data): bool
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO call_logs (user_id, customer_id, provider_used, ai_provider_used, conversation, duration_seconds, lead_status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
        return $stmt->execute([
            $data['user_id'],
            $data['customer_id'],
            $data['provider_used'],
            $data['ai_provider_used'],
            $data['conversation'],
            $data['duration_seconds'],
            $data['lead_status'],
        ]);
    }

    public static function allByUser(int $userId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT cl.*, c.name as customer_name, c.phone FROM call_logs cl JOIN customers c ON c.id=cl.customer_id WHERE cl.user_id = ? ORDER BY cl.id DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
