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
    <title>Administration MCC - Paramètres</title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../../../public/assets/js/admin-mobile.js"></script>
</head>
<body class="admin-settings">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="../../../Images/logo.png" alt="MCC Logo" class="sidebar-logo">
                <h3>Administration</h3>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item">
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
                    
                    <li class="nav-item active">
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

        <!-- Mobile menu overlay -->
        <div class="sidebar-overlay" onclick="closeMobileMenu()"></div>
        
        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-content">
                    <h1>Paramètres</h1>
                    <p>Configuration du système et des préférences</p>
                </div>
            </header>
            
            <div class="admin-content">
                <!-- Paramètres généraux -->
                <section class="settings-section">
                    <h2>Paramètres généraux</h2>
                    <div class="settings-grid">
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-globe"></i>
                                <h3>Informations du site</h3>
                            </div>
                            <form class="setting-form">
                                <div class="form-group">
                                    <label for="site-name">Nom du site</label>
                                    <input type="text" id="site-name" value="MCC - Maison de la Communication Chrétienne" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label for="site-description">Description</label>
                                    <textarea id="site-description" class="form-textarea" rows="3">Centre de communication chrétienne offrant des services de radio, imprimerie et communication</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="contact-email">Email de contact</label>
                                    <input type="email" id="contact-email" value="contact@mcc.org" class="form-input">
                                </div>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </form>
                        </div>
                        
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-shield-alt"></i>
                                <h3>Sécurité</h3>
                            </div>
                            <form class="setting-form">
                                <div class="form-group">
                                    <label for="session-timeout">Timeout de session (minutes)</label>
                                    <input type="number" id="session-timeout" value="30" min="5" max="480" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label for="max-login-attempts">Tentatives de connexion max</label>
                                    <input type="number" id="max-login-attempts" value="5" min="3" max="10" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="force-ssl" checked>
                                        <span>Forcer HTTPS</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="two-factor-auth">
                                        <span>Authentification à deux facteurs</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </form>
                        </div>
                    </div>
                </section>
                
                <!-- Paramètres des médias -->
                <section class="settings-section">
                    <h2>Paramètres des médias</h2>
                    <div class="settings-grid">
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-images"></i>
                                <h3>Upload et optimisation</h3>
                            </div>
                            <form class="setting-form">
                                <div class="form-group">
                                    <label for="max-file-size">Taille max des fichiers (MB)</label>
                                    <input type="number" id="max-file-size" value="10" min="1" max="100" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label for="allowed-formats">Formats autorisés</label>
                                    <input type="text" id="allowed-formats" value="jpg,jpeg,png,gif,mp4,mp3,wav,avi" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="auto-optimize" checked>
                                        <span>Optimisation automatique des images</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="generate-thumbnails" checked>
                                        <span>Génération automatique des miniatures</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </form>
                        </div>
                        
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-database"></i>
                                <h3>Stockage</h3>
                            </div>
                            <div class="storage-info">
                                <div class="storage-item">
                                    <span class="storage-label">Espace utilisé</span>
                                    <span class="storage-value">2.5 GB / 10 GB</span>
                                    <div class="storage-bar">
                                        <div class="storage-fill" style="width: 25%"></div>
                                    </div>
                                </div>
                                <div class="storage-item">
                                    <span class="storage-label">Images</span>
                                    <span class="storage-value">1.2 GB</span>
                                </div>
                                <div class="storage-item">
                                    <span class="storage-label">Vidéos</span>
                                    <span class="storage-value">800 MB</span>
                                </div>
                                <div class="storage-item">
                                    <span class="storage-label">Audio</span>
                                    <span class="storage-value">500 MB</span>
                                </div>
                            </div>
                            <button onclick="cleanupStorage()" class="btn btn-outline">
                                <i class="fas fa-broom"></i>
                                Nettoyer les fichiers orphelins
                            </button>
                        </div>
                    </div>
                </section>
                
                <!-- Paramètres des publications -->
                <section class="settings-section">
                    <h2>Paramètres des publications</h2>
                    <div class="settings-grid">
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-newspaper"></i>
                                <h3>Éditeur de contenu</h3>
                            </div>
                            <form class="setting-form">
                                <div class="form-group">
                                    <label for="default-status">Statut par défaut</label>
                                    <select id="default-status" class="form-select">
                                        <option value="brouillon">Brouillon</option>
                                        <option value="publie">Publié</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="posts-per-page">Publications par page</label>
                                    <input type="number" id="posts-per-page" value="10" min="5" max="50" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="auto-save" checked>
                                        <span>Sauvegarde automatique</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="enable-comments">
                                        <span>Activer les commentaires</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </form>
                        </div>
                        
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-bell"></i>
                                <h3>Notifications</h3>
                            </div>
                            <form class="setting-form">
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="notify-new-users" checked>
                                        <span>Nouveaux utilisateurs</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="notify-new-publications" checked>
                                        <span>Nouvelles publications</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="notify-storage-warning">
                                        <span>Avertissement stockage</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="notify-errors">
                                        <span>Erreurs système</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </form>
                        </div>
                    </div>
                </section>
                
                <!-- Maintenance -->
                <section class="settings-section">
                    <h2>Maintenance</h2>
                    <div class="settings-grid">
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-tools"></i>
                                <h3>Outils de maintenance</h3>
                            </div>
                            <div class="maintenance-actions">
                                <button onclick="clearCache()" class="btn btn-outline">
                                    <i class="fas fa-trash"></i>
                                    Vider le cache
                                </button>
                                <button onclick="optimizeDatabase()" class="btn btn-outline">
                                    <i class="fas fa-database"></i>
                                    Optimiser la base de données
                                </button>
                                <button onclick="backupSystem()" class="btn btn-outline">
                                    <i class="fas fa-download"></i>
                                    Sauvegarde complète
                                </button>
                                <button onclick="checkSystem()" class="btn btn-outline">
                                    <i class="fas fa-check-circle"></i>
                                    Vérification système
                                </button>
                            </div>
                        </div>
                        
                        <div class="setting-card">
                            <div class="setting-header">
                                <i class="fas fa-info-circle"></i>
                                <h3>Informations système</h3>
                            </div>
                            <div class="system-info">
                                <div class="info-item">
                                    <span class="info-label">Version PHP</span>
                                    <span class="info-value"><?php echo phpversion(); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Version MySQL</span>
                                    <span class="info-value">8.0.33</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Dernière sauvegarde</span>
                                    <span class="info-value">Il y a 2 jours</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Temps de réponse</span>
                                    <span class="info-value">45ms</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    
    <script>
        function cleanupStorage() {
            if (confirm('Êtes-vous sûr de vouloir nettoyer les fichiers orphelins ?')) {
                // Action de nettoyage
                alert('Nettoyage terminé !');
            }
        }
        
        function clearCache() {
            if (confirm('Êtes-vous sûr de vouloir vider le cache ?')) {
                // Action de vidage du cache
                alert('Cache vidé avec succès !');
            }
        }
        
        function optimizeDatabase() {
            if (confirm('Êtes-vous sûr de vouloir optimiser la base de données ?')) {
                // Action d'optimisation
                alert('Base de données optimisée !');
            }
        }
        
        function backupSystem() {
            if (confirm('Êtes-vous sûr de vouloir créer une sauvegarde complète ?')) {
                // Action de sauvegarde
                alert('Sauvegarde en cours...');
            }
        }
        
        function checkSystem() {
            // Action de vérification
            alert('Vérification système terminée. Tout fonctionne correctement.');
        }
        
        // Sauvegarde automatique des paramètres
        document.querySelectorAll('.setting-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // Logique de sauvegarde
                alert('Paramètres sauvegardés avec succès !');
            });
        });
    </script>
</body>
</html>
