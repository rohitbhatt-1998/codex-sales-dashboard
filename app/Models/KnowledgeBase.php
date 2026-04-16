<?php
namespace App\Models;

use App\Core\Database;

class KnowledgeBase
{
    public static function add(array $data): bool
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO knowledge_base (user_id, file_name, file_type, stored_path, extracted_text, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
        return $stmt->execute([
            $data['user_id'],
            $data['file_name'],
            $data['file_type'],
            $data['stored_path'],
            $data['extracted_text'],
        ]);
    }

    public static function listByUser(int $userId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM knowledge_base WHERE user_id=? ORDER BY id DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function combinedText(int $userId, int $limit = 5000): string
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT extracted_text FROM knowledge_base WHERE user_id=? ORDER BY id DESC LIMIT 20');
        $stmt->execute([$userId]);
        $chunks = [];
        foreach ($stmt->fetchAll() as $row) {
            if (!empty($row['extracted_text'])) {
                $chunks[] = $row['extracted_text'];
            }
        }
        return mb_substr(implode("\n", $chunks), 0, $limit);
    }
}
