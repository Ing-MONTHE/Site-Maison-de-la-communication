# Système de Sécurité et Contrôle d'Accès - MCC

## 🛡️ **Problème résolu**

### **Situation initiale :**
- Le lien "Accès Administration" était visible à tous les visiteurs sur la page d'accueil
- Aucune distinction entre utilisateurs publics et administrateurs
- Risque de sécurité et exposition de l'interface d'administration

### **Solution implémentée :**
- Système de contrôle d'accès basé sur les rôles utilisateurs
- Masquage conditionnel du lien d'administration
- Interface adaptative selon le statut de l'utilisateur

## 🔐 **Architecture de sécurité**

### **1. Système de rôles utilisateurs**

```php
// Rôles définis dans la base de données
- 'visiteur'        : Visiteur public (non connecté)
- 'visiteur_auth'   : Visiteur authentifié
- 'personnel'       : Personnel autorisé
- 'admin'           : Administrateur
```

### **2. Classes de contrôle d'accès**

#### **`Config\Auth.php`**
```php
class Auth {
    public static function isAdmin(): bool           // Vérifie si admin
    public static function isAuthenticated(): bool   // Vérifie si connecté
    public static function isPublic(): bool          // Vérifie si visiteur public
    public static function canAccessAdmin(): bool    // Vérifie les permissions admin
    public static function requireAdmin(): void      // Redirige si pas admin
    public static function requireAuth(): void       // Redirige si pas connecté
}
```

#### **`app/controlleurs/AuthController.php`**
- Gère l'authentification des visiteurs normaux
- Séparation claire entre admin et utilisateurs publics
- Validation des identifiants et gestion des sessions

## 🎯 **Fonctionnalités implémentées**

### **1. Contrôle d'affichage conditionnel**

#### **Page d'accueil (`index.php`)**
```php
// Navigation adaptative
<?php if (Auth::isPublic()): ?>
    <a href="app/views/Auth/login.php">Se connecter</a>
    <a href="app/views/Auth/register.php">S'inscrire</a>
<?php elseif (Auth::isAuthenticated()): ?>
    <a href="app/views/Auth/profile.php">Mon profil</a>
    <a href="app/views/Auth/logout.php">Déconnexion</a>
<?php elseif (Auth::isAdmin()): ?>
    <a href="app/views/admin/">Administration</a>
    <a href="app/controlleurs/AdminController.php?action=logout">Déconnexion</a>
<?php endif; ?>

// Section hero adaptative
<?php if (Auth::canAccessAdmin()): ?>
    <a href="app/views/admin/">Accès administration</a>
<?php endif; ?>
```

### **2. Système de notifications**

#### **Messages de succès/erreur**
```php
// Affichage conditionnel des notifications
<?php if (isset($_GET['success'])): ?>
<div class="notification success">
    <p><?= htmlspecialchars($_GET['success']) ?></p>
    <button class="close-notification">×</button>
</div>
<?php endif; ?>
```

### **3. Gestion des sessions**

#### **Sessions séparées**
- **Session admin** : `$_SESSION['admin_logged_in']`, `$_SESSION['admin_user_id']`
- **Session utilisateur** : `$_SESSION['user_id']`, `$_SESSION['username']`
- **Séparation claire** pour éviter les conflits

## 🔒 **Mesures de sécurité**

### **1. Validation des données**
```php
// Validation côté serveur
if (empty($username) || empty($password)) {
    header('Location: login.php?error=Identifiants manquants');
    return;
}
```

### **2. Protection contre les injections SQL**
```php
// Utilisation de requêtes préparées
$stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
```

### **3. Hachage des mots de passe**
```php
// Hachage sécurisé avec bcrypt
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
```

### **4. Contrôle d'accès strict**
```php
// Vérification des rôles avant accès
if (!Auth::canAccessAdmin()) {
    header('Location: login.php');
    exit();
}
```

## 📋 **Comportements par type d'utilisateur**

### **👤 Visiteur public (non connecté)**
- **Voit** : Page d'accueil complète sans lien d'administration
- **Accès** : Se connecter, S'inscrire
- **Navigation** : Standard

### **🔐 Visiteur authentifié**
- **Voit** : Page d'accueil sans lien d'administration
- **Accès** : Mon profil, Déconnexion
- **Navigation** : Personnalisée

### **👨‍💼 Personnel**
- **Voit** : Page d'accueil AVEC lien d'administration
- **Accès** : Administration, Déconnexion admin
- **Navigation** : Complète

### **👑 Administrateur**
- **Voit** : Page d'accueil AVEC lien d'administration
- **Accès** : Administration complète, Déconnexion admin
- **Navigation** : Complète

## 🛠️ **Fichiers modifiés/créés**

### **Nouveaux fichiers :**
- `config/Auth.php` - Classe de contrôle d'accès
- `app/controlleurs/AuthController.php` - Contrôleur d'authentification
- `app/views/Auth/logout.php` - Page de déconnexion
- `SECURITY_README.md` - Documentation de sécurité

### **Fichiers modifiés :**
- `index.php` - Contrôle d'affichage conditionnel
- `public/assets/css/styles.css` - Styles des notifications

## 🚀 **Utilisation**

### **Pour les développeurs :**
```php
// Vérifier le statut utilisateur
if (Auth::isAdmin()) {
    // Code pour admin
}

// Protéger une page
Auth::requireAdmin();

// Adapter l'interface
<?php if (Auth::canAccessAdmin()): ?>
    <!-- Contenu admin -->
<?php endif; ?>
```

### **Pour les utilisateurs :**
1. **Visiteur public** : Navigue normalement, ne voit pas l'administration
2. **Utilisateur connecté** : Accès à son profil, pas d'administration
3. **Personnel/Admin** : Accès complet à l'administration

## 🔍 **Tests de sécurité**

### **Scénarios testés :**
- ✅ Visiteur public ne voit pas le lien d'administration
- ✅ Utilisateur connecté ne voit pas le lien d'administration
- ✅ Personnel voit le lien d'administration
- ✅ Admin voit le lien d'administration
- ✅ Tentative d'accès direct à l'admin sans authentification
- ✅ Séparation des sessions admin/utilisateur

## 📝 **Maintenance**

### **Ajout de nouveaux rôles :**
1. Modifier la classe `Auth.php`
2. Mettre à jour les conditions d'affichage
3. Tester les nouveaux comportements

### **Modification des permissions :**
1. Ajuster `canAccessAdmin()` dans `Auth.php`
2. Mettre à jour les vues concernées
3. Tester les changements

---

**Note** : Ce système garantit que seuls les utilisateurs autorisés peuvent voir et accéder à l'interface d'administration, tout en maintenant une expérience utilisateur fluide pour les visiteurs publics.
