<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Radio Vox Ecclesiae - MCC</title>
  <link rel="stylesheet" href="../../../public/assets/css/styles.css" />
  <link rel="stylesheet" href="../../../public/assets/css/rve.css" />
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

  <!-- Hero Section RVE -->
  <section class="rve-hero">
    <div class="overlay"></div>
    <div class="container hero-content">
      <div class="rve-logo">
        <img src="../../../Images/logo RVE.jpg" alt="Logo Radio Vox Ecclesiae" />
      </div>
      <h1>Radio Vox Ecclesiae</h1>
      <p>La voix de l'Église qui résonne dans les cœurs</p>
      <div class="live-indicator">
        <span class="live-dot"></span>
        <span>EN DIRECT</span>
      </div>
    </div>
  </section>

  <!-- Navigation des sections RVE -->
  <nav class="rve-nav">
    <div class="container">
      <ul>
        <li><a href="#direct" class="nav-link active">Direct</a></li>
        <li><a href="#emissions" class="nav-link">Émissions</a></li>
        <li><a href="#vie-radio" class="nav-link">Vie de la Radio</a></li>
        <li><a href="#equipe" class="nav-link">Notre Équipe</a></li>
      </ul>
    </div>
  </nav>

  <!-- Section Direct -->
  <section id="direct" class="rve-section direct-section">
    <div class="container">
      <h2>Écouter en Direct</h2>
      <div class="direct-player">
        <div class="player-container">
          <div class="player-visual">
            <img src="../../../Images/logo RVE.jpg" alt="RVE Studio" />
            <div class="player-overlay">
              <button class="play-btn" id="play-btn">▶</button>
            </div>
          </div>
          <div class="player-info">
            <h3>Programme en cours</h3>
            <p class="current-show">"Parole du Jour" - Père Jean-Baptiste</p>
            <p class="time-remaining">Prochaine émission dans 15 minutes</p>
            <div class="player-controls">
              <button class="control-btn" id="prev-btn">⏮</button>
              <button class="control-btn" id="play-pause-btn">▶</button>
              <button class="control-btn" id="next-btn">⏭</button>
              <div class="volume-control">
                <span>🔊</span>
                <input type="range" id="volume" min="0" max="100" value="80" />
              </div>
            </div>
          </div>
        </div>
        <div class="schedule-preview">
          <h4>Programme du jour</h4>
          <ul class="schedule-list">
            <li class="current">
              <span class="time">08:00</span>
              <span class="show">Parole du Jour</span>
              <span class="host">Père Jean-Baptiste</span>
            </li>
            <li>
              <span class="time">09:00</span>
              <span class="show">Méditation Chrétienne</span>
              <span class="host">Sœur Marie-Claire</span>
            </li>
            <li>
              <span class="time">10:00</span>
              <span class="show">Actualités de l'Église</span>
              <span class="host">Père Emmanuel</span>
            </li>
            <li>
              <span class="time">11:00</span>
              <span class="show">Musique Sacrée</span>
              <span class="host">Chœur Diocésain</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Émissions -->
  <section id="emissions" class="rve-section emissions-section">
    <div class="container">
      <h2>Nos Émissions</h2>
      <div class="emissions-grid">
        <article class="emission-card">
          <div class="emission-image">
            <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=400" alt="Parole du Jour" />
            <div class="emission-overlay">
              <button class="play-emission">▶</button>
            </div>
          </div>
          <div class="emission-content">
            <h3>Parole du Jour</h3>
            <p>Commentaire quotidien de l'Évangile avec Père Jean-Baptiste</p>
            <div class="emission-meta">
              <span class="duration">15 min</span>
              <span class="category">Spiritualité</span>
            </div>
            <div class="emission-actions">
              <button class="btn btn-outline">Écouter</button>
              <button class="btn">Télécharger</button>
            </div>
          </div>
        </article>

        <article class="emission-card">
          <div class="emission-image">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Méditation Chrétienne" />
            <div class="emission-overlay">
              <button class="play-emission">▶</button>
            </div>
          </div>
          <div class="emission-content">
            <h3>Méditation Chrétienne</h3>
            <p>Moment de recueillement et de prière guidée</p>
            <div class="emission-meta">
              <span class="duration">20 min</span>
              <span class="category">Prières</span>
            </div>
            <div class="emission-actions">
              <button class="btn btn-outline">Écouter</button>
              <button class="btn">Télécharger</button>
            </div>
          </div>
        </article>

        <article class="emission-card">
          <div class="emission-image">
            <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400" alt="Actualités de l'Église" />
            <div class="emission-overlay">
              <button class="play-emission">▶</button>
            </div>
          </div>
          <div class="emission-content">
            <h3>Actualités de l'Église</h3>
            <p>Informations et nouvelles du diocèse et de l'Église universelle</p>
            <div class="emission-meta">
              <span class="duration">25 min</span>
              <span class="category">Actualités</span>
            </div>
            <div class="emission-actions">
              <button class="btn btn-outline">Écouter</button>
              <button class="btn">Télécharger</button>
            </div>
          </div>
        </article>

        <article class="emission-card">
          <div class="emission-image">
            <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400" alt="Musique Sacrée" />
            <div class="emission-overlay">
              <button class="play-emission">▶</button>
            </div>
          </div>
          <div class="emission-content">
            <h3>Musique Sacrée</h3>
            <p>Chants liturgiques et musique spirituelle</p>
            <div class="emission-meta">
              <span class="duration">30 min</span>
              <span class="category">Musique</span>
            </div>
            <div class="emission-actions">
              <button class="btn btn-outline">Écouter</button>
              <button class="btn">Télécharger</button>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- Section Vie de la Radio -->
  <section id="vie-radio" class="rve-section vie-radio-section">
    <div class="container">
      <h2>Vie de la Radio</h2>
      <div class="vie-radio-content">
        <div class="news-section">
          <h3>Actualités RVE</h3>
          <div class="news-grid">
            <article class="news-card">
              <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=300" alt="Nouveau studio" />
              <div class="news-content">
                <h4>Nouveau studio d'enregistrement</h4>
                <p>RVE inaugure son nouveau studio professionnel pour améliorer la qualité de diffusion</p>
                <span class="news-date">15 Mars 2024</span>
              </div>
            </article>
            <article class="news-card">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300" alt="Formation" />
              <div class="news-content">
                <h4>Formation des animateurs</h4>
                <p>Session de formation sur les techniques de radio et la communication chrétienne</p>
                <span class="news-date">10 Mars 2024</span>
              </div>
            </article>
            <article class="news-card">
              <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=300" alt="Événement" />
              <div class="news-content">
                <h4>Festival de la Radio Chrétienne</h4>
                <p>RVE participe au grand festival national des radios chrétiennes</p>
                <span class="news-date">5 Mars 2024</span>
              </div>
            </article>
          </div>
        </div>
        
        <div class="events-section">
          <h3>Événements à venir</h3>
          <div class="events-list">
            <div class="event-item">
              <div class="event-date">
                <span class="day">25</span>
                <span class="month">Mars</span>
              </div>
              <div class="event-details">
                <h4>Concert Gospel en direct</h4>
                <p>Grand concert gospel avec le chœur diocésain</p>
                <span class="event-time">20:00 - 22:00</span>
              </div>
            </div>
            <div class="event-item">
              <div class="event-date">
                <span class="day">30</span>
                <span class="month">Mars</span>
              </div>
              <div class="event-details">
                <h4>Émission spéciale Pâques</h4>
                <p>Programme spécial pour la célébration de Pâques</p>
                <span class="event-time">19:00 - 21:00</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Équipe -->
  <section id="equipe" class="rve-section equipe-section">
    <div class="container">
      <h2>Notre Équipe</h2>
      <div class="equipe-grid">
        <div class="membre-card">
          <div class="membre-photo">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300" alt="Père Jean-Baptiste" />
          </div>
          <div class="membre-info">
            <h3>Père Jean-Baptiste</h3>
            <p class="role">Directeur spirituel & Animateur principal</p>
            <p class="description">Prêtre du diocèse, spécialiste en communication chrétienne et animateur de l'émission "Parole du Jour"</p>
            <div class="membre-emissions">
              <span class="emission-tag">Parole du Jour</span>
              <span class="emission-tag">Actualités</span>
            </div>
          </div>
        </div>

        <div class="membre-card">
          <div class="membre-photo">
            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300" alt="Sœur Marie-Claire" />
          </div>
          <div class="membre-info">
            <h3>Sœur Marie-Claire</h3>
            <p class="role">Responsable des programmes spirituels</p>
            <p class="description">Religieuse dédiée à la prière et à la méditation, elle anime les moments de recueillement et de prière guidée</p>
            <div class="membre-emissions">
              <span class="emission-tag">Méditation</span>
              <span class="emission-tag">Prières</span>
            </div>
          </div>
        </div>

        <div class="membre-card">
          <div class="membre-photo">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300" alt="Père Emmanuel" />
          </div>
          <div class="membre-info">
            <h3>Père Emmanuel</h3>
            <p class="role">Animateur & Journaliste</p>
            <p class="description">Prêtre passionné par l'actualité de l'Église, il présente les nouvelles du diocèse et de l'Église universelle</p>
            <div class="membre-emissions">
              <span class="emission-tag">Actualités</span>
              <span class="emission-tag">Reportages</span>
            </div>
          </div>
        </div>

        <div class="membre-card">
          <div class="membre-photo">
            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300" alt="Marie-Anne" />
          </div>
          <div class="membre-info">
            <h3>Marie-Anne</h3>
            <p class="role">Technicienne son & Production</p>
            <p class="description">Technicienne expérimentée, elle assure la qualité technique de toutes nos émissions et la production des contenus</p>
            <div class="membre-emissions">
              <span class="emission-tag">Production</span>
              <span class="emission-tag">Technique</span>
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
        <h4>RVE - Radio Vox Ecclesiae</h4>
        <p>La voix de l'Église qui résonne dans les cœurs</p>
        <p>Fondée en 2010 par le diocèse de Douala</p>
      </div>
      <div>
        <h4>Navigation</h4>
        <ul class="footer-links">
          <li><a href="#direct">Écouter en direct</a></li>
          <li><a href="#emissions">Nos émissions</a></li>
          <li><a href="#vie-radio">Actualités</a></li>
          <li><a href="#equipe">Notre équipe</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact RVE</h4>
        <p>Studio RVE - Diocèse de Douala</p>
        <p>Email: rve@mcc-rve.cm</p>
        <a class="btn btn-outline" href="../Auth/login.php">Accès administration</a>
      </div>
    </div>
    <div class="container copyrights">
      <p>© <span id="year"></span> Radio Vox Ecclesiae – Tous droits réservés.</p>
    </div>
  </footer>

  <script>
    // Navigation des sections
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.rve-section');

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

    // Player controls
    const playPauseBtn = document.getElementById('play-pause-btn');
    const playBtn = document.getElementById('play-btn');
    let isPlaying = false;

    playPauseBtn.addEventListener('click', () => {
      isPlaying = !isPlaying;
      playPauseBtn.textContent = isPlaying ? '⏸' : '▶';
      playBtn.textContent = isPlaying ? '⏸' : '▶';
    });

    playBtn.addEventListener('click', () => {
      isPlaying = !isPlaying;
      playBtn.textContent = isPlaying ? '⏸' : '▶';
      playPauseBtn.textContent = isPlaying ? '⏸' : '▶';
    });

    // Volume control
    const volumeSlider = document.getElementById('volume');
    volumeSlider.addEventListener('input', (e) => {
      // Logique de contrôle du volume
      console.log('Volume:', e.target.value);
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
