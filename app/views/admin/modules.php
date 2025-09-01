<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../../config/Database.php';
$pdo = Config\Database::getConnection();

// Récupération des modules
$stmt = $pdo->query("SELECT * FROM modules ORDER BY nom");
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Modules - Administration MCC</title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cogs"></i> Administration</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="modules.php" class="nav-item active">
                    <i class="fas fa-cogs"></i>
                    <span>Modules</span>
                </a>
                <a href="publications.php" class="nav-item">
                    <i class="fas fa-newspaper"></i>
                    <span>Publications</span>
                </a>
                <a href="media.php" class="nav-item">
                    <i class="fas fa-images"></i>
                    <span>Média</span>
                </a>
                <a href="users.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
                <a href="settings.php" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="content-header">
                <div class="header-left">
                    <h1><i class="fas fa-cogs"></i> Gestion des Modules</h1>
                    <p>Gérez les services et modules de votre plateforme</p>
                </div>
                <div class="header-right">
                    <button class="btn btn-primary" onclick="openAddModuleModal()">
                        <i class="fas fa-plus"></i> Nouveau Module
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="content-body">
                <!-- Filtres et recherche -->
                <div class="filters-section">
                    <div class="search-box">
                        <input type="text" id="searchModules" placeholder="Rechercher un module..." onkeyup="filterModules()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="filter-options">
                        <select id="statusFilter" onchange="filterModules()">
                            <option value="">Tous les statuts</option>
                            <option value="actif">Actif</option>
                            <option value="inactif">Inactif</option>
                        </select>
                    </div>
                </div>

                <!-- Liste des modules -->
                <div class="modules-grid">
                    <?php foreach ($modules as $module): ?>
                    <div class="module-card" data-name="<?= htmlspecialchars($module['nom']) ?>" data-status="<?= $module['statut'] ?? 'actif' ?>">
                        <div class="module-header">
                            <div class="module-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="module-status <?= ($module['statut'] ?? 'actif') === 'actif' ? 'active' : 'inactive' ?>">
                                <?= ($module['statut'] ?? 'actif') === 'actif' ? 'Actif' : 'Inactif' ?>
                            </div>
                        </div>
                        <div class="module-content">
                            <h3><?= htmlspecialchars($module['nom']) ?></h3>
                            <p class="module-description">
                                <?= htmlspecialchars($module['description'] ?? 'Aucune description disponible') ?>
                            </p>
                            <div class="module-meta">
                                <span class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    Créé le <?= date('d/m/Y', strtotime($module['date_creation'] ?? 'now')) ?>
                                </span>
                                <?php if ($module['date_modification']): ?>
                                <span class="meta-item">
                                    <i class="fas fa-edit"></i>
                                    Modifié le <?= date('d/m/Y', strtotime($module['date_modification'])) ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="module-actions">
                            <button class="btn btn-sm btn-secondary" onclick="editModule(<?= $module['id'] ?>)">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteModule(<?= $module['id'] ?>, '<?= htmlspecialchars($module['nom']) ?>')">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Message si aucun module -->
                <?php if (empty($modules)): ?>
                <div class="empty-state">
                    <i class="fas fa-cogs"></i>
                    <h3>Aucun module trouvé</h3>
                    <p>Commencez par créer votre premier module de service.</p>
                    <button class="btn btn-primary" onclick="openAddModuleModal()">
                        <i class="fas fa-plus"></i> Créer un module
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modal Ajout/Modification Module -->
    <div id="moduleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Nouveau Module</h2>
                <span class="close" onclick="closeModuleModal()">&times;</span>
            </div>
            <form id="moduleForm" action="../../../app/controlleurs/AdminController.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="moduleAction" value="createModule">
                <input type="hidden" name="module_id" id="moduleId" value="">
                
                <div class="form-group">
                    <label for="moduleName">Nom du module *</label>
                    <input type="text" id="moduleName" name="nom" required placeholder="Ex: RVE, Imprimerie, SerCom">
                </div>

                <div class="form-group">
                    <label for="moduleDescription">Description</label>
                    <textarea id="moduleDescription" name="description" rows="4" placeholder="Description détaillée du module..."></textarea>
                </div>

                <div class="form-group">
                    <label for="moduleStatus">Statut</label>
                    <select id="moduleStatus" name="statut">
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="moduleIcon">Icône (optionnel)</label>
                    <input type="text" id="moduleIcon" name="icone" placeholder="Ex: fas fa-print, fas fa-video">
                    <small>Utilisez les classes Font Awesome (ex: fas fa-print)</small>
                </div>

                <div class="form-group">
                    <label for="moduleColor">Couleur du module (optionnel)</label>
                    <input type="color" id="moduleColor" name="couleur" value="#007bff">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModuleModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModuleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirmer la suppression</h2>
                <span class="close" onclick="closeDeleteModuleModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer le module "<span id="moduleNameToDelete"></span>" ?</p>
                <p class="warning">Cette action est irréversible et supprimera également toutes les publications associées à ce module.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeDeleteModuleModal()">Annuler</button>
                <form action="../../../app/controlleurs/AdminController.php" method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="deleteModule">
                    <input type="hidden" name="module_id" id="moduleIdToDelete" value="">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fonctions pour la gestion des modules
        function openAddModuleModal() {
            document.getElementById('modalTitle').textContent = 'Nouveau Module';
            document.getElementById('moduleAction').value = 'createModule';
            document.getElementById('moduleId').value = '';
            document.getElementById('moduleForm').reset();
            document.getElementById('moduleModal').style.display = 'block';
        }

        function editModule(moduleId) {
            // Ici vous pouvez charger les données du module via AJAX
            // Pour l'instant, on simule avec des données statiques
            document.getElementById('modalTitle').textContent = 'Modifier le Module';
            document.getElementById('moduleAction').value = 'updateModule';
            document.getElementById('moduleId').value = moduleId;
            document.getElementById('moduleModal').style.display = 'block';
        }

        function closeModuleModal() {
            document.getElementById('moduleModal').style.display = 'none';
        }

        function deleteModule(moduleId, moduleName) {
            document.getElementById('moduleNameToDelete').textContent = moduleName;
            document.getElementById('moduleIdToDelete').value = moduleId;
            document.getElementById('deleteModuleModal').style.display = 'block';
        }

        function closeDeleteModuleModal() {
            document.getElementById('deleteModuleModal').style.display = 'none';
        }

        function filterModules() {
            const searchTerm = document.getElementById('searchModules').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const modules = document.querySelectorAll('.module-card');

            modules.forEach(module => {
                const name = module.dataset.name.toLowerCase();
                const status = module.dataset.status;
                const matchesSearch = name.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;

                if (matchesSearch && matchesStatus) {
                    module.style.display = 'block';
                } else {
                    module.style.display = 'none';
                }
            });
        }

        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            const moduleModal = document.getElementById('moduleModal');
            const deleteModal = document.getElementById('deleteModuleModal');
            
            if (event.target === moduleModal) {
                closeModuleModal();
            }
            if (event.target === deleteModal) {
                closeDeleteModuleModal();
            }
        }
    </script>
</body>
</html>
