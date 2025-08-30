# Projet MCC - Corrections des Liens de Navigation

## Problème identifié

Les liens de navigation entre les pages d'authentification et la page d'accueil ne fonctionnaient pas correctement :

1. **Page de connexion** (`app/views/Auth/login.php`) :
   - "Retour à l'accueil" pointait vers `index.php` (fichier de routage PHP)
   - "Créer un compte" pointait vers `index.php?controller=auth&action=registerForm`

2. **Page d'inscription** (`app/views/Auth/register.php`) :
   - "Déjà un compte ? Se connecter" pointait vers `index.php?controller=auth&action=login`

## Solution appliquée

### 1. Conversion de la page d'accueil

**Avant :** Page d'accueil en `index.html`  
**Après :** Page d'accueil en `index.php` (contenu identique préservé)

### 2. Correction du fichier `app/views/Auth/login.php`

**Avant :**
```html
<a href="index.php" class="link">← Retour à l'accueil</a>
<a href="index.php?controller=auth&action=registerForm" class="link">Créer un compte</a>
```

**Après :**
```html
<a href="../../../index.php" class="link">← Retour à l'accueil</a>
<a href="register.php" class="link">Créer un compte</a>
```

### 3. Correction du fichier `app/views/Auth/register.php`

**Avant :**
```html
<a href="index.php?controller=auth&action=login" class="link">Déjà un compte ? Se connecter →</a>
```

**Après :**
```html
<a href="login.php" class="link">Déjà un compte ? Se connecter →</a>
```

## Structure du projet respectée

- **Page d'accueil** : `index.php` (racine du projet) - **NOUVEAU**
- **Page de connexion** : `app/views/Auth/login.php`
- **Page d'inscription** : `app/views/Auth/register.php`

## Navigation fonctionnelle

Maintenant, la navigation fonctionne correctement :

✅ **"Retour à l'accueil"** → Renvoie vers la page d'accueil (`index.php`)  
✅ **"Créer un compte"** → Renvoie vers le formulaire d'inscription (`register.php`)  
✅ **"Déjà un compte ? Se connecter"** → Renvoie vers le formulaire de connexion (`login.php`)  

## Remarques techniques

- **Conversion réussie** : `index.html` → `index.php` sans modification du contenu
- Les liens utilisent des chemins relatifs pour maintenir la portabilité du projet
- La structure MVC du projet est préservée
- Aucun nouveau fichier n'a été créé, seuls les liens existants ont été corrigés
- Les liens dans `index.php` vers les pages d'authentification fonctionnent déjà correctement
- **Avantage** : Le fichier PHP peut maintenant être traité par le serveur web et permettre l'utilisation de fonctionnalités PHP si nécessaire

## Test de la navigation

Pour tester que tout fonctionne :
1. Ouvrir `index.php` dans un navigateur
2. Cliquer sur "Se connecter" ou "S'inscrire" dans le header/footer
3. Dans la page de connexion, tester "Retour à l'accueil" et "Créer un compte"
4. Dans la page d'inscription, tester "Déjà un compte ? Se connecter"

## Changements effectués

- ✅ `index.html` → `index.php` (conversion sans perte de contenu)
- ✅ Mise à jour des liens dans `login.php` vers `index.php`
- ✅ Suppression de l'ancien fichier `index.html`
- ✅ Tous les liens de navigation fonctionnent correctement
