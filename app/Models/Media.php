<?php
namespace App\Models;

use Config\Database;
use PDO;

class Media {
    public static function findAllByPublication(int $publicationId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM media WHERE publication_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$publicationId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(?int $publicationId, string $type, string $chemin, string $format, int $taille): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO media (publication_id, type, chemin, format, taille) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$publicationId, $type, $chemin, $format, $taille]);
        return (int)$db->lastInsertId();
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM media WHERE id = ?");
        return $stmt->execute([$id]);
    }
}


