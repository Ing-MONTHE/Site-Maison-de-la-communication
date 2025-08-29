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
