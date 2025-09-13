<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Always load dashboard statistics directly from database
$totalPublications = 0;
$totalUsers = 0;
$totalMedia = 0;
$totalModules = 0;
$publicationsByModule = [];
$recentPublications = [];
$usersByRole = [];

require_once $_SERVER['DOCUMENT_ROOT'] . '/Site-Maison-de-la-communication/config/Database.php';
$pdo = Config\Database::getConnection();
try {
    $totalPublications = (int)$pdo->query("SELECT COUNT(*) FROM publications")->fetchColumn();
    $totalUsers = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalMedia = (int)$pdo->query("SELECT COUNT(*) FROM media")->fetchColumn();
    $totalModules = (int)$pdo->query("SELECT COUNT(*) FROM modules")->fetchColumn();
    
    // Publications by module
    $stmt = $pdo->query("
            SELECT m.name as module_name, COUNT(p.id) as publication_count 
            FROM modules m 
            LEFT JOIN publications p ON m.id = p.module_id 
            GROUP BY m.id, m.name
        ");
    $publicationsByModule = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Users by role
    $stmt = $pdo->query("
            SELECT role, COUNT(*) as count 
            FROM users 
            GROUP BY role
        ");
    $usersByRole = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Keep default values if database error occurs
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration MCC - Tableau de bord</title>
    <link rel="stylesheet" href="/Site-Maison-de-la-communication/public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-dashboard">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="/Site-Maison-de-la-communication/Images/Logo MCC.png" alt="MCC Logo" class="sidebar-logo">
                <h3>Administration</h3>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item active">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="modules.php" class="nav-link">
                            <i class="fas fa-cubes"></i>
                            <span>Modules</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="publications.php" class="nav-link">
                            <i class="fas fa-newspaper"></i>
                            <span>Publications</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="media.php" class="nav-link">
                            <i class="fas fa-images"></i>
                            <span>Médias</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="users.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                                 <a href="/Site-Maison-de-la-communication/app/controlleurs/AdminController.php?action=logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="header-content">
                    <h1>Tableau de bord</h1>
                    <p>Bienvenue dans l'interface d'administration</p>
                </div>
                <div class="header-actions">
                    <button onclick="refreshStats()" class="btn btn-outline">
                        <i class="fas fa-sync-alt"></i>
                        Actualiser
                    </button>
                    <a href="/Site-Maison-de-la-communication/index.php" class="btn btn-outline" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        Voir le site
                    </a>
                </div>
            </header>
            
            <div class="admin-content">
                <!-- Statistiques -->
                <section class="stats-section">
                    <h2>Statistiques générales</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="stat-content">
                                <h3 id="totalPublications"><?php echo $totalPublications; ?></h3>
                                <p>Publications</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3 id="totalUsers"><?php echo $totalUsers; ?></h3>
                                <p>Utilisateurs</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="stat-content">
                                <h3 id="totalMedia"><?php echo $totalMedia; ?></h3>
                                <p>Médias</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-cubes"></i>
                            </div>
                            <div class="stat-content">
                                <h3 id="totalModules"><?php echo $totalModules; ?></h3>
                                <p>Modules</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Statistiques détaillées -->
                <section class="detailed-stats">
                    <h2>Statistiques détaillées</h2>
                    <div class="stats-details-grid">
                        <!-- Publications par module -->
                        <div class="stats-card">
                            <h3>Publications par module</h3>
                            <div class="stats-list">
                                <?php if (!empty($publicationsByModule)): ?>
                                    <?php foreach ($publicationsByModule as $moduleStat): ?>
                                        <div class="stat-item">
                                            <span class="stat-label"><?php echo htmlspecialchars($moduleStat['module_name']); ?></span>
                                            <span class="stat-value"><?php echo $moduleStat['publication_count']; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="no-data">Aucune publication trouvée</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Utilisateurs par rôle -->
                        <div class="stats-card">
                            <h3>Utilisateurs par rôle</h3>
                            <div class="stats-list">
                                <?php if (!empty($usersByRole)): ?>
                                    <?php foreach ($usersByRole as $roleStat): ?>
                                        <div class="stat-item">
                                            <span class="stat-label"><?php echo htmlspecialchars($roleStat['role']); ?></span>
                                            <span class="stat-value"><?php echo $roleStat['count']; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="no-data">Aucun utilisateur trouvé</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Modules -->
                <section class="modules-section">
                    <h2>Gestion par modules</h2>
                    <div class="modules-grid">
                        <div class="module-card">
                            <div class="module-icon">
                                <i class="fas fa-broadcast-tower"></i>
                            </div>
                            <h3>RVE</h3>
                            <p>Radio Vox Ecclesia</p>
                            <div class="module-actions">
                                <a href="publications.php?module=rve" class="btn btn-sm">Voir publications</a>
                            </div>
                        </div>
                        
                        <div class="module-card">
                            <div class="module-icon">
                                <i class="fas fa-print"></i>
                            </div>
                            <h3>Imprimerie</h3>
                            <p>Service Imprimerie</p>
                            <div class="module-actions">
                                <a href="publications.php?module=imprimerie" class="btn btn-sm">Voir publications</a>
                            </div>
                        </div>
                        
                        <div class="module-card">
                            <div class="module-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <h3>SerCom</h3>
                            <p>Service Communication</p>
                            <div class="module-actions">
                                <a href="publications.php?module=sercom" class="btn btn-sm">Voir publications</a>
                            </div>
                        </div>
                        
                    </div>
                </section>
                
                <!-- Actions rapides -->
                <section class="quick-actions">
                    <h2>Actions rapides</h2>
                    <div class="actions-grid">
                        <a href="publications.php?action=create" class="action-card">
                            <i class="fas fa-plus"></i>
                            <h3>Nouvelle publication</h3>
                            <p>Créer un nouvel article ou contenu</p>
                        </a>
                        
                        <a href="media.php?action=upload" class="action-card">
                            <i class="fas fa-upload"></i>
                            <h3>Upload média</h3>
                            <p>Télécharger des images ou vidéos</p>
                        </a>
                        
                        <a href="users.php?action=create" class="action-card">
                            <i class="fas fa-user-plus"></i>
                            <h3>Nouvel utilisateur</h3>
                            <p>Ajouter un membre du personnel</p>
                        </a>
                        
                        <a href="modules.php" class="action-card">
                            <i class="fas fa-cogs"></i>
                            <h3>Gérer les modules</h3>
                            <p>Ajouter, modifier ou supprimer des services</p>
                        </a>
                        
                        <a href="settings.php" class="action-card">
                            <i class="fas fa-cog"></i>
                            <h3>Paramètres</h3>
                            <p>Configurer le système</p>
                        </a>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        function refreshStats() {
            // Show loading state
            const refreshBtn = event.target;
            const originalText = refreshBtn.innerHTML;
            refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualisation...';
            refreshBtn.disabled = true;

            // Fetch updated stats
            fetch('/Site-Maison-de-la-communication/app/controlleurs/DashboardController.php?action=getStats')
                .then(response => response.json())
                .then(data => {
                    // Update statistics
                    document.getElementById('totalPublications').textContent = data.totalPublications || 0;
                    document.getElementById('totalUsers').textContent = data.totalUsers || 0;
                    document.getElementById('totalMedia').textContent = data.totalMedia || 0;
                    document.getElementById('totalModules').textContent = data.totalModules || 0;
                    
                    // Show success message
                    showNotification('Statistiques actualisées avec succès', 'success');
                })
                .catch(error => {
                    console.error('Erreur lors de l\'actualisation:', error);
                    showNotification('Erreur lors de l\'actualisation des statistiques', 'error');
                })
                .finally(() => {
                    // Restore button state
                    refreshBtn.innerHTML = originalText;
                    refreshBtn.disabled = false;
                });
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="notification-close">&times;</button>
                </div>
            `;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 3000);
        }
    </script>
</body>
</html>
