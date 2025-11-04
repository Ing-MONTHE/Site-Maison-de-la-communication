<?php
session_start();
// Aligner la vérification de session avec le tableau de bord
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/Site-Maison-de-la-communication/config/Database.php';
$pdo = Config\Database::getConnection();

// Récupération des modules (sélectionner uniquement les colonnes sûres)
$stmt = $pdo->query("SELECT id, name, description, created_at FROM modules ORDER BY name");
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
<body class="admin-modules">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="../../../Images/logo.png" alt="MCC Logo" class="sidebar-logo">
                <h2><i class="fas fa-cogs"></i> Administration</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item active">
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
                            <span>Média</span>
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
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-content">
                    <h1>Gestion des Modules</h1>
                    <p>Gérez les services et modules de votre plateforme</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-primary" onclick="openAddModuleModal()">
                        <i class="fas fa-plus"></i>
                        Nouveau Module
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                <!-- Filtres et recherche -->
                <section class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label for="searchModules">Recherche</label>
                            <div class="search-box" style="position:relative;">
                                <input type="text" id="searchModules" class="form-input" placeholder="Rechercher un module..." onkeyup="filterModules()">
                                <i class="fas fa-search" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--muted);"></i>
                            </div>
                        </div>
                        <div class="filter-group">
                            <label for="statusFilter">Statut</label>
                            <select id="statusFilter" class="form-select" onchange="filterModules()">
                                <option value="">Tous les statuts</option>
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                            </select>
                        </div>
                    </div>
                </section>

                <!-- Liste des modules -->
                <section class="modules-section">
                    <div class="modules-grid">
                        <?php foreach ($modules as $module): ?>
                        <div class="module-card" data-name="<?= htmlspecialchars($module['name']) ?>" data-status="<?= $module['statut'] ?? 'actif' ?>">
                            <div class="module-header">
                        <div class="module-icon">
                                    <?php if (isset($module['logo_path']) && !empty($module['logo_path']) && file_exists('../../../' . $module['logo_path'])): ?>
                                        <img src="../../../<?= htmlspecialchars($module['logo_path']) ?>" alt="Logo <?= htmlspecialchars($module['name']) ?>" style="width:40px; height:40px; object-fit:contain;">
                                    <?php else: ?>
                                        <i class="fas fa-cog"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="module-status <?= (($module['statut'] ?? 'actif') === 'actif') ? 'active' : 'inactive' ?>">
                                    <?= (($module['statut'] ?? 'actif') === 'actif') ? 'Actif' : 'Inactif' ?>
                                </div>
                            </div>
                            <div class="module-content">
                                <h3><?= htmlspecialchars($module['name']) ?></h3>
                                <p class="module-description">
                                    <?= htmlspecialchars($module['description'] ?? 'Aucune description disponible') ?>
                                </p>
                                <div class="module-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        Créé le <?= date('d/m/Y', strtotime(($module['created_at'] ?? 'now'))) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="module-actions">
                                <button class="btn btn-sm btn-secondary" onclick="editModule(<?= $module['id'] ?>)">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDeleteModule(<?= $module['id'] ?>, '<?= htmlspecialchars($module['name'], ENT_QUOTES) ?>')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- Message si aucun module -->
                <?php if (empty($modules)): ?>
                <div class="empty-state" style="text-align:center;padding:40px;background:var(--white);border-radius:12px;box-shadow:var(--shadow-sm);">
                    <i class="fas fa-cogs" style="font-size:36px;color:var(--brand);"></i>
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
    <div id="moduleModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2 id="modalTitle">Nouveau Module</h2>
                <button type="button" class="btn-close" aria-label="Fermer" onclick="closeModuleModal()">&times;</button>
            </div>
            <form id="moduleForm" action="../../../app/controlleurs/AdminController.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="moduleAction" value="createModule">
                <input type="hidden" name="module_id" id="moduleId" value="">
                
                <div class="form-group">
                    <label for="moduleName">Nom du module *</label>
                    <input type="text" id="moduleName" name="nom" class="form-input" required placeholder="Ex: RVE, Imprimerie, SerCom">
                </div>

                <div class="form-group">
                    <label for="moduleDescription">Description</label>
                    <textarea id="moduleDescription" name="description" class="form-textarea" rows="4" placeholder="Description détaillée du module..."></textarea>
                </div>

                <div class="form-group">
                    <label for="moduleStatus">Statut</label>
                    <select id="moduleStatus" name="statut" class="form-select">
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="moduleLogo">Logo du module</label>
                    <input type="file" id="moduleLogo" name="logo" class="form-input" accept="image/*">
                    <small class="form-help">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</small>
                    <div id="logoPreview" class="logo-preview" style="display: none;">
                        <img id="previewImage" src="" alt="Aperçu du logo" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                    </div>
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

    <script>
        // Fonctions pour la gestion des modules
        function openAddModuleModal() {
            document.getElementById('modalTitle').textContent = 'Nouveau Module';
            document.getElementById('moduleAction').value = 'createModule';
            document.getElementById('moduleId').value = '';
            document.getElementById('moduleForm').reset();
            document.getElementById('moduleStatus').value = 'actif';
            document.getElementById('logoPreview').style.display = 'none';
            document.getElementById('moduleModal').style.display = 'flex';
        }

        function editModule(moduleId) {
            // Charger les données via l'action getModule (JSON)
            fetch(`../../../app/controlleurs/AdminController.php?action=getModule&id=${moduleId}`)
                .then(r => r.json())
                .then(data => {
                    if (data && !data.error) {
                        document.getElementById('modalTitle').textContent = 'Modifier le Module';
                        document.getElementById('moduleAction').value = 'updateModule';
                        document.getElementById('moduleId').value = data.id;
                        document.getElementById('moduleName').value = data.name || '';
                        document.getElementById('moduleDescription').value = data.description || '';
                        document.getElementById('moduleStatus').value = (data.statut || 'actif');
                        
                        // Gérer l'affichage du logo existant
                        const logoInput = document.getElementById('moduleLogo');
                        const logoPreview = document.getElementById('logoPreview');
                        const previewImage = document.getElementById('previewImage');
                        
                        // Réinitialiser le champ de fichier
                        logoInput.value = '';
                        
                        // Afficher le logo existant s'il existe
                        if (data.logo_path) {
                            previewImage.src = '../../../' + data.logo_path;
                            logoPreview.style.display = 'block';
                        } else {
                            logoPreview.style.display = 'none';
                        }
                        
                        document.getElementById('moduleModal').style.display = 'flex';
                    } else {
                        alert('Impossible de charger le module.');
                    }
                })
                .catch(() => alert('Erreur de chargement du module.'));
        }

        function closeModuleModal() {
            document.getElementById('moduleModal').style.display = 'none';
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
            if (event.target === moduleModal) { closeModuleModal(); }
        }

        // Échap pour fermer rapidement
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModuleModal();
            }
        });

        // Gestion de l'aperçu du logo
        document.getElementById('moduleLogo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('logoPreview');
            const previewImage = document.getElementById('previewImage');
            
            if (file) {
                // Vérifier la taille du fichier (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux. Taille maximum: 2MB');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Vérifier le type de fichier
                if (!file.type.startsWith('image/')) {
                    alert('Veuillez sélectionner un fichier image valide.');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Afficher l'aperçu
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Fonction de confirmation de suppression
        function confirmDeleteModule(moduleId, moduleName) {
            if (confirm(`Voulez-vous vraiment supprimer le module "${moduleName}" ?\n\nCette action est irréversible et supprimera définitivement le module.`)) {
                // Créer un formulaire temporaire pour soumettre la suppression
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../../../app/controlleurs/AdminController.php';
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'deleteModule';
                
                const moduleIdInput = document.createElement('input');
                moduleIdInput.type = 'hidden';
                moduleIdInput.name = 'module_id';
                moduleIdInput.value = moduleId;
                
                form.appendChild(actionInput);
                form.appendChild(moduleIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
