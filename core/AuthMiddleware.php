<?php
namespace Core;

class AuthMiddleware {

    // Vérifie si l’utilisateur est connecté
    public static function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }

    // Vérifie un rôle spécifique (ex: admin uniquement)
    public static function requireRole(string $role) {
        self::requireLogin();
        if ($_SESSION['user']['role'] !== $role) {
            http_response_code(403);
            echo "⛔ Accès interdit - rôle requis: $role";
            exit;
        }
    }

    // Vérifie plusieurs rôles (ex: personnel + admin)
    public static function requireAny(array $roles) {
        self::requireLogin();
        if (!in_array($_SESSION['user']['role'], $roles)) {
            http_response_code(403);
            echo "⛔ Accès interdit - rôles requis: " . implode(", ", $roles);
            exit;
        }
    }
}
