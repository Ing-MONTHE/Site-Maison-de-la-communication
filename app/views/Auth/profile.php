<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Site-Maison-de-la-communication/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Site-Maison-de-la-communication/config/Auth.php';
use Config\Database;
use Config\Auth;

// Check if user is authenticated
if (!Auth::isAuthenticated()) {
    header('Location: /Site-Maison-de-la-communication/app/views/Auth/login.php');
    exit();
}

// Get user data from database
$db = Database::getConnection();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($username) || empty($email)) {
        $error = 'Le nom d\'utilisateur et l\'email sont requis';
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
    } else {
        try {
            if (!empty($new_password)) {
                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$username, $email, $hashedPassword, $_SESSION['user_id']]);
            } else {
                $stmt = $db->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
                $stmt->execute([$username, $email, $_SESSION['user_id']]);
            }
            
            // Update session
            $_SESSION['username'] = $username;
            $_SESSION['user_email'] = $email;
            
            $message = 'Profil mis à jour avec succès';
            
            // Refresh user data
            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $error = 'Erreur lors de la mise à jour du profil';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil — MCC</title>
    <link rel="stylesheet" href="/Site-Maison-de-la-communication/public/assets/css/styles.css">
    <link rel="stylesheet" href="/Site-Maison-de-la-communication/public/assets/css/profile.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <h1>Mon Profil</h1>
                <p>Gérez vos informations personnelles</p>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="profile-info">
                <div class="info-section">
                    <h3>Informations actuelles</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nom d'utilisateur:</label>
                            <span><?= htmlspecialchars($user['username']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Email:</label>
                            <span><?= htmlspecialchars($user['email']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Rôle:</label>
                            <span><?= htmlspecialchars($user['role']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Membre depuis:</label>
                            <span><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
                        </div>
                    </div>
                </div>

                <div class="edit-section">
                    <h3>Modifier mon profil</h3>
                    <form method="POST" class="profile-form">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur *</label>
                            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" id="new_password" name="new_password" minlength="8">
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                            <input type="password" id="confirm_password" name="confirm_password" minlength="8">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="profile-actions">
                <a href="/Site-Maison-de-la-communication/index.php" class="btn btn-outline">← Retour à l'accueil</a>
                <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
            </div>
        </div>
    </div>
</body>
</html>
