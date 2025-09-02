<?php
namespace App\Models;

use Config\Database;
use PDO;

class Module {
    public static function findAll(): array {
        $db = Database::getConnection();
        // L'admin view attend des colonnes: nom, description, statut, icone, couleur, date_creation, date_modification
        $stmt = $db->query("SELECT * FROM modules ORDER BY nom");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM modules WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(string $nom, ?string $description, string $statut = 'actif', ?string $icone = null, ?string $couleur = '#007bff'): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO modules (nom, description, statut, icone, couleur, date_creation) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$nom, $description, $statut, $icone, $couleur]);
        return (int)$db->lastInsertId();
    }

    public static function update(int $id, string $nom, ?string $description, string $statut = 'actif', ?string $icone = null, ?string $couleur = '#007bff'): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE modules SET nom = ?, description = ?, statut = ?, icone = ?, couleur = ?, date_modification = NOW() WHERE id = ?");
        return $stmt->execute([$nom, $description, $statut, $icone, $couleur, $id]);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM modules WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
