<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inscription — MCC</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css" />
  <style>
    body { font-family: 'Poppins', sans-serif; margin:0; }
    .auth { min-height: 100vh; display: grid; place-items: center; background: linear-gradient(135deg, #0b7c66 0%, #0b967c 100%); padding: 24px; }
    .auth-card { width: min(520px, 92%); background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 18px 50px rgba(0,0,0,0.15); }
    .auth-card h1 { margin: 0 0 14px; font-size: 24px; color: #1e2a36; }
    .auth-card label { display: block; font-weight: 600; margin: 12px 0 6px; }
    .auth-card input, .auth-card select { width: 100%; padding: 12px 14px; border: 1px solid #d3dbe5; border-radius: 10px; outline: none; font-family: inherit; }
    .auth-card .row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    @media (max-width:720px){ .auth-card .row { grid-template-columns: 1fr; } }
    .auth-card .actions { display: flex; justify-content: space-between; align-items: center; margin-top: 14px; gap: 10px; }
    .auth-card .btn { width: 100%; text-align: center; background:#0b7c66; color:#fff; border:none; padding:12px; border-radius:10px; font-weight:600; cursor:pointer; }
    .auth-card .btn:hover { background:#096856; }
    .auth-card .link { font-size:14px; color:#0b7c66; text-decoration:none; }
    .auth-card .link:hover { text-decoration:underline; }
    .error { color:red; margin-top:10px; font-size:14px; }
  </style>
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
