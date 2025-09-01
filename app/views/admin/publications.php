<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../../../config/Database.php';
use Config\Database;

$db = Database::getConnection();

// Récupération des modules
$modulesQuery = $db->query("SELECT * FROM modules ORDER BY name");
$modules = $modulesQuery->fetchAll(PDO::FETCH_ASSOC);

// Récupération des publications avec jointures
$publicationsQuery = $db->query("
    SELECT p.*, m.name as module_name, u.username as author_name 
    FROM publications p 
    LEFT JOIN modules m ON p.module_id = m.id 
    LEFT JOIN users u ON p.auteur_id = u.id 
    ORDER BY p.created_at DESC
");
$publications = $publicationsQuery->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration MCC - Publications</title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-publications">
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
                    
                    <li class="nav-item active">
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
                    <h1>Gestion des Publications</h1>
                    <p>Créer, modifier et gérer les contenus du site</p>
                </div>
                <div class="header-actions">
                    <a href="publications.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Nouvelle publication
                    </a>
                </div>
            </header>
            
            <div class="admin-content">
                <!-- Filtres -->
                <section class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label for="module-filter">Module</label>
                            <select id="module-filter" class="form-select">
                                <option value="">Tous les modules</option>
                                <?php foreach ($modules as $module): ?>
                                    <option value="<?php echo $module['id']; ?>"><?php echo htmlspecialchars($module['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="status-filter">Statut</label>
                            <select id="status-filter" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="brouillon">Brouillon</option>
                                <option value="publie">Publié</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="search-filter">Recherche</label>
                            <input type="text" id="search-filter" class="form-input" placeholder="Rechercher...">
                        </div>
                    </div>
                </section>
                
                <!-- Liste des publications -->
                <section class="publications-list">
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Module</th>
                                    <th>Auteur</th>
                                    <th>Statut</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($publications as $publication): ?>
                                    <tr>
                                        <td>
                                            <div class="publication-title">
                                                <strong><?php echo htmlspecialchars($publication['titre']); ?></strong>
                                                <span class="publication-excerpt">
                                                    <?php echo htmlspecialchars(substr($publication['contenu'], 0, 100)) . '...'; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="module-badge">
                                                <?php echo htmlspecialchars($publication['module_name']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($publication['author_name'] ?? 'Anonyme'); ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo $publication['statut']; ?>">
                                                <?php echo ucfirst($publication['statut']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y H:i', strtotime($publication['created_at'])); ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="publications.php?action=edit&id=<?php echo $publication['id']; ?>" 
                                                   class="btn btn-sm btn-outline" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="publications.php?action=preview&id=<?php echo $publication['id']; ?>" 
                                                   class="btn btn-sm btn-outline" title="Prévisualiser" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button onclick="deletePublication(<?php echo $publication['id']; ?>)" 
                                                        class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
    
    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer cette publication ?</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="btn btn-outline">Annuler</button>
                <button onclick="confirmDelete()" class="btn btn-danger">Supprimer</button>
            </div>
        </div>
    </div>
    
    <script>
        let publicationToDelete = null;
        
        function deletePublication(id) {
            publicationToDelete = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
            publicationToDelete = null;
        }
        
        function confirmDelete() {
            if (publicationToDelete) {
                window.location.href = `../../../app/controlleurs/AdminController.php?action=deletePublication&id=${publicationToDelete}`;
            }
        }
        
        // Fermer le modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
