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

// Récupération des utilisateurs (auteurs potentiels)
$usersQuery = $db->query("SELECT id, username FROM users WHERE role IN ('admin','personnel') ORDER BY username");
$users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);

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
    <script src="../../../public/assets/js/admin-mobile.js"></script>
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

        <!-- Mobile menu overlay -->
        <div class="sidebar-overlay" onclick="closeMobileMenu()"></div>
        
        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-content">
                    <h1>Gestion des Publications</h1>
                    <p>Créer, modifier et gérer les contenus du site</p>
                </div>
                <div class="header-actions">
                    <button type="button" onclick="openPublicationModal()" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Nouvelle publication
                    </button>
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
                        <table class="admin-table" id="publicationsTable">
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
                            <tbody id="publicationsTbody">
                                <?php foreach ($publications as $publication): ?>
                                    <tr data-id="<?php echo (int)$publication['id']; ?>"
                                        data-module-id="<?php echo (int)$publication['module_id']; ?>"
                                        data-status="<?php echo htmlspecialchars($publication['statut']); ?>"
                                        data-title="<?php echo htmlspecialchars($publication['titre']); ?>"
                                        data-created="<?php echo htmlspecialchars($publication['created_at']); ?>">
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
                                                <button type="button"
                                                    class="btn btn-sm btn-outline" title="Modifier"
                                                    onclick='openEditPublicationModal(<?php echo json_encode([
                                                        "id" => (int)$publication["id"],
                                                        "titre" => $publication["titre"],
                                                        "module_id" => (int)$publication["module_id"],
                                                        "auteur_id" => isset($publication["auteur_id"]) ? (int)$publication["auteur_id"] : null,
                                                        "statut" => $publication["statut"],
                                                        "contenu" => $publication["contenu"]
                                                    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>)'>
                                                    <i class="fas fa-edit"></i>
                                                </button>
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
    
    <!-- Modal Nouvelle / Modifier publication -->
    <div id="publicationModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="pubModalTitle" aria-hidden="true">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h3 id="pubModalTitle">Nouvelle publication</h3>
                <button onclick="closePublicationModal()" class="btn-close" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../../../app/controlleurs/AdminController.php" class="publication-form" enctype="multipart/form-data" id="publicationForm">
                    <input type="hidden" name="action" id="pubAction" value="createPublication">
                    <input type="hidden" name="id" id="pubId" value="">

                    <div class="form-grid">
                        <div class="form-section">
                            <h3>Informations principales</h3>
                            <div class="form-group">
                                <label for="modal_titre">Titre *</label>
                                <input type="text" id="modal_titre" name="titre" required class="form-input">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="modal_module_id">Module *</label>
                                    <select id="modal_module_id" name="module_id" required class="form-select">
                                        <option value="">Sélectionner un module</option>
                                        <?php foreach ($modules as $module): ?>
                                            <option value="<?php echo $module['id']; ?>"><?php echo htmlspecialchars($module['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="modal_auteur_id">Auteur</label>
                                    <select id="modal_auteur_id" name="auteur_id" class="form-select">
                                        <option value="">Sélectionner un auteur</option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="modal_statut">Statut</label>
                                <select id="modal_statut" name="statut" class="form-select">
                                    <option value="brouillon">Brouillon</option>
                                    <option value="publie">Publié</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-section">
                            <h3>Contenu</h3>
                            <div class="form-group">
                                <label for="modal_contenu">Contenu *</label>
                                <textarea id="modal_contenu" name="contenu" class="form-textarea" rows="10" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="modal_media_files">Fichiers à publier</label>
                                <input type="file" id="modal_media_files" name="media_files[]" class="form-input" multiple accept=".jpg,.jpeg,.png,.gif,.mp4,.mp3,.wav,.avi">
                                <small>Formats: images (jpg, png, gif), vidéos (mp4, avi), audios (mp3, wav). Taille max 10MB/fichier.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            Créer la publication
                        </button>
                        <button type="button" onclick="closePublicationModal()" class="btn btn-outline">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
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

        function openPublicationModal() {
            const modal = document.getElementById('publicationModal');
            // reset to create mode
            document.getElementById('pubAction').value = 'createPublication';
            document.getElementById('pubId').value = '';
            document.getElementById('pubModalTitle').textContent = 'Nouvelle publication';
            document.getElementById('modal_titre').value = '';
            document.getElementById('modal_module_id').value = '';
            document.getElementById('modal_auteur_id').value = '';
            document.getElementById('modal_statut').value = 'brouillon';
            document.getElementById('modal_contenu').value = '';
            document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Créer la publication';
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
        }

        function openEditPublicationModal(pub) {
            const modal = document.getElementById('publicationModal');
            document.getElementById('pubAction').value = 'updatePublication';
            document.getElementById('pubId').value = pub.id;
            document.getElementById('pubModalTitle').textContent = 'Modifier la publication';
            document.getElementById('modal_titre').value = pub.titre || '';
            document.getElementById('modal_module_id').value = pub.module_id || '';
            document.getElementById('modal_auteur_id').value = pub.auteur_id || '';
            document.getElementById('modal_statut').value = pub.statut || 'brouillon';
            document.getElementById('modal_contenu').value = pub.contenu || '';
            document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Mettre à jour';
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
        }

        function closePublicationModal() {
            const modal = document.getElementById('publicationModal');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }
        
        // Fermer le modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            const pubModal = document.getElementById('publicationModal');
            if (event.target === modal) {
                closeModal();
            }
            if (event.target === pubModal) {
                closePublicationModal();
            }
        }
        
        // ESC pour fermer
        window.addEventListener('keydown', function(e){
            if (e.key === 'Escape') {
                closeModal();
                closePublicationModal();
            }
        });

        // Filtrage client
        (function initFilters(){
            const moduleFilter = document.getElementById('module-filter');
            const statusFilter = document.getElementById('status-filter');
            const searchFilter = document.getElementById('search-filter');
            const tbody = document.getElementById('publicationsTbody');

            function apply(){
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const m = moduleFilter.value;
                const s = statusFilter.value;
                const q = searchFilter.value.trim().toLowerCase();

                // Filter
                const filtered = rows.filter(tr => {
                    const rowModule = tr.getAttribute('data-module-id') || '';
                    const rowStatus = tr.getAttribute('data-status') || '';
                    const rowTitle = (tr.getAttribute('data-title') || '').toLowerCase();
                    const matchModule = !m || m === rowModule;
                    const matchStatus = !s || s === rowStatus;
                    const matchText = !q || rowTitle.includes(q);
                    return matchModule && matchStatus && matchText;
                });

                // Re-attach rows
                tbody.innerHTML = '';
                filtered.forEach(tr => tbody.appendChild(tr));
            }

            [moduleFilter, statusFilter, searchFilter].forEach(el => el && el.addEventListener('input', apply));
        })();
    </script>
</body>
</html>
