<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration MCC - Connexion</title>
    <link rel="stylesheet" href="../../../public/assets/css/admin.css">
</head>
<body class="admin-login">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="../../../Images/logo.png" alt="MCC Logo" class="login-logo">
                <h1>Administration MCC</h1>
                <p>Connexion sécurisée</p>
            </div>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="../../../app/controlleurs/AdminController.php" class="login-form">
                <input type="hidden" name="action" value="login">
                
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
            </form>
            
            <div class="login-footer">
                <a href="../../../index.php" class="link-back">← Retour au site public</a>
            </div>
        </div>
    </div>
</body>
</html>
