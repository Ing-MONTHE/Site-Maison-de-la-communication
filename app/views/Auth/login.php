<!DOCTYPE html> 
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Connexion — MCC</title>
  <link rel="stylesheet" href="../../../public/assets/css/styles.css" />
  <link rel="stylesheet" href="../../../public/assets/css/login.css" />
</head>
<body>
  <div class="auth">
    <form class="auth-card" action="../../controlleurs/AuthController.php?action=login" method="post">
      <h1>Connexion</h1>

      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" placeholder="vous@exemple.com" required />

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" placeholder="••••••••" required />

      <div class="actions">
        <a href="../../../index.php" class="link">← Retour à l'accueil</a>
        <a href="register.php" class="link">Créer un compte</a>
      </div>

      <div style="margin-top:14px">
        <button class="btn" type="submit">Se connecter</button>
      </div>

      <?php if (!empty($_GET['error'])) : ?>
        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
