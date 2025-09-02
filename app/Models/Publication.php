<?php
namespace App\Models;

use Config\Database;
use PDO;

class Publication {
    public static function findAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM publications ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM publications WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(string $titre, string $contenu, int $moduleId, ?int $auteurId, string $statut = 'brouillon'): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO publications (titre, contenu, module_id, auteur_id, statut) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $contenu, $moduleId, $auteurId, $statut]);
        return (int)$db->lastInsertId();
    }

    public static function update(int $id, string $titre, string $contenu, int $moduleId, ?int $auteurId, string $statut): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE publications SET titre = ?, contenu = ?, module_id = ?, auteur_id = ?, statut = ? WHERE id = ?");
        return $stmt->execute([$titre, $contenu, $moduleId, $auteurId, $statut, $id]);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM publications WHERE id = ?");
        return $stmt->execute([$id]);
    }
}


