<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inscription — MCC</title>
  <link rel="stylesheet" href="../../../public/assets/css/styles.css" />
  <link rel="stylesheet" href="../../../public/assets/css/register.css" />
</head>
<body>
  <div class="auth">
    <form class="auth-card" action="index.php?controller=auth&action=register" method="post">
      <h1>Créer un compte</h1>

      <div class="row">
        <div>
          <label for="lastname">Nom</label>
          <input type="text" id="lastname" name="lastname" required />
        </div>
        <div>
          <label for="firstname">Prénom</label>
          <input type="text" id="firstname" name="firstname" required />
        </div>
      </div>

      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" minlength="8" required />

      <label for="confirm">Confirmer le mot de passe</label>
      <input type="password" id="confirm" name="confirm" minlength="8" required />

      <div class="actions">
        <a href="index.php?controller=auth&action=login" class="link">Déjà un compte ? Se connecter →</a>
      </div>

      <div style="margin-top:14px">
        <button class="btn" type="submit">S’inscrire</button>
      </div>

      <?php if (!empty($error)) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
