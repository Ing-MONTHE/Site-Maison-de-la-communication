<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration MCC - Tableau de bord</title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-dashboard">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="../../../Images/logo.png" alt="MCC Logo" class="sidebar-logo">
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
                <a href="../../../app/controlleurs/AdminController.php?action=logout" class="btn-logout">
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
                    <a href="../../../index.php" class="btn btn-outline" target="_blank">
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
                                <h3><?php echo $totalPublications ?? 0; ?></h3>
                                <p>Publications</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalUsers ?? 0; ?></h3>
                                <p>Utilisateurs</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalMedia ?? 0; ?></h3>
                                <p>Médias</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-cubes"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalModules ?? 4; ?></h3>
                                <p>Modules</p>
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
                        
                        <div class="module-card">
                            <div class="module-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h3>Luma Vitae</h3>
                            <p>Service Luma Vitae</p>
                            <div class="module-actions">
                                <a href="publications.php?module=luma-vitae" class="btn btn-sm">Voir publications</a>
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
</body>
</html>
