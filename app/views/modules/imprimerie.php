<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Imprimerie - MCC</title>
  <link rel="stylesheet" href="../../../public/assets/css/styles.css" />
  <link rel="stylesheet" href="../../../public/assets/css/imprimerie.css" />
</head>
<body>
  <!-- Header principal -->
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="../../../index.php">
        <img src="../../../assets/logo-rve.svg" alt="Logo MCC - RVE" onerror="this.style.display='none'" />
        <img src="../../../Images/Logo MCC.png" alt="Logo MCC" style="height:32px;margin:0 10px" />
        <span>Maison Catholique de la Communication</span>
      </a>
      <nav class="main-nav" aria-label="Navigation principale">
        <a href="../../../index.php#agence">L'Agence</a>
        <a href="../../../index.php#modules">Expertises</a>
        <a href="../../../index.php#blog">Blog</a>
        <a href="../../../index.php#contact">Contact</a>
        <a class="btn btn-outline" href="../Auth/login.php">Se connecter</a>
        <a class="btn" href="../Auth/register.php">S'inscrire</a>
      </nav>
      <button class="nav-toggle" aria-label="Ouvrir le menu">☰</button>
    </div>
  </header>

  <!-- Hero Section Imprimerie -->
  <section class="imprimerie-hero">
    <div class="overlay"></div>
    <div class="container hero-content">
      <div class="imprimerie-logo">
        <img src="../../../Images/Logo Imprimerie.png" alt="Logo Imprimerie MCC" />
      </div>
      <h1>Service d'Imprimerie</h1>
      <p>L'art de l'impression au service de la communication chrétienne</p>
      <div class="quality-indicator">
        <span class="quality-star">⭐</span>
        <span>QUALITÉ PROFESSIONNELLE</span>
      </div>
    </div>
  </section>

  <!-- Navigation des sections Imprimerie -->
  <nav class="imprimerie-nav">
    <div class="container">
      <ul>
        <li><a href="#presentation" class="nav-link active">Présentation</a></li>
        <li><a href="#publications" class="nav-link">Publications</a></li>
        <li><a href="#personnel" class="nav-link">Notre Équipe</a></li>
      </ul>
    </div>
  </nav>

  <!-- Section Présentation -->
  <section id="presentation" class="imprimerie-section presentation-section">
    <div class="container">
      <h2>Présentation de notre Imprimerie</h2>
      <div class="presentation-content">
        <div class="presentation-text">
          <div class="presentation-block">
            <h3>Notre Rôle</h3>
            <p>L'imprimerie de la Maison Catholique de la Communication est le centre de production graphique du diocèse. Nous assurons la création et l'impression de tous les supports de communication nécessaires à la mission pastorale et à la vie institutionnelle de l'Église.</p>
            <p>Depuis plus de 15 ans, nous accompagnons les paroisses, mouvements et institutions catholiques dans leurs besoins d'impression, en garantissant qualité, respect des délais et prix compétitifs.</p>
          </div>
          
          <div class="presentation-block">
            <h3>Nos Services</h3>
            <div class="services-grid">
              <div class="service-item">
                <div class="service-icon">📚</div>
                <h4>Livres & Brochures</h4>
                <p>Éditions religieuses, guides pastoraux, manuels de formation</p>
              </div>
              <div class="service-item">
                <div class="service-icon">🖼️</div>
                <h4>Affiches & Posters</h4>
                <p>Communication événementielle, affichage paroissial, campagnes</p>
              </div>
              <div class="service-item">
                <div class="service-icon">📋</div>
                <h4>Cartes & Flyers</4>
                <p>Cartes de vœux, invitations, supports d'évangélisation</p>
              </div>
              <div class="service-item">
                <div class="service-icon">🏷️</div>
                <h4>Étiquettes & Packaging</h4>
                <p>Identification des produits, emballages promotionnels</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="presentation-media">
          <div class="equipment-showcase">
            <h3>Nos Équipements</h3>
            <div class="equipment-grid">
              <div class="equipment-item">
                <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=300" alt="Presse offset" />
                <h4>Presse Offset</h4>
                <p>Qualité professionnelle pour les tirages moyens et importants</p>
              </div>
              <div class="equipment-item">
                <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=300" alt="Imprimante numérique" />
                <h4>Imprimante Numérique</h4>
                <p>Impression rapide et personnalisée pour les petits tirages</p>
              </div>
              <div class="equipment-item">
                <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=300" alt="Finitions" />
                <h4>Finitions</h4>
                <p>Reliure, laminage, perforation et autres finitions</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Publications -->
  <section id="publications" class="imprimerie-section publications-section">
    <div class="container">
      <h2>Nos Publications</h2>
      <div class="publications-content">
        <div class="catalog-intro">
          <p>Découvrez un aperçu de nos réalisations dans différents domaines de l'impression. Chaque projet est conçu avec soin pour répondre aux besoins spécifiques de nos clients.</p>
        </div>
        
        <div class="publications-grid">
          <article class="publication-card">
            <div class="publication-image">
              <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400" alt="Livre religieux" />
              <div class="publication-overlay">
                <span class="publication-type">Livre</span>
              </div>
            </div>
            <div class="publication-content">
              <h3>"Parle Seigneur" - Guide de prière</h3>
              <p>Guide spirituel quotidien avec méditations et prières pour chaque jour de l'année</p>
              <div class="publication-meta">
                <span class="format">Format A5</span>
                <span class="pages">365 pages</span>
                <span class="binding">Reliure cousue</span>
              </div>
              <div class="publication-actions">
                <button class="btn btn-outline">Voir détails</button>
                <button class="btn">Commander</button>
              </div>
            </div>
          </article>

          <article class="publication-card">
            <div class="publication-image">
              <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400" alt="Affiche paroissiale" />
              <div class="publication-overlay">
                <span class="publication-type">Affiche</span>
              </div>
            </div>
            <div class="publication-content">
              <h3>Affiches paroissiales</h3>
              <p>Supports de communication pour les événements paroissiaux et diocésains</p>
              <div class="publication-meta">
                <span class="format">Format A2</span>
                <span class="paper">Papier couché</span>
                <span class="finish">Laminage brillant</span>
              </div>
              <div class="publication-actions">
                <button class="btn btn-outline">Voir détails</button>
                <button class="btn">Commander</button>
              </div>
            </div>
          </article>

          <article class="publication-card">
            <div class="publication-image">
              <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400" alt="Brochure" />
              <div class="publication-overlay">
                <span class="publication-type">Brochure</span>
              </div>
            </div>
            <div class="publication-content">
              <h3>Brochures d'évangélisation</h3>
              <p>Supports d'information et de formation pour les équipes pastorales</p>
              <div class="publication-meta">
                <span class="format">Format A4</span>
                <span class="pages">16 pages</span>
                <span class="binding">Agrafeuse</span>
              </div>
              <div class="publication-actions">
                <button class="btn btn-outline">Voir détails</button>
                <button class="btn">Commander</button>
              </div>
            </div>
          </article>

          <article class="publication-card">
            <div class="publication-image">
              <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400" alt="Cartes" />
              <div class="publication-overlay">
                <span class="publication-type">Cartes</span>
              </div>
            </div>
            <div class="publication-content">
              <h3>Cartes de vœux diocésaines</h3>
              <p>Cartes personnalisées pour les fêtes et occasions spéciales</p>
              <div class="publication-meta">
                <span class="format">Format 10x15cm</span>
                <span class="paper">Papier cartonné</span>
                <span class="finish">Impression recto-verso</span>
              </div>
              <div class="publication-actions">
                <button class="btn btn-outline">Voir détails</button>
                <button class="btn">Commander</button>
              </div>
            </div>
          </article>
        </div>

        <div class="special-offer">
          <div class="offer-content">
            <h3>Offre Spéciale : "Parle Seigneur"</h3>
            <p>Notre publication phare est disponible en version payante. Un guide spirituel complet pour accompagner votre vie de prière quotidienne.</p>
            <div class="offer-features">
              <span>✅ 365 méditations</span>
              <span>✅ Prières quotidiennes</span>
              <span>✅ Format pratique</span>
              <span>✅ Qualité premium</span>
            </div>
            <button class="btn btn-special" id="open-printing-payment">Commander maintenant</button>
          </div>
          <div class="offer-image">
            <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300" alt="Parle Seigneur" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Personnel -->
  <section id="personnel" class="imprimerie-section personnel-section">
    <div class="container">
      <h2>Notre Équipe</h2>
      <div class="personnel-content">
        <div class="personnel-intro">
          <p>Une équipe expérimentée et passionnée par l'art de l'impression, dédiée à la qualité et au service client.</p>
        </div>
        
        <div class="personnel-grid">
          <div class="personnel-card">
            <div class="personnel-photo">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300" alt="Pierre Dubois" />
            </div>
            <div class="personnel-info">
              <h3>Pierre Dubois</h3>
              <p class="role">Directeur technique</p>
              <p class="description">Expert en impression offset avec plus de 20 ans d'expérience. Spécialiste en gestion de la qualité et optimisation des processus d'impression.</p>
              <div class="personnel-specialties">
                <span class="specialty-tag">Offset</span>
                <span class="specialty-tag">Qualité</span>
                <span class="specialty-tag">Processus</span>
              </div>
            </div>
          </div>

          <div class="personnel-card">
            <div class="personnel-photo">
              <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300" alt="Marie Laurent" />
            </div>
            <div class="personnel-info">
              <h3>Marie Laurent</h3>
              <p class="role">Graphiste & Maquettiste</p>
              <p class="description">Créatrice talentueuse spécialisée dans la conception de supports religieux. Elle donne vie aux projets avec créativité et respect des valeurs chrétiennes.</p>
              <div class="personnel-specialties">
                <span class="specialty-tag">Design</span>
                <span class="specialty-tag">Maquette</span>
                <span class="specialty-tag">Créativité</span>
              </div>
            </div>
          </div>

          <div class="personnel-card">
            <div class="personnel-photo">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300" alt="Jean Moreau" />
            </div>
            <div class="personnel-info">
              <h3>Jean Moreau</h3>
              <p class="role">Opérateur impression numérique</p>
              <p class="description">Technicien spécialisé dans l'impression numérique et les finitions. Assure la qualité et la rapidité des petits tirages et impressions personnalisées.</p>
              <div class="personnel-specialties">
                <span class="specialty-tag">Numérique</span>
                <span class="specialty-tag">Finitions</span>
                <span class="specialty-tag">Technique</span>
              </div>
            </div>
          </div>

          <div class="personnel-card">
            <div class="personnel-photo">
              <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300" alt="Sophie Martin" />
            </div>
            <div class="personnel-info">
              <h3>Sophie Martin</h3>
              <p class="role">Responsable commerciale</p>
              <p class="description">Accompagne les clients dans leurs projets d'impression, du devis à la livraison. Garantit la satisfaction client et le respect des délais.</p>
              <div class="personnel-specialties">
                <span class="specialty-tag">Commercial</span>
                <span class="specialty-tag">Service client</span>
                <span class="specialty-tag">Suivi projet</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Paiement: Parle Seigneur -->
  <div class="modal" id="printing-payment-modal" aria-hidden="true" role="dialog" aria-labelledby="printing-payment-title">
    <div class="modal-backdrop" data-close></div>
    <div class="modal-dialog">
      <button class="modal-close" aria-label="Fermer" data-close>✕</button>
      <h3 id="printing-payment-title">Parle Seigneur — Commande</h3>
      <p>Commandez votre exemplaire du guide spirituel "Parle Seigneur"</p>
      <form id="printing-payment-form">
        <div class="field-inline">
          <label for="printing-name">Nom complet</label>
          <input type="text" id="printing-name" name="name" placeholder="Votre nom" required />
        </div>
        <div class="field-inline">
          <label for="printing-phone">Téléphone</label>
          <input type="tel" id="printing-phone" name="phone" placeholder="Ex: 6XX XXX XXX" required />
        </div>
        <div class="field-inline">
          <label for="printing-address">Adresse de livraison</label>
          <textarea id="printing-address" name="address" placeholder="Votre adresse complète" required></textarea>
        </div>
        <div class="payment-options">
          <label class="option"><input type="radio" name="method" value="OM" required /> Orange Money (OM)</label>
          <label class="option"><input type="radio" name="method" value="MoMo" /> Mobile Money (MoMo)</label>
        </div>
        <div class="order-summary">
          <h4>Récapitulatif de commande</h4>
          <p><strong>Produit :</strong> Guide "Parle Seigneur"</p>
          <p><strong>Prix :</strong> 5 000 FCFA</p>
          <p><strong>Livraison :</strong> Gratuite dans Douala</p>
        </div>
        <button class="btn" type="submit">Confirmer la commande</button>
      </form>
      <small class="help">Le traitement de paiement nécessite une intégration serveur ultérieure. Cette démo valide uniquement le formulaire.</small>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container footer-grid">
      <div>
        <h4>Imprimerie MCC</h4>
        <p>L'art de l'impression au service de la communication chrétienne</p>
        <p>Fondée en 2008 par le diocèse de Douala</p>
      </div>
      <div>
        <h4>Navigation</h4>
        <ul class="footer-links">
          <li><a href="#presentation">Présentation</a></li>
          <li><a href="#publications">Publications</a></li>
          <li><a href="#personnel">Notre équipe</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact Imprimerie</h4>
        <p>Atelier d'impression - Diocèse de Douala</p>
        <p>Email: imprimerie@mcc-rve.cm</p>
        <a class="btn btn-outline" href="../Auth/login.php">Accès administration</a>
      </div>
    </div>
    <div class="container copyrights">
      <p>© <span id="year"></span> Imprimerie MCC – Tous droits réservés.</p>
    </div>
  </footer>

  <script>
    // Navigation des sections
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.imprimerie-section');

    navLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href').substring(1);
        
        // Mise à jour de la navigation active
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        
        // Scroll vers la section
        document.getElementById(targetId).scrollIntoView({ behavior: 'smooth' });
      });
    });

    // Modal de commande
    const openPrintingPayment = document.getElementById('open-printing-payment');
    const printingPaymentModal = document.getElementById('printing-payment-modal');
    const closeEls = printingPaymentModal.querySelectorAll('[data-close]');
    
    openPrintingPayment.addEventListener('click', (e) => { 
      e.preventDefault(); 
      printingPaymentModal.classList.add('open'); 
      printingPaymentModal.setAttribute('aria-hidden','false'); 
    });
    
    closeEls.forEach(el => el.addEventListener('click', () => { 
      printingPaymentModal.classList.remove('open'); 
      printingPaymentModal.setAttribute('aria-hidden','true'); 
    }));
    
    printingPaymentModal.addEventListener('click', (e) => { 
      if (e.target === printingPaymentModal) { 
        printingPaymentModal.classList.remove('open'); 
        printingPaymentModal.setAttribute('aria-hidden','true'); 
      } 
    });
    
    document.getElementById('printing-payment-form').addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const name = formData.get('name');
      const phone = formData.get('phone');
      const method = formData.get('method');
      
      alert(`Commande enregistrée pour ${name}.\nTéléphone: ${phone}\nMéthode de paiement: ${method}\n\nL'intégration de paiement sera ajoutée ultérieurement.`);
      printingPaymentModal.classList.remove('open');
      printingPaymentModal.setAttribute('aria-hidden','true');
      e.target.reset();
    });

    // Année dans le footer
    document.getElementById('year').textContent = new Date().getFullYear();

    // Toggle navigation mobile
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.main-nav');
    toggle.addEventListener('click', () => {
      nav.classList.toggle('open');
    });
  </script>
</body>
</html>
