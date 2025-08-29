<?php
namespace App\Models;

use Config\Database;
use PDO;

class Module {
    public int $id;
    public string $name;
    public string $description;

    // Récupère tous les modules
    public static function all(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM modules ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Trouve un module par son ID
    public static function find(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM modules WHERE id = ?");
        $stmt->execute([$id]);
        $module = $stmt->fetch(PDO::FETCH_ASSOC);
        return $module ?: null;
    }

    // Enregistre un module
    public function save(): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO modules (name, description) VALUES (?, ?)");
        return $stmt->execute([$this->name, $this->description]);
    }

    // Supprime un module
    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM modules WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
