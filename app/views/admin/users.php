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
                <div class="header-actions">
                    <button onclick="openCreateUserModal()" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                        Nouvel utilisateur
                    </button>
                </div>
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
                                    <tr data-role="<?php echo $user['role']; ?>">
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
                                                        class="btn btn-sm btn-outline" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <?php if ($user['id'] != $_SESSION['admin_user_id']): ?>
                                                    <button onclick="deleteUser(<?php echo $user['id']; ?>)" 
                                                            class="btn btn-sm btn-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
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
    
    <!-- Modal de création d'utilisateur -->
    <div id="createUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Nouvel utilisateur</h3>
                <button onclick="closeCreateUserModal()" class="btn-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../../../app/controlleurs/AdminController.php" class="user-form">
                    <input type="hidden" name="action" value="createUser">
                    
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur *</label>
                        <input type="text" id="username" name="username" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe *</label>
                        <input type="password" id="password" name="password" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Rôle</label>
                        <select id="role" name="role" class="form-select">
                            <option value="visiteur">Visiteur</option>
                            <option value="visiteur_auth">Visiteur authentifié</option>
                            <option value="personnel">Personnel</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Créer l'utilisateur
                        </button>
                        <button type="button" onclick="closeCreateUserModal()" class="btn btn-outline">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
                    <input type="hidden" name="action" value="updateUser">
                    <input type="hidden" id="edit-user-id" name="id">
                    
                    <div class="form-group">
                        <label for="edit-username">Nom d'utilisateur *</label>
                        <input type="text" id="edit-username" name="username" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-email">Email</label>
                        <input type="email" id="edit-email" name="email" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" id="edit-password" name="password" class="form-input">
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
                            Mettre à jour
                        </button>
                        <button type="button" onclick="closeEditUserModal()" class="btn btn-outline">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
            <div class="modal-actions">
                <button onclick="closeDeleteModal()" class="btn btn-outline">Annuler</button>
                <button onclick="confirmDelete()" class="btn btn-danger">Supprimer</button>
            </div>
        </div>
    </div>
    
    <script>
        let userToDelete = null;
        
        function openCreateUserModal() {
            document.getElementById('createUserModal').style.display = 'flex';
        }
        
        function closeCreateUserModal() {
            document.getElementById('createUserModal').style.display = 'none';
        }
        
        function editUser(id) {
            // Récupérer les données de l'utilisateur via AJAX ou les passer en paramètre
            // Pour simplifier, on utilise des données statiques
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-username').value = 'Utilisateur ' + id;
            document.getElementById('edit-email').value = 'user' + id + '@example.com';
            document.getElementById('edit-role').value = 'visiteur';
            document.getElementById('editUserModal').style.display = 'flex';
        }
        
        function closeEditUserModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }
        
        function deleteUser(id) {
            userToDelete = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            userToDelete = null;
        }
        
        function confirmDelete() {
            if (userToDelete) {
                window.location.href = `../../../app/controlleurs/AdminController.php?action=deleteUser&id=${userToDelete}`;
            }
        }
        
        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            const createModal = document.getElementById('createUserModal');
            const editModal = document.getElementById('editUserModal');
            const deleteModal = document.getElementById('deleteModal');
            
            if (event.target === createModal) {
                closeCreateUserModal();
            } else if (event.target === editModal) {
                closeEditUserModal();
            } else if (event.target === deleteModal) {
                closeDeleteModal();
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
