# Dépannage Tailwind CSS - Mairie France Theme

## 🚨 Problème : Tailwind CSS ne fonctionne pas

### Symptômes
- Les classes Tailwind (bg-white, flex, text-gray-800, etc.) n'ont aucun effet
- Le site s'affiche sans mise en forme
- Les CDN sont bien chargés dans le HTML mais aucun style n'est appliqué

### Causes possibles et solutions

#### 1. ❌ Mauvaise URL du CDN Tailwind

**Problème :** `https://cdn.tailwindcss.com` est la version "Play CDN" qui nécessite une configuration JavaScript, pas un fichier CSS standard.

**Solution :** Utiliser le CDN jsDelivr avec le fichier CSS compilé complet.

```php
// ❌ MAUVAIS
wp_enqueue_style('tailwind-cdn', 'https://cdn.tailwindcss.com', array(), '3.4.1');

// ✅ BON
wp_enqueue_style('tailwind-cdn', 'https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css', array(), '3.4.1');
```

**Vérification :**
1. Ouvrir la console du navigateur (F12)
2. Onglet "Network" / "Réseau"
3. Filtrer par "CSS"
4. Vérifier que `tailwind.min.css` se charge avec un code 200

#### 2. 🔄 Conflits avec les styles WordPress

**Problème :** WordPress ajoute ses propres classes et styles qui peuvent entrer en conflit avec Tailwind.

**Solution :** Le fichier `custom.css` contient des règles `!important` pour forcer les styles Tailwind sur les éléments critiques.

Classes WordPress à surveiller :
- `.admin-bar` (barre d'admin WP)
- `.wp-block-*` (blocs Gutenberg)
- `.site-*` (classes du thème)

#### 3. 📦 Ordre de chargement des fichiers CSS

**Problème :** Si `custom.css` se charge avant Tailwind, les styles ne fonctionnent pas correctement.

**Solution :** Assurer que `custom.css` se charge APRÈS Tailwind via les dépendances :

```php
// Dans functions.php - ligne ~157
wp_enqueue_style('mairie-custom', MAIRIE_THEME_URI . '/assets/css/custom.css', 
    array('tailwind-cdn', 'font-awesome'), // ← Dépendances
    MAIRIE_THEME_VERSION
);
```

**Ordre de chargement correct :**
1. Tailwind CSS (CDN jsDelivr)
2. Font Awesome (CDN)
3. custom.css (fichier local)

#### 4. 🧹 Cache du navigateur

**Problème :** L'ancien CSS est en cache.

**Solution :**
- Chrome/Edge : `Ctrl + Shift + R` (Windows) ou `Cmd + Shift + R` (Mac)
- Firefox : `Ctrl + F5` (Windows) ou `Cmd + Shift + R` (Mac)
- Safari : `Cmd + Option + R`

Ou vider complètement le cache du navigateur.

#### 5. 🔌 Plugins WordPress conflictuels

**Problème :** Certains plugins modifient l'ordre de chargement des CSS ou ajoutent leurs propres styles.

**Plugins à surveiller :**
- Plugins de cache (WP Rocket, W3 Total Cache, etc.)
- Plugins d'optimisation CSS (Autoptimize, etc.)
- Page builders (Elementor, Divi, etc.)

**Solution :**
1. Désactiver temporairement les plugins de cache
2. Tester le site
3. Si ça fonctionne, configurer le plugin pour exclure les CDN Tailwind

**Exclusions à ajouter dans les plugins de cache :**
```
https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css
https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css
```

#### 6. 🌐 CDN bloqué ou inaccessible

**Problème :** Le CDN ne répond pas ou est bloqué par un pare-feu/proxy.

**Solution alternative - Installation locale :**

```bash
# 1. Télécharger Tailwind CSS
cd /path/to/theme/assets/css
curl -O https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css

# 2. Modifier functions.php
wp_enqueue_style('tailwind-cdn', MAIRIE_THEME_URI . '/assets/css/tailwind.min.css', array(), '3.4.1');
```

## 📋 Checklist de vérification

Avant de continuer, vérifiez ces points :

- [ ] **CDN URL correcte** : `https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css`
- [ ] **Ordre de chargement** : Tailwind → Font Awesome → custom.css
- [ ] **Cache vidé** : Hard refresh (Ctrl+Shift+R)
- [ ] **Plugins désactivés** : Tester sans plugins de cache
- [ ] **Console propre** : Pas d'erreurs 404 ou CORS dans la console
- [ ] **custom.css chargé** : Vérifier dans l'onglet Network

## 🔍 Tests de diagnostic

### Test 1 : Vérifier que Tailwind est chargé

Ouvrir la console du navigateur et taper :

```javascript
// Vérifier si Tailwind est dans le DOM
console.log(document.querySelector('link[href*="tailwind"]'));

// Doit afficher : <link rel="stylesheet" id="tailwind-cdn-css" href="https://cdn.jsdelivr.net/...">
```

### Test 2 : Tester une classe Tailwind simple

Dans la console, taper :

```javascript
// Créer un élément de test
const test = document.createElement('div');
test.className = 'bg-red-500 text-white p-4';
test.textContent = 'TEST TAILWIND';
document.body.appendChild(test);

// Si l'élément apparaît avec un fond rouge, Tailwind fonctionne ✅
```

### Test 3 : Inspecter les styles appliqués

1. Clic droit sur un élément (ex: header)
2. "Inspecter l'élément"
3. Onglet "Computed" / "Calculé"
4. Vérifier que les propriétés Tailwind sont présentes (ex: `display: flex` pour `.flex`)

## 🛠️ Solutions rapides

### Solution rapide 1 : Forcer le rechargement des assets

Modifier la version dans `functions.php` :

```php
define('MAIRIE_THEME_VERSION', '1.0.1'); // Augmenter le numéro de version
```

Cela force WordPress à recharger tous les CSS/JS.

### Solution rapide 2 : Ajouter Tailwind inline (temporaire)

Si le CDN ne fonctionne vraiment pas, ajouter dans `header.php` (avant `</head>`) :

```php
<style>
/* Tailwind utilities de base */
.flex { display: flex; }
.hidden { display: none; }
.bg-white { background-color: #fff; }
.text-gray-800 { color: rgb(31 41 55); }
/* etc... */
</style>
```

⚠️ **Ceci est une solution temporaire pour tester uniquement !**

## 📞 Support

Si le problème persiste après avoir suivi ce guide :

1. **Vérifier la version de WordPress :** Minimum 6.0
2. **Vérifier la version de PHP :** Minimum 7.4
3. **Consulter les logs :** `wp-content/debug.log`
4. **Tester avec le thème par défaut** (Twenty Twenty-Three) pour isoler le problème

## ✅ Validation finale

Une fois Tailwind fonctionnel, vous devriez voir :

✅ Header avec fond blanc (`bg-white`)  
✅ Footer avec fond gris foncé (`bg-gray-900`)  
✅ Menu responsive avec classes Tailwind  
✅ Grille footer en colonnes (`grid grid-cols-1 md:grid-cols-3`)  
✅ Espacements cohérents (`px-4`, `py-4`, etc.)  
✅ Hover effects sur les liens (`hover:text-[#000091]`)  

---

**Dernière mise à jour :** 03/10/2025  
**Version du thème :** 1.1.0
