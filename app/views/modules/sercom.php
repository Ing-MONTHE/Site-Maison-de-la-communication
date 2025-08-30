<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SerCom - MCC</title>
  <link rel="stylesheet" href="../../../public/assets/css/styles.css" />
  <link rel="stylesheet" href="../../../public/assets/css/sercom.css" />
</head>
<body>
  <!-- Header principal -->
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="../../../index.php">
        <img src="../../../assets/logo-rve.svg" alt="Logo MCC - RVE" onerror="this.style.display='none'" />
        <img src="../../../Images/Logo Diocese.png" alt="Logo du diocèse" style="height:32px;margin:0 10px" />
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

  <!-- Hero Section SerCom -->
  <section class="sercom-hero">
    <div class="overlay"></div>
    <div class="container hero-content">
      <div class="sercom-logo">
        <img src="../../../Images/Logo SerCom.png" alt="Logo SerCom MCC" />
      </div>
      <h1>Service Communication</h1>
      <p>L'expertise digitale au service de la mission évangélisatrice</p>
      <div class="expertise-indicator">
        <span class="expertise-icon">🚀</span>
        <span>EXPERTISE DIGITALE</span>
      </div>
    </div>
  </section>

  <!-- Navigation des sections SerCom -->
  <nav class="sercom-nav">
    <div class="container">
      <ul>
        <li><a href="#galerie-video" class="nav-link active">Galerie Vidéo</a></li>
        <li><a href="#galerie-photo" class="nav-link">Galerie Photo</a></li>
        <li><a href="#sono" class="nav-link">Sonorisation</a></li>
      </ul>
    </div>
  </nav>

  <!-- Section Galerie Vidéo -->
  <section id="galerie-video" class="sercom-section galerie-video-section">
    <div class="container">
      <h2>Galerie Vidéo</h2>
      <div class="galerie-video-content">
        <div class="galerie-intro">
          <p>Découvrez nos productions audiovisuelles qui témoignent de la foi et de la vie de l'Église. Reportages, interviews et spots promotionnels pour une communication chrétienne moderne et impactante.</p>
        </div>
        
        <div class="galerie-header">
          <h3>Nos Productions Vidéo</h3>
          <div class="scroll-controls">
            <button class="scroll-btn scroll-prev" id="video-prev" aria-label="Précédent">‹</button>
            <button class="scroll-btn scroll-next" id="video-next" aria-label="Suivant">›</button>
          </div>
        </div>
        
        <div class="galerie-container">
          <div class="video-grid" id="video-grid">
            <article class="video-card">
              <div class="video-thumbnail">
                <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=400" alt="Reportage paroissial" />
                <div class="video-overlay">
                  <button class="play-video">▶</button>
                  <span class="video-duration">12:45</span>
                </div>
              </div>
              <div class="video-content">
                <h3>Reportage : Vie paroissiale à Douala</h3>
                <p>Découvrez la vitalité de nos paroisses et l'engagement des fidèles dans la mission évangélisatrice</p>
                <div class="video-meta">
                  <span class="category">Reportage</span>
                  <span class="date">Mars 2024</span>
                  <span class="views">2.5K vues</span>
                </div>
                <div class="video-actions">
                  <button class="btn btn-outline">Regarder</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="video-card">
              <div class="video-thumbnail">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Interview évêque" />
                <div class="video-overlay">
                  <button class="play-video">▶</button>
                  <span class="video-duration">18:32</span>
                </div>
              </div>
              <div class="video-content">
                <h3>Interview : Mgr Samuel Kleda</h3>
                <p>L'évêque de Douala partage sa vision pour l'évangélisation à l'ère numérique</p>
                <div class="video-meta">
                  <span class="category">Interview</span>
                  <span class="date">Février 2024</span>
                  <span class="views">4.1K vues</span>
                </div>
                <div class="video-actions">
                  <button class="btn btn-outline">Regarder</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="video-card">
              <div class="video-thumbnail">
                <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400" alt="Spot promotionnel" />
                <div class="video-overlay">
                  <button class="play-video">▶</button>
                  <span class="video-duration">00:45</span>
                </div>
              </div>
              <div class="video-content">
                <h3>Spot : "Priez avec nous"</h3>
                <p>Campagne de promotion pour encourager la prière en famille et en communauté</p>
                <div class="video-meta">
                  <span class="category">Spot</span>
                  <span class="date">Janvier 2024</span>
                  <span class="views">8.7K vues</span>
                </div>
                <div class="video-actions">
                  <button class="btn btn-outline">Regarder</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="video-card">
              <div class="video-thumbnail">
                <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400" alt="Documentaire mission" />
                <div class="video-overlay">
                  <button class="play-video">▶</button>
                  <span class="video-duration">25:18</span>
                </div>
              </div>
              <div class="video-content">
                <h3>Documentaire : Mission en zone rurale</h3>
                <p>Le témoignage des missionnaires qui portent la Bonne Nouvelle dans les villages</p>
                <div class="video-meta">
                  <span class="category">Documentaire</span>
                  <span class="date">Décembre 2023</span>
                  <span class="views">3.2K vues</span>
                </div>
                <div class="video-actions">
                  <button class="btn btn-outline">Regarder</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="video-card">
              <div class="video-thumbnail">
                <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=400" alt="Formation catéchèse" />
                <div class="video-overlay">
                  <button class="play-video">▶</button>
                  <span class="video-duration">32:15</span>
                </div>
              </div>
              <div class="video-content">
                <h3>Formation : Catéchèse pour enfants</h3>
                <p>Méthodes et outils pour transmettre la foi aux plus jeunes de manière adaptée</p>
                <div class="video-meta">
                  <span class="category">Formation</span>
                  <span class="date">Novembre 2023</span>
                  <span class="views">1.8K vues</span>
                </div>
                <div class="video-actions">
                  <button class="btn btn-outline">Regarder</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="video-card">
              <div class="video-thumbnail">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Événement diocésain" />
                <div class="video-overlay">
                  <button class="play-video">▶</button>
                  <span class="video-duration">15:42</span>
                </div>
              </div>
              <div class="video-content">
                <h3>Événement : Journée diocésaine 2023</h3>
                <p>Retour en images sur la grande célébration qui a rassemblé tout le diocèse</p>
                <div class="video-meta">
                  <span class="category">Événement</span>
                  <span class="date">Octobre 2023</span>
                  <span class="views">5.6K vues</span>
                </div>
                <div class="video-actions">
                  <button class="btn btn-outline">Regarder</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Galerie Photo -->
  <section id="galerie-photo" class="sercom-section galerie-photo-section">
    <div class="container">
      <h2>Galerie Photo</h2>
      <div class="galerie-photo-content">
        <div class="galerie-intro">
          <p>Explorez nos albums photos organisés par événements et campagnes. Chaque image raconte une histoire de foi, de communauté et de mission évangélisatrice.</p>
        </div>
        
        <div class="galerie-header">
          <h3>Albums Photos</h3>
          <div class="scroll-controls">
            <button class="scroll-btn scroll-prev" id="photo-prev" aria-label="Précédent">‹</button>
            <button class="scroll-btn scroll-next" id="photo-next" aria-label="Suivant">›</button>
          </div>
        </div>
        
        <div class="galerie-container">
          <div class="album-grid" id="album-grid">
            <article class="album-card">
              <div class="album-cover">
                <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=400" alt="Ordinations sacerdotales" />
                <div class="album-overlay">
                  <span class="photo-count">24 photos</span>
                </div>
              </div>
              <div class="album-content">
                <h3>Ordinations Sacerdotales 2024</h3>
                <p>Journée historique de l'ordination de 5 nouveaux prêtres pour le diocèse</p>
                <div class="album-meta">
                  <span class="event">Cérémonie</span>
                  <span class="date">15 Mars 2024</span>
                  <span class="location">Cathédrale</span>
                </div>
                <div class="album-actions">
                  <button class="btn btn-outline">Voir l'album</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="album-card">
              <div class="album-cover">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Campagne carême" />
                <div class="album-overlay">
                  <span class="photo-count">18 photos</span>
                </div>
              </div>
              <div class="album-content">
                <h3>Campagne de Carême 2024</h3>
                <p>Actions de solidarité et de partage pendant la période de Carême</p>
                <div class="album-meta">
                  <span class="event">Campagne</span>
                  <span class="date">Février-Mars 2024</span>
                  <span class="location">Diocèse</span>
                </div>
                <div class="album-actions">
                  <button class="btn btn-outline">Voir l'album</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="album-card">
              <div class="album-cover">
                <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400" alt="Formation jeunes" />
                <div class="album-overlay">
                  <span class="photo-count">31 photos</span>
                </div>
              </div>
              <div class="album-content">
                <h3>Formation des Jeunes Leaders</h3>
                <p>Session de formation pour les jeunes engagés dans la mission paroissiale</p>
                <div class="album-meta">
                  <span class="event">Formation</span>
                  <span class="date">Janvier 2024</span>
                  <span class="location">Centre pastoral</span>
                </div>
                <div class="album-actions">
                  <button class="btn btn-outline">Voir l'album</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="album-card">
              <div class="album-cover">
                <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400" alt="Pèlerinage" />
                <div class="album-overlay">
                  <span class="photo-count">42 photos</span>
                </div>
              </div>
              <div class="album-content">
                <h3>Pèlerinage Diocésain</h3>
                <p>Marche de foi vers le sanctuaire marial de Marienberg</p>
                <div class="album-meta">
                  <span class="event">Pèlerinage</span>
                  <span class="date">Décembre 2023</span>
                  <span class="location">Marienberg</span>
                </div>
                <div class="album-actions">
                  <button class="btn btn-outline">Voir l'album</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="album-card">
              <div class="album-cover">
                <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=400" alt="Construction église" />
                <div class="album-overlay">
                  <span class="photo-count">28 photos</span>
                </div>
              </div>
              <div class="album-content">
                <h3>Construction Église Sainte-Marie</h3>
                <p>Suivi des travaux de construction de la nouvelle église paroissiale</p>
                <div class="album-meta">
                  <span class="event">Construction</span>
                  <span class="date">2023-2024</span>
                  <span class="location">Paroisse Sainte-Marie</span>
                </div>
                <div class="album-actions">
                  <button class="btn btn-outline">Voir l'album</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>

            <article class="album-card">
              <div class="album-cover">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Action sociale" />
                <div class="album-overlay">
                  <span class="photo-count">19 photos</span>
                </div>
              </div>
              <div class="album-content">
                <h3>Action Sociale : Distribution de vivres</h3>
                <p>Opération de solidarité en faveur des familles démunies</p>
                <div class="album-meta">
                  <span class="event">Action sociale</span>
                  <span class="date">Novembre 2023</span>
                  <span class="location">Quartiers populaires</span>
                </div>
                <div class="album-actions">
                  <button class="btn btn-outline">Voir l'album</button>
                  <button class="btn">Télécharger</button>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Sono -->
  <section id="sono" class="sercom-section sono-section">
    <div class="container">
      <h2>Sonorisation</h2>
      <div class="sono-content">
        <div class="sono-intro">
          <p>Équipements professionnels de sonorisation pour tous vos événements. Location, installation et assistance technique pour des prestations audio de qualité.</p>
        </div>
        
        <div class="sono-header">
          <h3>Matériel de Sonorisation</h3>
          <div class="scroll-controls">
            <button class="scroll-btn scroll-prev" id="sono-prev" aria-label="Précédent">‹</button>
            <button class="scroll-btn scroll-next" id="sono-next" aria-label="Suivant">›</button>
          </div>
        </div>
        
        <div class="sono-container">
          <div class="equipment-grid" id="equipment-grid">
            <div class="equipment-card">
              <div class="equipment-image">
                <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=400" alt="Système de sonorisation" />
              </div>
              <div class="equipment-content">
                <h3>Système de Sonorisation Principal</h3>
                <p>Installation complète pour églises et salles de grande capacité (jusqu'à 500 personnes)</p>
                <div class="equipment-specs">
                  <span class="spec">Puissance: 2000W</span>
                  <span class="spec">Couverture: 500m²</span>
                  <span class="spec">Entrées: 8</span>
                </div>
                <div class="equipment-services">
                  <span class="service-tag">Location</span>
                  <span class="service-tag">Installation</span>
                  <span class="service-tag">Assistance</span>
                </div>
                <div class="equipment-actions">
                  <button class="btn btn-outline">Demander devis</button>
                  <button class="btn">Réserver</button>
                </div>
              </div>
            </div>

            <div class="equipment-card">
              <div class="equipment-image">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Microphones" />
              </div>
              <div class="equipment-content">
                <h3>Microphones Professionnels</h3>
                <p>Gamme complète de microphones pour prédication, chant et instruments</p>
                <div class="equipment-specs">
                  <span class="spec">Types: 6 modèles</span>
                  <span class="spec">Connectique: XLR/Jack</span>
                  <span class="spec">Polarité: Cardioïde</span>
                </div>
                <div class="equipment-services">
                  <span class="service-tag">Location</span>
                  <span class="service-tag">Installation</span>
                  <span class="service-tag">Assistance</span>
                </div>
                <div class="equipment-actions">
                  <button class="btn btn-outline">Demander devis</button>
                  <button class="btn">Réserver</button>
                </div>
              </div>
            </div>

            <div class="equipment-card">
              <div class="equipment-image">
                <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400" alt="Table de mixage" />
              </div>
              <div class="equipment-content">
                <h3>Table de Mixage Numérique</h3>
                <p>Console professionnelle 16 canaux avec effets intégrés et enregistrement</p>
                <div class="equipment-specs">
                  <span class="spec">Canaux: 16</span>
                  <span class="spec">Effets: 8</span>
                  <span class="spec">USB: Oui</span>
                </div>
                <div class="equipment-services">
                  <span class="service-tag">Location</span>
                  <span class="service-tag">Installation</span>
                  <span class="service-tag">Assistance</span>
                </div>
                <div class="equipment-actions">
                  <button class="btn btn-outline">Demander devis</button>
                  <button class="btn">Réserver</button>
                </div>
              </div>
            </div>

            <div class="equipment-card">
              <div class="equipment-image">
                <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400" alt="Enceintes" />
              </div>
              <div class="equipment-content">
                <h3>Enceintes de Diffusion</h3>
                <p>Enceintes actives et passives pour tous types d'événements</p>
                <div class="equipment-specs">
                  <span class="spec">Puissance: 100W-500W</span>
                  <span class="spec">Fréquence: 50Hz-20kHz</span>
                  <span class="spec">Impedance: 8Ω</span>
                </div>
                <div class="equipment-services">
                  <span class="service-tag">Location</span>
                  <span class="service-tag">Installation</span>
                  <span class="service-tag">Assistance</span>
                </div>
                <div class="equipment-actions">
                  <button class="btn btn-outline">Demander devis</button>
                  <button class="btn">Réserver</button>
                </div>
              </div>
            </div>

            <div class="equipment-card">
              <div class="equipment-image">
                <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=400" alt="Système portable" />
              </div>
              <div class="equipment-content">
                <h3>Système Portable</h3>
                <p>Solution complète et transportable pour événements extérieurs</p>
                <div class="equipment-specs">
                  <span class="spec">Puissance: 500W</span>
                  <span class="spec">Batterie: 8h</span>
                  <span class="spec">Poids: 15kg</span>
                </div>
                <div class="equipment-services">
                  <span class="service-tag">Location</span>
                  <span class="service-tag">Installation</span>
                  <span class="service-tag">Assistance</span>
                </div>
                <div class="equipment-actions">
                  <button class="btn btn-outline">Demander devis</button>
                  <button class="btn">Réserver</button>
                </div>
              </div>
            </div>

            <div class="equipment-card">
              <div class="equipment-image">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Accessoires" />
              </div>
              <div class="equipment-content">
                <h3>Accessoires & Câblage</h3>
                <p>Câbles, connecteurs, pieds de micro et supports pour installation complète</p>
                <div class="equipment-specs">
                  <span class="spec">Câbles: 50m</span>
                  <span class="spec">Connecteurs: 20</span>
                  <span class="spec">Pieds: 8</span>
                </div>
                <div class="equipment-services">
                  <span class="service-tag">Location</span>
                  <span class="service-tag">Installation</span>
                  <span class="service-tag">Assistance</span>
                </div>
                <div class="equipment-actions">
                  <button class="btn btn-outline">Demander devis</button>
                  <button class="btn">Réserver</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="services-overview">
          <h3>Nos Services</h3>
          <div class="services-grid">
            <div class="service-item">
              <div class="service-icon">🎯</div>
              <h4>Location</h4>
              <p>Location d'équipements professionnels pour tous types d'événements</p>
              <ul class="service-features">
                <li>Tarifs journaliers et hebdomadaires</li>
                <li>Assurance incluse</li>
                <li>Livraison possible</li>
              </ul>
            </div>
            <div class="service-item">
              <div class="service-icon">🔧</div>
              <h4>Installation</h4>
              <p>Installation et configuration complète de votre système de sonorisation</p>
              <ul class="service-features">
                <li>Installation sur site</li>
                <li>Configuration optimale</li>
                <li>Tests et réglages</li>
              </ul>
            </div>
            <div class="service-item">
              <div class="service-icon">🎧</div>
              <h4>Assistance Technique</h4>
              <p>Support technique pendant vos événements et formation du personnel</p>
              <ul class="service-features">
                <li>Technicien sur place</li>
                <li>Formation utilisateurs</li>
                <li>Maintenance préventive</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container footer-grid">
      <div>
        <h4>SerCom - Service Communication</h4>
        <p>L'expertise digitale au service de la mission évangélisatrice</p>
        <p>Fondé en 2012 par le diocèse de Douala</p>
      </div>
      <div>
        <h4>Navigation</h4>
        <ul class="footer-links">
          <li><a href="#galerie-video">Galerie Vidéo</a></li>
          <li><a href="#galerie-photo">Galerie Photo</a></li>
          <li><a href="#sono">Sonorisation</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact SerCom</h4>
        <p>Service Communication - Diocèse de Douala</p>
        <p>Email: sercom@mcc-rve.cm</p>
        <a class="btn btn-outline" href="../Auth/login.php">Accès administration</a>
      </div>
    </div>
    <div class="container copyrights">
      <p>© <span id="year"></span> SerCom MCC – Tous droits réservés.</p>
    </div>
  </footer>

  <script>
    // Navigation des sections
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.sercom-section');

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

    // Défilement horizontal pour la galerie vidéo
    const videoGrid = document.getElementById('video-grid');
    const videoPrev = document.getElementById('video-prev');
    const videoNext = document.getElementById('video-next');
    let videoScrollPosition = 0;

    videoPrev.addEventListener('click', () => {
      videoScrollPosition = Math.max(videoScrollPosition - 400, 0);
      videoGrid.scrollTo({
        left: videoScrollPosition,
        behavior: 'smooth'
      });
    });

    videoNext.addEventListener('click', () => {
      videoScrollPosition = Math.min(videoScrollPosition + 400, videoGrid.scrollWidth - videoGrid.clientWidth);
      videoGrid.scrollTo({
        left: videoScrollPosition,
        behavior: 'smooth'
      });
    });

    // Défilement horizontal pour la galerie photo
    const albumGrid = document.getElementById('album-grid');
    const photoPrev = document.getElementById('photo-prev');
    const photoNext = document.getElementById('photo-next');
    let photoScrollPosition = 0;

    photoPrev.addEventListener('click', () => {
      photoScrollPosition = Math.max(photoScrollPosition - 400, 0);
      albumGrid.scrollTo({
        left: photoScrollPosition,
        behavior: 'smooth'
      });
    });

    photoNext.addEventListener('click', () => {
      photoScrollPosition = Math.min(photoScrollPosition + 400, albumGrid.scrollWidth - albumGrid.clientWidth);
      albumGrid.scrollTo({
        left: photoScrollPosition,
        behavior: 'smooth'
      });
    });

    // Défilement horizontal pour le matériel de sonorisation
    const equipmentGrid = document.getElementById('equipment-grid');
    const sonoPrev = document.getElementById('sono-prev');
    const sonoNext = document.getElementById('sono-next');
    let sonoScrollPosition = 0;

    sonoPrev.addEventListener('click', () => {
      sonoScrollPosition = Math.max(sonoScrollPosition - 400, 0);
      equipmentGrid.scrollTo({
        left: sonoScrollPosition,
        behavior: 'smooth'
      });
    });

    sonoNext.addEventListener('click', () => {
      sonoScrollPosition = Math.min(sonoScrollPosition + 400, equipmentGrid.scrollWidth - equipmentGrid.clientWidth);
      equipmentGrid.scrollTo({
        left: sonoScrollPosition,
        behavior: 'smooth'
      });
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
