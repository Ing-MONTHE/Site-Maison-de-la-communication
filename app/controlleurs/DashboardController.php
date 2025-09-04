<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/Site-Maison-de-la-communication/config/Database.php';
use Config\Database;

class DashboardController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function handleRequest() {
        $action = $_GET['action'] ?? 'show';
        
        switch ($action) {
            case 'show':
                $this->showDashboard();
                break;
            case 'getStats':
                $this->getStats();
                break;
            default:
                $this->showDashboard();
                break;
        }
    }
    
    private function showDashboard() {
        if (!$this->isAuthenticated()) {
            header('Location: /Site-Maison-de-la-communication/app/views/admin/login.php');
            exit();
        }
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Include the dashboard view with stats
        include $_SERVER['DOCUMENT_ROOT'] . '/Site-Maison-de-la-communication/app/views/admin/dashboard.php';
    }
    
    private function getStats() {
        if (!$this->isAuthenticated()) {
            http_response_code(401);
            echo json_encode(['error' => 'Non autorisé']);
            return;
        }
        
        $stats = $this->getDashboardStats();
        header('Content-Type: application/json');
        echo json_encode($stats);
    }
    
    private function getDashboardStats() {
        $stats = [];
        
        try {
            // Total publications
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM publications");
            $stats['totalPublications'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total users
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
            $stats['totalUsers'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total media
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM media");
            $stats['totalMedia'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total modules
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM modules");
            $stats['totalModules'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Publications by module
            $stmt = $this->db->query("
                SELECT m.name as module_name, COUNT(p.id) as publication_count 
                FROM modules m 
                LEFT JOIN publications p ON m.id = p.module_id 
                GROUP BY m.id, m.name
            ");
            $stats['publicationsByModule'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Recent publications
            $stmt = $this->db->query("
                SELECT p.titre, p.created_at, m.name as module_name 
                FROM publications p 
                JOIN modules m ON p.module_id = m.id 
                ORDER BY p.created_at DESC 
                LIMIT 5
            ");
            $stats['recentPublications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Users by role
            $stmt = $this->db->query("
                SELECT role, COUNT(*) as count 
                FROM users 
                GROUP BY role
            ");
            $stats['usersByRole'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            // Set default values if database error occurs
            $stats['totalPublications'] = 0;
            $stats['totalUsers'] = 0;
            $stats['totalMedia'] = 0;
            $stats['totalModules'] = 0;
            $stats['publicationsByModule'] = [];
            $stats['recentPublications'] = [];
            $stats['usersByRole'] = [];
        }
        
        return $stats;
    }
    
    private function isAuthenticated() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
}

// Handle the request
$controller = new DashboardController();
$controller->handleRequest();
?>
