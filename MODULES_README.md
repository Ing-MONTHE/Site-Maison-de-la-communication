# Gestion des Modules - Interface d'Administration MCC

## Vue d'ensemble

La gestion des modules permet à l'administrateur de contrôler tous les services (modules) de la plateforme MCC. Cette fonctionnalité complète l'interface d'administration en permettant la création, modification et suppression des modules de service.

## Fonctionnalités principales

### 1. **Liste des modules**
- Affichage en grille de tous les modules existants
- Informations détaillées : nom, description, statut, dates de création/modification
- Indicateurs visuels de statut (actif/inactif)
- Actions rapides pour chaque module

### 2. **Création de modules**
- Formulaire complet pour ajouter de nouveaux services
- Champs : nom, description, statut, icône, couleur
- Validation des données côté serveur
- Interface intuitive avec prévisualisation

### 3. **Modification de modules**
- Édition en place des informations existantes
- Mise à jour des métadonnées (icône, couleur, description)
- Changement de statut (actif/inactif)
- Historique des modifications

### 4. **Suppression de modules**
- Confirmation avant suppression
- Suppression en cascade des publications liées
- Protection contre les suppressions accidentelles

### 5. **Filtrage et recherche**
- Recherche par nom de module
- Filtrage par statut (actif/inactif)
- Interface responsive pour tous les écrans

## Structure des fichiers

```
app/views/admin/
├── modules.php              # Page principale de gestion des modules
└── [autres fichiers admin]

app/controlleurs/
└── AdminController.php      # Contrôleur avec méthodes CRUD pour modules

public/assets/css/
└── admin.css               # Styles spécifiques aux modules
```

## Méthodes du contrôleur

### `createModule()`
- **Action** : `createModule`
- **Fonction** : Création d'un nouveau module
- **Validation** : Nom requis, autres champs optionnels
- **Redirection** : Retour vers la liste avec message de succès/erreur

### `updateModule()`
- **Action** : `updateModule`
- **Fonction** : Modification d'un module existant
- **Validation** : ID et nom requis
- **Redirection** : Retour vers la liste avec message de succès/erreur

### `deleteModule()`
- **Action** : `deleteModule`
- **Fonction** : Suppression d'un module et ses publications
- **Sécurité** : Vérification des dépendances
- **Redirection** : Retour vers la liste avec message de succès/erreur

## Structure de la base de données

### Table `modules`
```sql
CREATE TABLE modules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    statut ENUM('actif', 'inactif') DEFAULT 'actif',
    icone VARCHAR(100),
    couleur VARCHAR(7) DEFAULT '#007bff',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);
```

## Interface utilisateur

### Page principale (`modules.php`)
- **Sidebar** : Navigation vers autres sections
- **Header** : Titre et bouton "Nouveau Module"
- **Filtres** : Recherche et filtrage par statut
- **Grille** : Affichage des modules en cartes
- **Modals** : Formulaires d'ajout/modification et confirmation de suppression

### Éléments visuels
- **Cartes de modules** : Design moderne avec hover effects
- **Statuts** : Badges colorés (vert pour actif, rouge pour inactif)
- **Icônes** : Support Font Awesome personnalisable
- **Couleurs** : Sélecteur de couleur pour personnalisation

## Utilisation

### 1. **Accès à la gestion des modules**
```
URL : app/views/admin/modules.php
Prérequis : Connexion administrateur
```

### 2. **Créer un nouveau module**
1. Cliquer sur "Nouveau Module"
2. Remplir le formulaire :
   - Nom (obligatoire)
   - Description (optionnelle)
   - Statut (actif/inactif)
   - Icône Font Awesome (optionnelle)
   - Couleur (optionnelle)
3. Cliquer sur "Enregistrer"

### 3. **Modifier un module existant**
1. Cliquer sur "Modifier" sur la carte du module
2. Modifier les champs souhaités
3. Cliquer sur "Enregistrer"

### 4. **Supprimer un module**
1. Cliquer sur "Supprimer" sur la carte du module
2. Confirmer la suppression dans le modal
3. Attention : Supprime aussi les publications liées

### 5. **Filtrer et rechercher**
- Utiliser la barre de recherche pour trouver par nom
- Utiliser le filtre de statut pour afficher actifs/inactifs

## Intégration avec le système

### Dashboard
- **Statistiques** : Nombre total de modules
- **Actions rapides** : Lien direct vers la gestion des modules
- **Modules existants** : Liens vers les publications par module

### Publications
- **Association** : Chaque publication est liée à un module
- **Filtrage** : Possibilité de filtrer par module
- **Cascade** : Suppression des publications lors de la suppression d'un module

### Navigation
- **Sidebar** : Lien "Modules" dans la navigation principale
- **Breadcrumbs** : Indication de la section active

## Sécurité

### Authentification
- Vérification de session administrateur
- Protection contre l'accès non autorisé
- Redirection vers login si non connecté

### Validation
- Validation côté serveur de tous les champs
- Protection contre les injections SQL
- Gestion des erreurs avec messages explicites

### Intégrité des données
- Vérification des dépendances avant suppression
- Suppression en cascade des publications liées
- Protection contre les suppressions accidentelles

## Personnalisation

### Styles CSS
- Variables CSS pour les couleurs principales
- Classes modulaires pour les cartes et statuts
- Design responsive pour tous les écrans

### Icônes
- Support complet Font Awesome
- Champs personnalisables pour chaque module
- Icônes par défaut si non spécifiées

### Couleurs
- Sélecteur de couleur intégré
- Couleur par défaut : `#007bff`
- Personnalisation par module

## Maintenance

### Logs et monitoring
- Messages de succès/erreur détaillés
- Redirection avec paramètres d'état
- Gestion des exceptions avec try/catch

### Performance
- Requêtes SQL optimisées
- Pagination pour les grandes listes
- Chargement asynchrone des données

### Sauvegarde
- Intégration avec le système de sauvegarde général
- Protection des données critiques
- Restauration en cas de problème

## Support et développement

### Ajout de fonctionnalités
- Structure modulaire pour extensions
- Hooks pour intégration de nouvelles fonctionnalités
- Documentation des APIs internes

### Tests
- Validation des formulaires
- Tests de suppression en cascade
- Vérification de l'intégrité des données

### Déploiement
- Compatible avec l'architecture existante
- Pas de dépendances externes supplémentaires
- Intégration transparente avec le système

---

**Note** : Cette documentation fait partie de l'interface d'administration complète du projet MCC. Pour plus d'informations sur l'ensemble du système, consultez le fichier `ADMIN_README.md`.
