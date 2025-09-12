<?php
session_start();
require_once 'config/Auth.php';
use Config\Auth;
require_once 'config/Database.php';
use Config\Database;

// Récupération des modules depuis la base de données
$modules = [];
try {
  $pdo = Database::getConnection();
  $stmt = $pdo->query("SELECT id, name, description, logo_path FROM modules ORDER BY created_at DESC");
  $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  $modules = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Maison Catholique de la Communication - Accueil</title>
  <link rel="stylesheet" href="public/assets/css/styles.css" />
</head>
  <body>
  
  <!-- Messages de notification -->
  <?php if (isset($_GET['success'])): ?>
  <div class="notification success">
    <div class="container">
      <p><?= htmlspecialchars($_GET['success']) ?></p>
      <button class="close-notification" onclick="this.parentElement.parentElement.remove()">×</button>
    </div>
  </div>
  <?php endif; ?>
  
  <?php if (isset($_GET['error'])): ?>
  <div class="notification error">
    <div class="container">
      <p><?= htmlspecialchars($_GET['error']) ?></p>
      <button class="close-notification" onclick="this.parentElement.parentElement.remove()">×</button>
    </div>
  </div>
  <?php endif; ?>

  <!-- Header principal -->
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="#">
        <img src="assets/logo-rve.svg" alt="Logo MCC - RVE" onerror="this.style.display='none'" />
        <img src="Images/Logo Diocese.png" alt="Logo du diocèse" style="height:32px;margin:0 10px" />
        <span>Maison Catholique de la Communication</span>
      </a>
      <nav class="main-nav" aria-label="Navigation principale">
        <a href="#agence">L'Agence</a>
        <a href="#modules">Expertises</a>
        <a href="#blog">Blog</a>
        <a href="#contact">Contact</a>
        <?php if (Auth::isPublic()): ?>
        <a class="btn btn-outline" href="app/views/Auth/login.php">Se connecter</a>
        <a class="btn" href="app/views/Auth/register.php">S'inscrire</a>
        <?php elseif (Auth::isAuthenticated()): ?>
        <a class="btn btn-outline" href="app/views/Auth/profile.php">Mon profil</a>
        <a class="btn" href="app/views/Auth/logout.php">Déconnexion</a>
        <?php elseif (Auth::isAdmin()): ?>
        <a class="btn btn-outline" href="app/views/admin/">Administration</a>
        <a class="btn" href="app/controlleurs/AdminController.php?action=logout">Déconnexion</a>
        <?php endif; ?>
      </nav>
      <button class="nav-toggle" aria-label="Ouvrir le menu">☰</button>
    </div>
  </header>

  <!-- Hero / Bandeau -->
  <section class="hero">
    <div class="overlay"></div>
    <div class="container hero-content">
      <h1>Numérisez, diffusez et valorisez votre Mission</h1>
      <p>Là où la technologie rencontre la spiritualité, nous créons des ponts entre les cœurs et propageons la Bonne Nouvelle à travers tous les médias.</p>
      <div class="cta-group">
        <a class="btn" href="#modules">Découvrir nos modules</a>
        <?php if (Auth::canAccessAdmin()): ?>
        <a class="btn btn-light" href="app/views/admin/">Accès administration</a>
        <?php endif; ?>
        <?php if (Auth::isPublic()): ?>
        <a class="btn" href="app/views/Auth/register.php">Créer un compte</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Présentation rapide -->
  <section class="about" id="agence">
    <div class="container grid-2">
      <div>
        <h2>Une agence au service de l'Église et de la communication</h2>
        <p>
          Avec une équipe pluridisciplinaire, nous produisons et diffusons des contenus
          multimédias, assurons l'identité visuelle, l'impression et la valorisation des
          activités pastorales et institutionnelles. Notre plateforme offre une expérience
          fluide pour consulter, écouter et interagir.
        </p>
        <ul class="checks">
          <li>Diffusion en direct et à la demande</li>
          <li>Gestion moderne des médias (photos, vidéos, podcasts)</li>
          <li>Back‑office sécurisé avec prévisualisation</li>
        </ul>
      </div>
      <div class="about-media">
        <div class="video-thumb">
          <img src="https://images.unsplash.com/photo-1551277085-2c361c29e1b1?q=80&w=1200&auto=format&fit=crop" alt="Studio radio" />
          <button class="play">▶</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Modules style cartes (comme la 2e image) -->
  <section class="modules" id="modules">
    <div class="container">
      <h2 class="section-title">Nos Services</h2>
      <div class="cards">
        <?php if (!empty($modules)): ?>
          <?php foreach ($modules as $module): ?>
            <article class="card">
              <div class="card-illustration">
                <?php if (!empty($module['logo_path']) && file_exists($module['logo_path'])): ?>
                  <img src="<?php echo htmlspecialchars($module['logo_path']); ?>" alt="<?php echo htmlspecialchars($module['name']); ?>" />
                <?php else: ?>
                  <img src="Images/Logo Diocese.png" alt="<?php echo htmlspecialchars($module['name']); ?>" />
                <?php endif; ?>
              </div>
              <h3><?php echo htmlspecialchars($module['name']); ?></h3>
              <?php if (!empty($module['description'])): ?>
              <p><?php echo htmlspecialchars($module['description']); ?></p>
              <?php endif; ?>
              <a class="btn btn-card" href="app/views/modules/index.php?id=<?php echo (int)$module['id']; ?>">En savoir plus</a>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align:center">Aucun service disponible pour le moment.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Modal Paiement: Parle Seigneur -->
  <div class="modal" id="payment-modal" aria-hidden="true" role="dialog" aria-labelledby="payment-title">
    <div class="modal-backdrop" data-close></div>
    <div class="modal-dialog">
      <button class="modal-close" aria-label="Fermer" data-close>✕</button>
      <h3 id="payment-title">Parle Seigneur — Paiement</h3>
      <p>Choisissez votre moyen de paiement pour obtenir le document.</p>
      <form id="payment-form">
        <div class="payment-options">
          <label class="option"><input type="radio" name="method" value="OM" required /> Orange Money (OM)</label>
          <label class="option"><input type="radio" name="method" value="MoMo" /> Mobile Money (MoMo)</label>
        </div>
        <div class="field-inline">
          <label for="phone">Numéro de téléphone</label>
          <input type="tel" id="phone" name="phone" placeholder="Ex: 6XX XXX XXX" required />
        </div>
        <button class="btn" type="submit">Payer</button>
      </form>
      <small class="help">Le traitement de paiement nécessite une intégration serveur ultérieure. Cette démo valide uniquement le choix.</small>
    </div>
  </div>

  

  <!-- Blog / Actus -->
  <section class="blog" id="blog">
    <div class="container">
      <h2 class="section-title">Actualités</h2>
      <div class="posts">
        <article class="post">
          <h3>Nouvelle grille des programmes RVE</h3>
          <p>Découvrez nos émissions phares et nos rendez‑vous spirituels quotidiens.</p>
          <a class="link" href="#">Lire l'article</a>
        </article>
        <article class="post">
          <h3>Ouverture du service de commandes en ligne</h3>
          <p>Imprimez vos supports en quelques clics avec un accompagnement professionnel.</p>
          <a class="link" href="#">Lire l'article</a>
        </article>
        <article class="post">
          <h3>Atelier communication pour paroisses</h3>
          <p>Formez vos équipes à la narration et à la création de contenus inspirants.</p>
          <a class="link" href="#">Lire l'article</a>
        </article>
      </div>
    </div>
  </section>

  <!-- Bande CTA -->
  <section class="cta">
    <div class="container cta-inner">
      <h2>Prêt à collaborer ?</h2>
      <p>Contactez‑nous pour vos projets médias, impression et communication.</p>
      <a class="btn btn-light" href="#contact">Nous contacter</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer" id="contact">
    <div class="container footer-grid">
      <div>
        <h4>MCC</h4>
        <p>Maison Catholique de la Communication – Douala, Cameroun</p>
        <p>Tel: (+237) 676 698 675 / 698 423 919</p>
        <p>Email: contact@mcc-rve.cm</p>
      </div>
      <div>
        <h4>Accès</h4>
        <ul class="footer-links">
          <li><a href="#modules">Nos modules</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="#blog">Actualités</a></li>
        </ul>
      </div>
      <div>
        <h4>Administration</h4>
        <a class="btn btn-outline" href="app/views/Auth/login.php">Se connecter</a>
        <a class="btn" style="margin-left:8px;margin-top:8px" href="app/views/Auth/register.php">S'inscrire</a>
        <div class="footer-socials">
          <a class="social" href="#" aria-label="YouTube" title="YouTube">▶</a>
          <a class="social" href="#" aria-label="Facebook" title="Facebook">f</a>
          <a class="social" href="#" aria-label="Google" title="Google">G</a>
        </div>
      </div>
    </div>
    <div class="container copyrights">
      <p>© <span id="year"></span> MCC – Tous droits réservés.</p>
    </div>
  </footer>

  <script>
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.main-nav');
    toggle.addEventListener('click', () => {
      nav.classList.toggle('open');
    });
    document.getElementById('year').textContent = new Date().getFullYear();

    // Paiement modal
    const openPayment = document.getElementById('open-payment');
    const paymentModal = document.getElementById('payment-modal');
    const closeEls = paymentModal.querySelectorAll('[data-close]');
    openPayment.addEventListener('click', (e) => { e.preventDefault(); paymentModal.classList.add('open'); paymentModal.setAttribute('aria-hidden','false'); });
    closeEls.forEach(el => el.addEventListener('click', () => { paymentModal.classList.remove('open'); paymentModal.setAttribute('aria-hidden','true'); }));
    paymentModal.addEventListener('click', (e) => { if (e.target === paymentModal) { paymentModal.classList.remove('open'); paymentModal.setAttribute('aria-hidden','true'); } });
    document.getElementById('payment-form').addEventListener('submit', (e) => {
      e.preventDefault();
      const method = (new FormData(e.target)).get('method');
      const phone = (new FormData(e.target)).get('phone');
      alert(`Commande enregistrée. Méthode: ${method} — Téléphone: ${phone}. L'intégration de paiement sera ajoutée ultérieurement.`);
      paymentModal.classList.remove('open');
      paymentModal.setAttribute('aria-hidden','true');
      e.target.reset();
    });
  </script>
</body>
</html>
