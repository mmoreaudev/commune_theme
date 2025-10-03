# Commune Theme - Thème Drupal pour sites de commune

Thème Drupal moderne, accessible (RGAA) et performant, spécialement conçu pour les sites web de communes. Compatible Drupal 11.x avec support descendant vers Drupal 10.3+.

## 🚀 Fonctionnalités principales

### ✅ Accessibilité (RGAA 4.1)
- Conformité WCAG 2.1 AA
- Navigation clavier complète
- Contrastes respectés (4.5:1 minimum)
- Lecteurs d'écran supportés
- Focus visible et gestion ARIA
- Contrôles de taille de police
- Mode contraste élevé

### 📱 Design responsive (Mobile-first)
- Breakpoints adaptatifs
- Images optimisées et lazy-loading
- Navigation mobile accessible
- Typography scalable
- Performance optimisée

### 🏛️ Types de contenu inclus
- **Actualités** : Articles avec image, résumé, tags
- **Événements** : Dates, lieux, inscriptions
- **Téléchargements** : Documents PDF catégorisés
- **Galeries** : Images et vidéos
- **Alertes** : Notifications temporaires
- **Élus** : Trombinoscope du conseil municipal

### 🧩 Blocs personnalisés
- Carrousel/Slider (Swiper.js)
- Actualités récentes
- Événements à venir
- Téléchargements récents
- Carte interactive (Leaflet.js)
- Alertes dismissibles

## 📦 Installation

### Prérequis
- Drupal 11.x ou 10.3+
- PHP 8.2+ (testé avec 8.3)
- Extensions PHP : gd, curl, mbstring, xml
- Composer (recommandé)

### 1. Installation du thème

```bash
# Copier le dossier du thème dans votre installation Drupal
cp -r commune_theme /path/to/drupal/themes/custom/

# Activer le thème via Drush
drush theme:enable commune_theme
drush config-set system.theme default commune_theme

# Ou via l'interface d'administration
# Administration > Apparence > Installer et définir par défaut
```

### 2. Installation du module d'accompagnement (optionnel mais recommandé)

```bash
# Copier le module
cp -r commune_setup /path/to/drupal/modules/custom/

# Activer le module
drush en commune_setup

# Ou via l'interface
# Administration > Extensions > Activer "Commune Setup"
```

### 3. Configuration initiale

```bash
# Vider les caches
drush cr

# Importer la configuration (si disponible)
drush cim

# Régénérer les permissions et index
drush php-eval "node_access_rebuild();"
```

## 🎨 Configuration du thème

### Paramètres disponibles
1. **Administration > Apparence > Paramètres > Commune Theme**
2. Configurer :
   - Logo et favicon
   - Couleurs principales
   - Typographies
   - Options d'accessibilité
   - Réseaux sociaux

### Régions de thème
```yaml
header: En-tête
primary_menu: Menu principal
breadcrumb: Fil d'Ariane
hero: Zone héro (page d'accueil)
highlighted: Mise en avant
content: Contenu principal
sidebar_first: Barre latérale première
sidebar_second: Barre latérale seconde
footer_first: Pied de page col. 1
footer_second: Pied de page col. 2
footer_third: Pied de page col. 3
footer_fourth: Pied de page col. 4
```

## 📝 Types de contenu

### Actualités
Champs disponibles :
- Titre (obligatoire)
- Résumé/Chapô
- Corps du texte
- Image à la une (Media)
- Date de publication
- Tags/Mots-clés

### Événements
Champs disponibles :
- Titre (obligatoire)
- Description
- Date/heure de début
- Date/heure de fin
- Lieu (texte ou entité adresse)
- Image illustrative
- Lien d'inscription

### Configuration des champs
```bash
# Exporter la configuration des types de contenu
drush config-export

# Réimporter après modification
drush config-import
```

## 🔧 Développement et personnalisation

### Structure des assets
```
assets/
├── css/
│   ├── global.css          # Styles principaux
│   ├── critical.css        # CSS critique (inline)
│   ├── components.css      # Composants
│   ├── forms.css          # Formulaires
│   └── print.css          # Styles impression
├── js/
│   ├── main.js            # JavaScript principal
│   ├── accessibility.js    # Fonctions d'accessibilité
│   ├── swiper.min.js      # Carrousel
│   └── leaflet.js         # Cartographie
└── images/
    └── icons/             # Icônes SVG
```

### Compilation des assets (optionnel)

Si vous souhaitez utiliser TailwindCSS ou un build system :

```json
// package.json
{
  "name": "commune-theme-build",
  "scripts": {
    "build": "npm run build:css && npm run build:js",
    "build:css": "tailwindcss -i ./src/styles.css -o ./assets/css/global.css --minify",
    "build:js": "esbuild src/main.js --bundle --outfile=assets/js/main.min.js",
    "watch": "npm run build:css -- --watch",
    "dev": "npm run watch"
  },
  "devDependencies": {
    "tailwindcss": "^3.3.0",
    "esbuild": "^0.19.0",
    "@tailwindcss/typography": "^0.5.0",
    "@tailwindcss/forms": "^0.5.0"
  }
}
```

```javascript
// tailwind.config.js
module.exports = {
  content: [
    "./templates/**/*.twig",
    "./assets/js/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        'commune-primary': '#1e3a8a',
        'commune-secondary': '#059669'
      },
      fontFamily: {
        'sans': ['system-ui', 'sans-serif'],
        'serif': ['Marianne', 'Georgia', 'serif']
      }
    }
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms')
  ]
}
```

### Templates Twig personnalisés

Créer des templates spécifiques dans `templates/` :
- `page--front.html.twig` : Page d'accueil
- `node--actualites--teaser.html.twig` : Actualité en mode résumé
- `views-view--actualites.html.twig` : Liste des actualités
- `block--commune-alert.html.twig` : Bloc d'alerte

## 📊 Contenu de démonstration

### Import via Drush
```bash
# Créer du contenu de démo
drush php-eval "
\$node_storage = \Drupal::entityTypeManager()->getStorage('node');

// Actualité de démo
\$node = \$node_storage->create([
  'type' => 'actualites',
  'title' => 'Ouverture de la nouvelle médiathèque',
  'field_resume' => [
    'value' => 'La commune inaugure sa nouvelle médiathèque moderne et accessible.',
    'format' => 'basic_html'
  ],
  'body' => [
    'value' => '<p>La nouvelle médiathèque de la commune ouvre ses portes au public...</p>',
    'format' => 'full_html'
  ],
  'status' => 1,
  'promote' => 1
]);
\$node->save();

echo 'Contenu de démo créé avec succès.';
"
```

### Contenu suggéré
1. **3 Actualités** :
   - "Ouverture de la nouvelle médiathèque"
   - "Travaux de voirie rue de la République"
   - "Festivités de fin d'année"

2. **2 Événements** :
   - "Marché de Noël - 15 décembre"
   - "Conseil municipal - 20 décembre"

3. **Documents** :
   - Bulletin municipal (PDF)
   - Délibérations du conseil
   - Guide des démarches

## 🛡️ Sécurité et maintenance

### Bonnes pratiques
```bash
# Mise à jour régulière
composer update drupal/core-recommended --with-dependencies

# Scan de sécurité
drush pm:security

# Sauvegarde avant mise à jour
drush sql:dump --result-file=/backup/db-$(date +%Y%m%d).sql
```

### Headers de sécurité recommandés
Ajouter dans `.htaccess` ou configuration serveur :
```apache
# Headers de sécurité
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-Content-Type-Options "nosniff"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"

# CSP (Content Security Policy) - à adapter
Header always set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' fonts.googleapis.com; font-src 'self' fonts.gstatic.com; img-src 'self' data:; connect-src 'self'"
```

## ♿ Conformité RGAA

### Checklist d'accessibilité
- [x] Images : attributs `alt` obligatoires
- [x] Liens : contexte explicite
- [x] Formulaires : labels associés
- [x] Navigation : structure logique
- [x] Contrastes : ratio 4.5:1 minimum
- [x] Focus : visible et logique
- [x] Clavier : navigation complète
- [x] Lecteurs d'écran : ARIA appropriés

### Tests recommandés
```bash
# Installer axe-core pour les tests automatisés
npm install -g @axe-core/cli

# Tester une page
axe https://votre-site.fr --tags wcag2a,wcag2aa
```

### Outils de validation
- **Wave** : Extension navigateur pour audit automatique
- **Lighthouse** : Audit intégré Chrome DevTools  
- **NVDA/JAWS** : Test avec lecteurs d'écran
- **Colour Contrast Analyser** : Vérification des contrastes

## 🚀 Performance

### Optimisations incluses
- CSS critique inline
- Lazy loading des images
- Compression gzip/brotli
- Préchargement des ressources critiques
- Minification automatique
- Cache navigateur optimisé

### Métriques cibles
- **First Contentful Paint** : < 1.5s
- **Largest Contentful Paint** : < 2.5s
- **Cumulative Layout Shift** : < 0.1
- **Time to Interactive** : < 3.5s

## 🌐 Hébergement recommandé

### Serveur minimal
- **PHP** : 8.2+ avec OPcache
- **MySQL/MariaDB** : 8.0+ / 10.3+
- **RAM** : 512 Mo minimum, 2 Go recommandé
- **SSD** : Recommandé pour les performances

### Configuration optimale
```php
// settings.local.php
$config['system.performance']['cache']['page']['max_age'] = 3600;
$config['system.performance']['css']['preprocess'] = TRUE;
$config['system.performance']['js']['preprocess'] = TRUE;

// Optimisations base de données
$databases['default']['default']['init_commands']['isolation'] = "SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED";
```

## 📞 Support et contribution

### Signaler un problème
1. Vérifier les [issues existantes](https://github.com/votre-repo/commune-theme/issues)
2. Créer un nouveau rapport avec :
   - Version de Drupal
   - Version PHP
   - Description du problème
   - Étapes pour reproduire

### Contribuer
1. Fork du projet
2. Créer une branche feature (`git checkout -b feature/amelioration`)
3. Commit (`git commit -m 'Ajout nouvelle fonctionnalité'`)
4. Push (`git push origin feature/amelioration`)
5. Créer une Pull Request

## 📄 Licence

Ce thème est distribué sous licence GPL-2.0+, compatible avec Drupal.

## 📚 Ressources complémentaires

- [Documentation Drupal Theming](https://www.drupal.org/docs/theming-drupal)
- [RGAA 4.1 - Référentiel officiel](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/)
- [Twig Documentation](https://twig.symfony.com/doc/3.x/)
- [Swiper.js Documentation](https://swiperjs.com/)
- [Leaflet.js Documentation](https://leafletjs.com/)

---

**Version** : 11.1.0  
**Compatibilité** : Drupal 11.x, PHP 8.2+  
**Dernière mise à jour** : Octobre 2025