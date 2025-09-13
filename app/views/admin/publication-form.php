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

// Récupération des utilisateurs
$usersQuery = $db->query("SELECT id, username FROM users WHERE role IN ('admin', 'personnel') ORDER BY username");
$users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);

$publication = null;
$action = $_GET['action'] ?? 'create';

if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM publications WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $publication = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$publication) {
        header('Location: publications.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration MCC - <?php echo $action === 'create' ? 'Nouvelle publication' : 'Modifier publication'; ?></title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../../../public/assets/js/admin-mobile.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body class="admin-publication-form">
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
                    <h1><?php echo $action === 'create' ? 'Nouvelle publication' : 'Modifier publication'; ?></h1>
                    <p>Créer ou modifier le contenu d'une publication</p>
                </div>
                <div class="header-actions">
                    <button type="button" onclick="previewPublication()" class="btn btn-outline">
                        <i class="fas fa-eye"></i>
                        Prévisualiser
                    </button>
                    <a href="publications.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        Retour
                    </a>
                </div>
            </header>
            
            <div class="admin-content">
                <form method="POST" action="../../../app/controlleurs/AdminController.php" class="publication-form">
                    <input type="hidden" name="action" value="<?php echo $action === 'create' ? 'createPublication' : 'updatePublication'; ?>">
                    <?php if ($publication): ?>
                        <input type="hidden" name="id" value="<?php echo $publication['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-grid">
                        <!-- Informations principales -->
                        <div class="form-section">
                            <h3>Informations principales</h3>
                            
                            <div class="form-group">
                                <label for="titre">Titre *</label>
                                <input type="text" id="titre" name="titre" 
                                       value="<?php echo htmlspecialchars($publication['titre'] ?? ''); ?>" 
                                       required class="form-input">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="module_id">Module *</label>
                                    <select id="module_id" name="module_id" required class="form-select">
                                        <option value="">Sélectionner un module</option>
                                        <?php foreach ($modules as $module): ?>
                                            <option value="<?php echo $module['id']; ?>" 
                                                    <?php echo ($publication['module_id'] ?? '') == $module['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($module['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="auteur_id">Auteur</label>
                                    <select id="auteur_id" name="auteur_id" class="form-select">
                                        <option value="">Sélectionner un auteur</option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?php echo $user['id']; ?>" 
                                                    <?php echo ($publication['auteur_id'] ?? '') == $user['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($user['username']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="statut">Statut</label>
                                <select id="statut" name="statut" class="form-select">
                                    <option value="brouillon" <?php echo ($publication['statut'] ?? 'brouillon') === 'brouillon' ? 'selected' : ''; ?>>Brouillon</option>
                                    <option value="publie" <?php echo ($publication['statut'] ?? '') === 'publie' ? 'selected' : ''; ?>>Publié</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Contenu -->
                        <div class="form-section">
                            <h3>Contenu</h3>
                            
                            <div class="form-group">
                                <label for="contenu">Contenu *</label>
                                <textarea id="contenu" name="contenu" required class="form-textarea">
                                    <?php echo htmlspecialchars($publication['contenu'] ?? ''); ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <?php echo $action === 'create' ? 'Créer la publication' : 'Mettre à jour'; ?>
                        </button>
                        
                        <button type="button" onclick="saveDraft()" class="btn btn-outline">
                            <i class="fas fa-save"></i>
                            Enregistrer comme brouillon
                        </button>
                        
                        <a href="publications.php" class="btn btn-outline">
                            <i class="fas fa-times"></i>
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <!-- Modal de prévisualisation -->
    <div id="previewModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h3>Prévisualisation</h3>
                <button onclick="closePreviewModal()" class="btn-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="preview-content"></div>
            </div>
        </div>
    </div>
    
    <script>
        // Initialisation de TinyMCE
        tinymce.init({
            selector: '#contenu',
            height: 400,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        });
        
        function previewPublication() {
            const titre = document.getElementById('titre').value;
            const contenu = tinymce.get('contenu').getContent();
            const module = document.getElementById('module_id').options[document.getElementById('module_id').selectedIndex].text;
            
            const previewHTML = `
                <div class="preview-publication">
                    <header class="preview-header">
                        <h1>${titre}</h1>
                        <div class="preview-meta">
                            <span class="module-badge">${module}</span>
                            <span class="preview-date">${new Date().toLocaleDateString('fr-FR')}</span>
                        </div>
                    </header>
                    <div class="preview-content">
                        ${contenu}
                    </div>
                </div>
            `;
            
            document.getElementById('preview-content').innerHTML = previewHTML;
            document.getElementById('previewModal').style.display = 'flex';
        }
        
        function closePreviewModal() {
            document.getElementById('previewModal').style.display = 'none';
        }
        
        function saveDraft() {
            document.getElementById('statut').value = 'brouillon';
            document.querySelector('form').submit();
        }
        
        // Fermer le modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('previewModal');
            if (event.target === modal) {
                closePreviewModal();
            }
        }
    </script>
</body>
</html>
