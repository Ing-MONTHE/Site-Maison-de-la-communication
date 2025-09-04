<?php
namespace App\Models;

use Config\Database;
use PDO;

class User {
    public static function findAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function existsByUsernameOrEmail(string $username, ?string $email): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(string $username, ?string $email, string $passwordHash, string $role): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $passwordHash, $role]);
        return (int)$db->lastInsertId();
    }

    public static function update(int $id, string $username, ?string $email, ?string $passwordHash, string $role): bool {
        $db = Database::getConnection();
        if ($passwordHash) {
            $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $passwordHash, $role, $id]);
        }
        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([$username, $email, $role, $id]);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

<?php
namespace app\Models;

use PDO;
use Config\Database;

class User {
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public string $role;

    public static function findByEmail(string $email) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(array $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?,?,?,?)");
        return $stmt->execute([
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['role'] ?? 'visiteur_auth'
        ]);
    }
}
