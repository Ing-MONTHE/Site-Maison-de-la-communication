<?php
session_start();
require_once '../../config/Database.php';
use Config\Database;

class AdminController {
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
            case 'logout':
                $this->logout();
                break;
            case 'createPublication':
                $this->createPublication();
                break;
            case 'updatePublication':
                $this->updatePublication();
                break;
            case 'deletePublication':
                $this->deletePublication();
                break;
            case 'uploadMedia':
                $this->uploadMedia();
                break;
            case 'deleteMedia':
                $this->deleteMedia();
                break;
            case 'createUser':
                $this->createUser();
                break;
            case 'updateUser':
                $this->updateUser();
                break;
            case 'deleteUser':
                $this->deleteUser();
                break;
            case 'createModule':
                $this->createModule();
                break;
            case 'updateModule':
                $this->updateModule();
                break;
            case 'deleteModule':
                $this->deleteModule();
                break;
            default:
                $this->showDashboard();
                break;
        }
    }
    
    private function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            header('Location: ../views/admin/login.php?error=Identifiants manquants');
            return;
        }
        
        // Recherche de l'utilisateur
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND role IN ('admin', 'personnel')");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !password_verify($password, $user['password'])) {
            header('Location: ../views/admin/login.php?error=Identifiants incorrects');
            return;
        }
        
        // Connexion réussie
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_role'] = $user['role'];
        
        header('Location: ../views/admin/dashboard.php');
    }
    
    private function logout() {
        session_destroy();
        header('Location: ../views/admin/login.php');
    }
    
    private function createPublication() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $titre = $_POST['titre'] ?? '';
        $contenu = $_POST['contenu'] ?? '';
        $module_id = $_POST['module_id'] ?? '';
        $auteur_id = $_POST['auteur_id'] ?? null;
        $statut = $_POST['statut'] ?? 'brouillon';
        
        if (empty($titre) || empty($contenu) || empty($module_id)) {
            header('Location: ../views/admin/publications.php?error=Données manquantes');
            return;
        }
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO publications (titre, contenu, module_id, auteur_id, statut) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$titre, $contenu, $module_id, $auteur_id, $statut]);
            
            header('Location: ../views/admin/publications.php?success=Publication créée avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/publications.php?error=Erreur lors de la création');
        }
    }
    
    private function updatePublication() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $id = $_POST['id'] ?? '';
        $titre = $_POST['titre'] ?? '';
        $contenu = $_POST['contenu'] ?? '';
        $module_id = $_POST['module_id'] ?? '';
        $auteur_id = $_POST['auteur_id'] ?? null;
        $statut = $_POST['statut'] ?? 'brouillon';
        
        if (empty($id) || empty($titre) || empty($contenu) || empty($module_id)) {
            header('Location: ../views/admin/publications.php?error=Données manquantes');
            return;
        }
        
        try {
            $stmt = $this->db->prepare("
                UPDATE publications 
                SET titre = ?, contenu = ?, module_id = ?, auteur_id = ?, statut = ? 
                WHERE id = ?
            ");
            $stmt->execute([$titre, $contenu, $module_id, $auteur_id, $statut, $id]);
            
            header('Location: ../views/admin/publications.php?success=Publication mise à jour avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/publications.php?error=Erreur lors de la mise à jour');
        }
    }
    
    private function deletePublication() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $id = $_GET['id'] ?? '';
        
        if (empty($id)) {
            header('Location: ../views/admin/publications.php?error=ID manquant');
            return;
        }
        
        try {
            $stmt = $this->db->prepare("DELETE FROM publications WHERE id = ?");
            $stmt->execute([$id]);
            
            header('Location: ../views/admin/publications.php?success=Publication supprimée avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/publications.php?error=Erreur lors de la suppression');
        }
    }
    
    private function uploadMedia() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        if (!isset($_FILES['media_files']) || empty($_FILES['media_files']['name'][0])) {
            header('Location: ../views/admin/media.php?error=Aucun fichier sélectionné');
            return;
        }
        
        $publication_id = $_POST['publication_id'] ?? null;
        $uploadDir = '../../Images/uploads/';
        
        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $uploadedFiles = [];
        $errors = [];
        
        foreach ($_FILES['media_files']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['media_files']['name'][$key];
            $fileSize = $_FILES['media_files']['size'][$key];
            $fileError = $_FILES['media_files']['error'][$key];
            
            if ($fileError !== UPLOAD_ERR_OK) {
                $errors[] = "Erreur lors de l'upload de $fileName";
                continue;
            }
            
            // Vérification du type de fichier
            $fileInfo = pathinfo($fileName);
            $extension = strtolower($fileInfo['extension']);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mp3', 'wav', 'avi'];
            
            if (!in_array($extension, $allowedExtensions)) {
                $errors[] = "Format non autorisé pour $fileName";
                continue;
            }
            
            // Vérification de la taille (10MB max)
            if ($fileSize > 10 * 1024 * 1024) {
                $errors[] = "Fichier trop volumineux : $fileName";
                continue;
            }
            
            // Génération d'un nom unique
            $uniqueName = uniqid() . '_' . $fileName;
            $filePath = $uploadDir . $uniqueName;
            
            // Détermination du type
            $type = 'image';
            if (in_array($extension, ['mp4', 'avi'])) {
                $type = 'video';
            } elseif (in_array($extension, ['mp3', 'wav'])) {
                $type = 'audio';
            }
            
            // Upload du fichier
            if (move_uploaded_file($tmp_name, $filePath)) {
                try {
                    $stmt = $this->db->prepare("
                        INSERT INTO media (publication_id, type, chemin, format, taille) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([$publication_id, $type, $filePath, $extension, $fileSize]);
                    $uploadedFiles[] = $fileName;
                } catch (Exception $e) {
                    $errors[] = "Erreur base de données pour $fileName";
                    unlink($filePath); // Supprimer le fichier uploadé
                }
            } else {
                $errors[] = "Erreur lors de l'upload de $fileName";
            }
        }
        
        $message = '';
        if (!empty($uploadedFiles)) {
            $message .= 'Fichiers uploadés : ' . implode(', ', $uploadedFiles) . '. ';
        }
        if (!empty($errors)) {
            $message .= 'Erreurs : ' . implode(', ', $errors);
        }
        
        $status = empty($errors) ? 'success' : 'error';
        header("Location: ../views/admin/media.php?$status=" . urlencode($message));
    }
    
    private function deleteMedia() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $id = $_GET['id'] ?? '';
        
        if (empty($id)) {
            header('Location: ../views/admin/media.php?error=ID manquant');
            return;
        }
        
        try {
            // Récupérer le chemin du fichier avant suppression
            $stmt = $this->db->prepare("SELECT chemin FROM media WHERE id = ?");
            $stmt->execute([$id]);
            $media = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($media) {
                // Supprimer le fichier physique
                if (file_exists($media['chemin'])) {
                    unlink($media['chemin']);
                }
                
                // Supprimer de la base de données
                $stmt = $this->db->prepare("DELETE FROM media WHERE id = ?");
                $stmt->execute([$id]);
            }
            
            header('Location: ../views/admin/media.php?success=Média supprimé avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/media.php?error=Erreur lors de la suppression');
        }
    }
    
    private function createUser() {
        if (!$this->isAuthenticated() || $_SESSION['admin_role'] !== 'admin') {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'visiteur';
        
        if (empty($username) || empty($password)) {
            header('Location: ../views/admin/users.php?error=Données manquantes');
            return;
        }
        
        // Vérifier si l'utilisateur existe déjà
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            header('Location: ../views/admin/users.php?error=Utilisateur déjà existant');
            return;
        }
        
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password, role) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$username, $email, $hashedPassword, $role]);
            
            header('Location: ../views/admin/users.php?success=Utilisateur créé avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/users.php?error=Erreur lors de la création');
        }
    }
    
    private function updateUser() {
        if (!$this->isAuthenticated() || $_SESSION['admin_role'] !== 'admin') {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $id = $_POST['id'] ?? '';
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'visiteur';
        $password = $_POST['password'] ?? '';
        
        if (empty($id) || empty($username)) {
            header('Location: ../views/admin/users.php?error=Données manquantes');
            return;
        }
        
        try {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("
                    UPDATE users 
                    SET username = ?, email = ?, password = ?, role = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$username, $email, $hashedPassword, $role, $id]);
            } else {
                $stmt = $this->db->prepare("
                    UPDATE users 
                    SET username = ?, email = ?, role = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$username, $email, $role, $id]);
            }
            
            header('Location: ../views/admin/users.php?success=Utilisateur mis à jour avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/users.php?error=Erreur lors de la mise à jour');
        }
    }
    
    private function deleteUser() {
        if (!$this->isAuthenticated() || $_SESSION['admin_role'] !== 'admin') {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $id = $_GET['id'] ?? '';
        
        if (empty($id)) {
            header('Location: ../views/admin/users.php?error=ID manquant');
            return;
        }
        
        // Empêcher la suppression de son propre compte
        if ($id == $_SESSION['admin_user_id']) {
            header('Location: ../views/admin/users.php?error=Impossible de supprimer votre propre compte');
            return;
        }
        
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            
            header('Location: ../views/admin/users.php?success=Utilisateur supprimé avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/users.php?error=Erreur lors de la suppression');
        }
    }
    
    private function showDashboard() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        // Récupération des statistiques
        $stats = $this->getStats();
        
        // Inclure les variables dans la session pour les utiliser dans la vue
        $_SESSION['dashboard_stats'] = $stats;
        
        header('Location: ../views/admin/dashboard.php');
    }
    
    private function getStats() {
        $stats = [];
        
        // Total des publications
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM publications");
        $stats['totalPublications'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total des utilisateurs
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        $stats['totalUsers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total des médias
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM media");
        $stats['totalMedia'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total des modules
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM modules");
        $stats['totalModules'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $stats;
    }
    
    // Méthodes CRUD pour les modules
    private function createModule() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $nom = $_POST['nom'] ?? '';
        $description = $_POST['description'] ?? '';
        $statut = $_POST['statut'] ?? 'actif';
        $icone = $_POST['icone'] ?? '';
        $couleur = $_POST['couleur'] ?? '#007bff';
        
        if (empty($nom)) {
            header('Location: ../views/admin/modules.php?error=Nom du module requis');
            return;
        }
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO modules (nom, description, statut, icone, couleur, date_creation) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$nom, $description, $statut, $icone, $couleur]);
            
            header('Location: ../views/admin/modules.php?success=Module créé avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/modules.php?error=Erreur lors de la création du module');
        }
    }
    
    private function updateModule() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $id = $_POST['module_id'] ?? '';
        $nom = $_POST['nom'] ?? '';
        $description = $_POST['description'] ?? '';
        $statut = $_POST['statut'] ?? 'actif';
        $icone = $_POST['icone'] ?? '';
        $couleur = $_POST['couleur'] ?? '#007bff';
        
        if (empty($id) || empty($nom)) {
            header('Location: ../views/admin/modules.php?error=Données manquantes');
            return;
        }
        
        try {
            $stmt = $this->db->prepare("
                UPDATE modules 
                SET nom = ?, description = ?, statut = ?, icone = ?, couleur = ?, date_modification = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([$nom, $description, $statut, $icone, $couleur, $id]);
            
            header('Location: ../views/admin/modules.php?success=Module mis à jour avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/modules.php?error=Erreur lors de la mise à jour');
        }
    }
    
    private function deleteModule() {
        if (!$this->isAuthenticated()) {
            header('Location: ../views/admin/login.php');
            return;
        }
        
        $id = $_POST['module_id'] ?? '';
        
        if (empty($id)) {
            header('Location: ../views/admin/modules.php?error=ID du module manquant');
            return;
        }
        
        try {
            // Vérifier s'il y a des publications liées à ce module
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM publications WHERE module_id = ?");
            $stmt->execute([$id]);
            $publicationsCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($publicationsCount > 0) {
                // Supprimer d'abord les publications liées
                $stmt = $this->db->prepare("DELETE FROM publications WHERE module_id = ?");
                $stmt->execute([$id]);
            }
            
            // Supprimer le module
            $stmt = $this->db->prepare("DELETE FROM modules WHERE id = ?");
            $stmt->execute([$id]);
            
            header('Location: ../views/admin/modules.php?success=Module supprimé avec succès');
        } catch (Exception $e) {
            header('Location: ../views/admin/modules.php?error=Erreur lors de la suppression');
        }
    }
    
    private function isAuthenticated() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
}

// Traitement de la requête
$controller = new AdminController();
$controller->handleRequest();
?>
