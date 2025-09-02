<?php
session_start();
require_once '../../config/Database.php';
require_once '../../config/Auth.php';
use Config\Database;
use Config\Auth;

class AuthController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function handleRequest() {
        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->register();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                $this->showLogin();
                break;
        }
    }
    
    private function login() {
        $identifier = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($identifier) || empty($password)) {
            header('Location: /Site-Maison-de-la-communication/app/views/Auth/login.php?error=Identifiants manquants');
            return;
        }
        
        // Recherche de l'utilisateur par email ou username (visiteur/personnel)
        $stmt = $this->db->prepare("SELECT * FROM users WHERE (email = ? OR username = ?) AND role IN ('visiteur', 'visiteur_auth', 'personnel')");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !password_verify($password, $user['password'])) {
            header('Location: /Site-Maison-de-la-communication/app/views/Auth/login.php?error=Identifiants incorrects');
            return;
        }
        
        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_email'] = $user['email'];
        
        header('Location: /Site-Maison-de-la-communication/index.php?success=Connexion réussie');
    }
    
    private function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (empty($username) || empty($email) || empty($password)) {
            header('Location: /Site-Maison-de-la-communication/app/views/Auth/register.php?error=Tous les champs sont requis');
            return;
        }
        
        if ($password !== $confirm_password) {
            header('Location: /Site-Maison-de-la-communication/app/views/Auth/register.php?error=Les mots de passe ne correspondent pas');
            return;
        }
        
        // Vérifier si l'utilisateur existe déjà
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            header('Location: /Site-Maison-de-la-communication/app/views/Auth/register.php?error=Utilisateur déjà existant');
            return;
        }
        
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password, role) 
                VALUES (?, ?, ?, 'visiteur_auth')
            ");
            $stmt->execute([$username, $email, $hashedPassword]);
            
            header('Location: /Site-Maison-de-la-communication/app/views/Auth/login.php?success=Compte créé avec succès');
        } catch (Exception $e) {
            header('Location: /Site-Maison-de-la-communication/app/views/Auth/register.php?error=Erreur lors de la création du compte');
        }
    }
    
    private function logout() {
        // Supprimer les variables de session utilisateur (pas admin)
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_email']);
        
        header('Location: /Site-Maison-de-la-communication/index.php?success=Déconnexion réussie');
    }
    
    private function showLogin() {
        // Rediriger vers la page de connexion si pas d'action spécifique
        header('Location: /Site-Maison-de-la-communication/app/views/Auth/login.php');
    }
}

// Traitement de la requête
$controller = new AuthController();
$controller->handleRequest();
?>
