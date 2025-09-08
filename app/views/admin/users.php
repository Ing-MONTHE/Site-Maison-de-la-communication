<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../../../config/Database.php';
use Config\Database;

$db = Database::getConnection();

// Récupération des utilisateurs
$usersQuery = $db->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration MCC - Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-users">
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
                    
                    <li class="nav-item active">
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
                    <h1>Gestion des Utilisateurs</h1>
                    <p>Gérer les comptes utilisateurs et les permissions</p>
                </div>
                <div class="header-actions"></div>
            </header>
            
            <div class="admin-content">
                <!-- Filtres -->
                <section class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label for="role-filter">Rôle</label>
                            <select id="role-filter" class="form-select">
                                <option value="">Tous les rôles</option>
                                <option value="visiteur">Visiteur</option>
                                <option value="visiteur_auth">Visiteur authentifié</option>
                                <option value="personnel">Personnel</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="search-filter">Recherche</label>
                            <input type="text" id="search-filter" class="form-input" placeholder="Rechercher...">
                        </div>
                    </div>
                </section>
                
                <!-- Liste des utilisateurs -->
                <section class="users-list">
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr data-id="<?php echo $user['id']; ?>" data-role="<?php echo $user['role']; ?>" data-username="<?php echo htmlspecialchars($user['username']); ?>" data-email="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="user-details">
                                                    <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                                    <span class="user-id">ID: <?php echo $user['id']; ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($user['email'] ?? 'Non renseigné'); ?>
                                        </td>
                                        <td>
                                            <span class="role-badge role-<?php echo $user['role']; ?>">
                                                <?php echo ucfirst(str_replace('_', ' ', $user['role'])); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button onclick="editUser(<?php echo $user['id']; ?>)" 
                                                        class="btn btn-sm btn-outline" title="Modifier le rôle">
                                                    <i class="fas fa-user-shield"></i>
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
    
    
    
    <!-- Modal de modification d'utilisateur -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Modifier l'utilisateur</h3>
                <button onclick="closeEditUserModal()" class="btn-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../../../app/controlleurs/AdminController.php" class="user-form">
                    <input type="hidden" name="action" value="updateUserRole">
                    <input type="hidden" id="edit-user-id" name="id">
                    
                    <div class="form-group">
                        <label>Utilisateur</label>
                        <input type="text" id="edit-username" class="form-input" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" id="edit-email" class="form-input" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-role">Rôle</label>
                        <select id="edit-role" name="role" class="form-select">
                            <option value="visiteur">Visiteur</option>
                            <option value="visiteur_auth">Visiteur authentifié</option>
                            <option value="personnel">Personnel</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Mettre à jour le rôle
                        </button>
                        <button type="button" onclick="closeEditUserModal()" class="btn btn-outline">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function editUser(id) {
            const row = document.querySelector(`tr[data-id='${id}']`);
            if (!row) return;
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-username').value = row.dataset.username || '';
            document.getElementById('edit-email').value = row.dataset.email || '';
            document.getElementById('edit-role').value = row.dataset.role || 'visiteur';
            document.getElementById('editUserModal').style.display = 'flex';
        }
        
        function closeEditUserModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }
        
        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            const editModal = document.getElementById('editUserModal');
            
            if (event.target === editModal) {
                closeEditUserModal();
            }
        }
        
        // Filtrage des utilisateurs
        document.getElementById('role-filter').addEventListener('change', filterUsers);
        document.getElementById('search-filter').addEventListener('input', filterUsers);
        
        function filterUsers() {
            const roleFilter = document.getElementById('role-filter').value;
            const searchFilter = document.getElementById('search-filter').value.toLowerCase();
            
            const userRows = document.querySelectorAll('tbody tr');
            
            userRows.forEach(row => {
                const role = row.dataset.role;
                const username = row.querySelector('.user-details strong').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                const roleMatch = !roleFilter || role === roleFilter;
                const searchMatch = !searchFilter || username.includes(searchFilter) || email.includes(searchFilter);
                
                if (roleMatch && searchMatch) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
