<?php
namespace Config;

class Auth {
    /**
     * Vérifie si l'utilisateur est connecté en tant qu'administrateur
     */
    public static function isAdmin(): bool {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    /**
     * Vérifie si l'utilisateur est connecté (visiteur authentifié)
     */
    public static function isAuthenticated(): bool {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Vérifie si l'utilisateur est un visiteur public (non connecté)
     */
    public static function isPublic(): bool {
        return !self::isAuthenticated() && !self::isAdmin();
    }
    
    /**
     * Récupère le rôle de l'utilisateur connecté
     */
    public static function getUserRole(): string {
        if (self::isAdmin()) {
            return $_SESSION['admin_role'] ?? 'admin';
        }
        if (self::isAuthenticated()) {
            return $_SESSION['user_role'] ?? 'visiteur_auth';
        }
        return 'visiteur';
    }
    
    /**
     * Vérifie si l'utilisateur a les permissions pour voir le lien d'administration
     */
    public static function canAccessAdmin(): bool {
        $role = self::getUserRole();
        return in_array($role, ['admin', 'personnel']);
    }
    
    /**
     * Redirige vers la page de connexion si l'utilisateur n'est pas autorisé
     */
    public static function requireAdmin(): void {
        if (!self::isAdmin()) {
            header('Location: app/views/admin/login.php');
            exit();
        }
    }
    
    /**
     * Redirige vers la page de connexion si l'utilisateur n'est pas connecté
     */
    public static function requireAuth(): void {
        if (!self::isAuthenticated()) {
            header('Location: app/views/Auth/login.php');
            exit();
        }
    }
}
?>
