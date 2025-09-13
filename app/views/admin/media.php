<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../../../config/Database.php';
use Config\Database;

$db = Database::getConnection();

// Récupération des médias avec informations des publications
$mediaQuery = $db->query("
    SELECT m.*, p.titre as publication_title 
    FROM media m 
    LEFT JOIN publications p ON m.publication_id = p.id 
    ORDER BY m.uploaded_at DESC
");
$media = $mediaQuery->fetchAll(PDO::FETCH_ASSOC);

// Récupération des publications pour l'association
$publicationsQuery = $db->query("SELECT id, titre FROM publications ORDER BY titre");
$publications = $publicationsQuery->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration MCC - Gestion des Médias</title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../../../public/assets/js/admin-mobile.js"></script>
</head>
<body class="admin-media">
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
                    
                    <li class="nav-item active">
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
                    <h1>Gestion des Médias</h1>
                    <p>Télécharger, organiser et gérer les fichiers multimédias</p>
                </div>
                <div class="header-actions">
                    <button onclick="openUploadModal()" class="btn btn-primary">
                        <i class="fas fa-upload"></i>
                        Upload média
                    </button>
                </div>
            </header>
            
            <div class="admin-content">
                <!-- Filtres -->
                <section class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label for="type-filter">Type</label>
                            <select id="type-filter" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="image">Images</option>
                                <option value="video">Vidéos</option>
                                <option value="audio">Audio</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="format-filter">Format</label>
                            <select id="format-filter" class="form-select">
                                <option value="">Tous les formats</option>
                                <option value="jpg">JPG</option>
                                <option value="png">PNG</option>
                                <option value="gif">GIF</option>
                                <option value="mp4">MP4</option>
                                <option value="mp3">MP3</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="search-filter">Recherche</label>
                            <input type="text" id="search-filter" class="form-input" placeholder="Rechercher...">
                        </div>
                    </div>
                </section>
                
                <!-- Grille des médias -->
                <section class="media-grid-section">
                    <div class="media-grid">
                        <?php foreach ($media as $item): ?>
                            <div class="media-card" data-type="<?php echo $item['type']; ?>" data-format="<?php echo $item['format']; ?>">
                                <div class="media-preview">
                                    <?php if ($item['type'] === 'image'): ?>
                                        <img src="<?php echo htmlspecialchars($item['chemin']); ?>" alt="Image" class="media-thumbnail">
                                    <?php elseif ($item['type'] === 'video'): ?>
                                        <div class="media-thumbnail video-thumbnail">
                                            <i class="fas fa-play"></i>
                                            <span class="format-badge"><?php echo strtoupper($item['format']); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="media-thumbnail audio-thumbnail">
                                            <i class="fas fa-music"></i>
                                            <span class="format-badge"><?php echo strtoupper($item['format']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="media-info">
                                    <h4><?php echo htmlspecialchars(basename($item['chemin'])); ?></h4>
                                    <p class="media-meta">
                                        <span class="type-badge type-<?php echo $item['type']; ?>">
                                            <?php echo ucfirst($item['type']); ?>
                                        </span>
                                        <span class="size-info">
                                            <?php echo formatFileSize($item['taille']); ?>
                                        </span>
                                    </p>
                                    
                                    <?php if ($item['publication_title']): ?>
                                        <p class="publication-link">
                                            <i class="fas fa-link"></i>
                                            <?php echo htmlspecialchars($item['publication_title']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <p class="upload-date">
                                        <?php echo date('d/m/Y H:i', strtotime($item['uploaded_at'])); ?>
                                    </p>
                                </div>
                                
                                <div class="media-actions">
                                    <button onclick="previewMedia('<?php echo htmlspecialchars($item['chemin']); ?>', '<?php echo $item['type']; ?>')" 
                                            class="btn btn-sm btn-outline" title="Prévisualiser">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="editMedia(<?php echo $item['id']; ?>)" 
                                            class="btn btn-sm btn-outline" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteMedia(<?php echo $item['id']; ?>)" 
                                            class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </main>
    </div>
    
    <!-- Modal d'upload -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Upload de média</h3>
                <button onclick="closeUploadModal()" class="btn-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../../../app/controlleurs/AdminController.php" enctype="multipart/form-data" class="upload-form">
                    <input type="hidden" name="action" value="uploadMedia">
                    
                    <div class="form-group">
                        <label for="media-files">Sélectionner les fichiers</label>
                        <input type="file" id="media-files" name="media_files[]" multiple accept="image/*,video/*,audio/*" required>
                        <p class="form-help">Formats acceptés : JPG, PNG, GIF, MP4, MP3. Taille max : 10MB par fichier</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="publication_id">Associer à une publication (optionnel)</label>
                        <select id="publication_id" name="publication_id" class="form-select">
                            <option value="">Aucune association</option>
                            <?php foreach ($publications as $pub): ?>
                                <option value="<?php echo $pub['id']; ?>"><?php echo htmlspecialchars($pub['titre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i>
                            Upload
                        </button>
                        <button type="button" onclick="closeUploadModal()" class="btn btn-outline">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
    
    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer ce média ?</p>
            <div class="modal-actions">
                <button onclick="closeDeleteModal()" class="btn btn-outline">Annuler</button>
                <button onclick="confirmDelete()" class="btn btn-danger">Supprimer</button>
            </div>
        </div>
    </div>
    
    <script>
        let mediaToDelete = null;
        
        function openUploadModal() {
            document.getElementById('uploadModal').style.display = 'flex';
        }
        
        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
        }
        
        function previewMedia(path, type) {
            const modal = document.getElementById('previewModal');
            const content = document.getElementById('preview-content');
            
            if (type === 'image') {
                content.innerHTML = `<img src="${path}" alt="Prévisualisation" style="max-width: 100%; height: auto;">`;
            } else if (type === 'video') {
                content.innerHTML = `
                    <video controls style="max-width: 100%; height: auto;">
                        <source src="${path}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                `;
            } else if (type === 'audio') {
                content.innerHTML = `
                    <audio controls style="width: 100%;">
                        <source src="${path}" type="audio/mpeg">
                        Votre navigateur ne supporte pas la lecture audio.
                    </audio>
                `;
            }
            
            modal.style.display = 'flex';
        }
        
        function closePreviewModal() {
            document.getElementById('previewModal').style.display = 'none';
        }
        
        function editMedia(id) {
            // Redirection vers la page d'édition
            window.location.href = `media.php?action=edit&id=${id}`;
        }
        
        function deleteMedia(id) {
            mediaToDelete = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            mediaToDelete = null;
        }
        
        function confirmDelete() {
            if (mediaToDelete) {
                window.location.href = `../../../app/controlleurs/AdminController.php?action=deleteMedia&id=${mediaToDelete}`;
            }
        }
        
        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            const uploadModal = document.getElementById('uploadModal');
            const previewModal = document.getElementById('previewModal');
            const deleteModal = document.getElementById('deleteModal');
            
            if (event.target === uploadModal) {
                closeUploadModal();
            } else if (event.target === previewModal) {
                closePreviewModal();
            } else if (event.target === deleteModal) {
                closeDeleteModal();
            }
        }
        
        // Filtrage des médias
        document.getElementById('type-filter').addEventListener('change', filterMedia);
        document.getElementById('format-filter').addEventListener('change', filterMedia);
        document.getElementById('search-filter').addEventListener('input', filterMedia);
        
        function filterMedia() {
            const typeFilter = document.getElementById('type-filter').value;
            const formatFilter = document.getElementById('format-filter').value;
            const searchFilter = document.getElementById('search-filter').value.toLowerCase();
            
            const mediaCards = document.querySelectorAll('.media-card');
            
            mediaCards.forEach(card => {
                const type = card.dataset.type;
                const format = card.dataset.format;
                const title = card.querySelector('h4').textContent.toLowerCase();
                
                const typeMatch = !typeFilter || type === typeFilter;
                const formatMatch = !formatFilter || format === formatFilter;
                const searchMatch = !searchFilter || title.includes(searchFilter);
                
                if (typeMatch && formatMatch && searchMatch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

<?php
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
?>
