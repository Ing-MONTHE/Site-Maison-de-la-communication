# Projet MCC - Corrections des Liens de Navigation

## Problème identifié

Les liens de navigation entre les pages d'authentification et la page d'accueil ne fonctionnaient pas correctement :

1. **Page de connexion** (`app/views/Auth/login.php`) :
   - "Retour à l'accueil" pointait vers `index.php` (fichier de routage PHP)
   - "Créer un compte" pointait vers `index.php?controller=auth&action=registerForm`

2. **Page d'inscription** (`app/views/Auth/register.php`) :
   - "Déjà un compte ? Se connecter" pointait vers `index.php?controller=auth&action=login`

## Solution appliquée

### 1. Correction du fichier `app/views/Auth/login.php`

**Avant :**
```html
<a href="index.php" class="link">← Retour à l'accueil</a>
<a href="index.php?controller=auth&action=registerForm" class="link">Créer un compte</a>
```

**Après :**
```html
<a href="../../../index.html" class="link">← Retour à l'accueil</a>
<a href="register.php" class="link">Créer un compte</a>
```

### 2. Correction du fichier `app/views/Auth/register.php`

**Avant :**
```html
<a href="index.php?controller=auth&action=login" class="link">Déjà un compte ? Se connecter →</a>
```

**Après :**
```html
<a href="login.php" class="link">Déjà un compte ? Se connecter →</a>
```

## Structure du projet respectée

- **Page d'accueil** : `index.html` (racine du projet)
- **Page de connexion** : `app/views/Auth/login.php`
- **Page d'inscription** : `app/views/Auth/register.php`

## Navigation fonctionnelle

Maintenant, la navigation fonctionne correctement :

✅ **"Retour à l'accueil"** → Renvoie vers la page d'accueil (`index.html`)  
✅ **"Créer un compte"** → Renvoie vers le formulaire d'inscription (`register.php`)  
✅ **"Déjà un compte ? Se connecter"** → Renvoie vers le formulaire de connexion (`login.php`)  

## Remarques techniques

- Les liens utilisent des chemins relatifs pour maintenir la portabilité du projet
- La structure MVC du projet est préservée
- Aucun nouveau fichier n'a été créé, seuls les liens existants ont été corrigés
- Les liens dans `index.html` vers les pages d'authentification fonctionnent déjà correctement

## Test de la navigation

Pour tester que tout fonctionne :
1. Ouvrir `index.html` dans un navigateur
2. Cliquer sur "Se connecter" ou "S'inscrire" dans le header/footer
3. Dans la page de connexion, tester "Retour à l'accueil" et "Créer un compte"
4. Dans la page d'inscription, tester "Déjà un compte ? Se connecter"
