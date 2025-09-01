# Interface d'Administration MCC

## Vue d'ensemble

L'interface d'administration du projet MCC est une solution complète de gestion de contenu (CMS) développée en PHP avec une architecture MVC. Elle permet aux administrateurs de gérer tous les aspects du site web de manière sécurisée et intuitive.

## Fonctionnalités principales

### 🔐 Authentification sécurisée
- **Connexion sécurisée** avec mot de passe haché (bcrypt)
- **Gestion des sessions** avec timeout configurable
- **Protection CSRF** intégrée
- **Rôles utilisateurs** : visiteur, visiteur_auth, personnel, admin

### 📝 CRUD complet pour les contenus
- **Créer** : Nouveaux articles, publications, médias
- **Lire** : Consultation et recherche de contenu
- **Mettre à jour** : Modification des informations existantes
- **Supprimer** : Suppression sécurisée avec confirmation

### 🎨 Gestion des médias
- **Upload multiple** de fichiers (images, vidéos, audio)
- **Optimisation automatique** des images
- **Génération de miniatures** automatique
- **Organisation par modules** et catégories
- **Formats supportés** : JPG, PNG, GIF, MP4, MP3, WAV, AVI

### 🏗️ Organisation par modules et catégories
- **Modules** : RVE, Imprimerie, SerCom, Luma Vitae
- **Catégories** : Actualités, Émissions, Publications, Albums photos
- **Navigation intuitive** par module
- **Filtrage et recherche** avancés

### 👁️ Prévisualisation avant publication
- **Éditeur de texte riche** (TinyMCE)
- **Prévisualisation en temps réel**
- **Statuts** : Brouillon et Publié
- **Sauvegarde automatique**

## Structure des fichiers

```
app/views/admin/
├── login.php              # Page de connexion
├── dashboard.php          # Tableau de bord principal
├── publications.php       # Gestion des publications
├── publication-form.php    # Formulaire création/modification
├── media.php             # Gestion des médias
├── users.php             # Gestion des utilisateurs
├── settings.php          # Paramètres système
└── index.php             # Redirection automatique

app/controlleurs/
└── AdminController.php   # Contrôleur principal

public/assets/css/
└── admin.css             # Styles de l'interface admin

config/
├── Database.php          # Configuration base de données
└── projet_mcc.sql       # Structure de la base de données
```

## Installation et configuration

### 1. Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)
- Extensions PHP : PDO, GD, FileInfo

### 2. Configuration de la base de données
```sql
-- Importer le fichier config/projet_mcc.sql
-- Créer un utilisateur administrateur
INSERT INTO users (username, email, password, role) 
VALUES ('admin', 'admin@mcc.org', '$2y$10$...', 'admin');
```

### 3. Configuration des permissions
```bash
# Donner les permissions d'écriture au dossier uploads
chmod 755 Images/uploads/
```

### 4. Accès à l'administration
- URL : `http://votre-domaine.com/app/views/admin/`
- Identifiants par défaut : admin / mot de passe défini

## Utilisation

### Tableau de bord
- **Statistiques** : Publications, utilisateurs, médias, modules
- **Actions rapides** : Créer publication, upload média, nouvel utilisateur
- **Navigation par modules** : Accès direct aux services

### Gestion des publications
1. **Créer** : Cliquer sur "Nouvelle publication"
2. **Rédiger** : Utiliser l'éditeur de texte riche
3. **Prévisualiser** : Voir le rendu avant publication
4. **Publier** : Choisir le statut "Publié"

### Gestion des médias
1. **Upload** : Glisser-déposer ou sélectionner fichiers
2. **Organiser** : Associer aux publications
3. **Optimiser** : Redimensionnement automatique
4. **Gérer** : Renommer, supprimer, prévisualiser

### Gestion des utilisateurs
- **Créer** : Nouveaux comptes avec rôles
- **Modifier** : Informations et permissions
- **Supprimer** : Suppression sécurisée
- **Rôles** : Visiteur, Visiteur authentifié, Personnel, Admin

## Sécurité

### Authentification
- **Mots de passe hachés** avec bcrypt
- **Sessions sécurisées** avec timeout
- **Protection contre les attaques** CSRF et XSS
- **Validation des données** côté serveur

### Permissions
- **Contrôle d'accès** par rôle
- **Protection des routes** sensibles
- **Logs d'activité** des administrateurs
- **Sauvegarde automatique** des données

### Upload de fichiers
- **Validation des types** MIME
- **Limitation de taille** (10MB par défaut)
- **Scan antivirus** intégré
- **Noms de fichiers sécurisés**

## Personnalisation

### Styles CSS
Le fichier `public/assets/css/admin.css` utilise des variables CSS pour faciliter la personnalisation :

```css
:root {
  --brand: #0b7c66;        /* Couleur principale */
  --brand-2: #0b967c;      /* Couleur secondaire */
  --dark: #1e2a36;         /* Texte sombre */
  --text: #2b2b2b;         /* Texte normal */
  --muted: #64748b;        /* Texte atténué */
  --bg: #f6f9fb;          /* Arrière-plan */
  --white: #ffffff;       /* Blanc */
  --success: #10b981;     /* Succès */
  --error: #ef4444;       /* Erreur */
  --warning: #f59e0b;     /* Avertissement */
}
```

### Configuration
Les paramètres système sont accessibles via la page "Paramètres" :
- **Informations du site** : Nom, description, contact
- **Sécurité** : Timeout session, tentatives connexion
- **Médias** : Formats autorisés, taille max, optimisation
- **Publications** : Statut par défaut, pagination
- **Notifications** : Alertes système

## Maintenance

### Outils intégrés
- **Vidage du cache** : Optimisation des performances
- **Optimisation BDD** : Nettoyage et indexation
- **Sauvegarde complète** : Protection des données
- **Vérification système** : Diagnostic automatique

### Monitoring
- **Espace disque** : Surveillance du stockage
- **Performance** : Temps de réponse
- **Erreurs** : Logs et notifications
- **Sécurité** : Tentatives de connexion échouées

## Support et développement

### Logs d'erreur
Les erreurs sont enregistrées dans :
- **PHP** : `/var/log/php_errors.log`
- **Application** : `logs/admin_errors.log`
- **Upload** : `logs/upload_errors.log`

### Développement
Pour ajouter de nouvelles fonctionnalités :
1. Créer la vue dans `app/views/admin/`
2. Ajouter la méthode dans `AdminController.php`
3. Mettre à jour la navigation
4. Tester la sécurité

### Extensions possibles
- **API REST** pour applications mobiles
- **Multi-langues** avec système de traduction
- **Workflow** de validation des publications
- **Analytics** et statistiques avancées
- **Backup cloud** automatique

## Licence

Ce projet est développé pour la Maison de la Communication Chrétienne (MCC) et est destiné à un usage interne.

---

**Version** : 1.0  
**Dernière mise à jour** : Décembre 2024  
**Développeur** : Assistant IA Claude  
**Contact** : admin@mcc.org
