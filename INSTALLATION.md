# 🏛️ Commune Theme - Guide d'Installation et Configuration

## Vue d'ensemble

Le **Commune Theme** est un thème Drupal moderne, responsive et accessible, spécialement conçu pour les sites de communes. Il respecte les standards RGAA et offre une expérience utilisateur optimale sur tous les appareils.

## 🎨 Fonctionnalités Principales

### Design et Interface
- ✅ **Design moderne et épuré** avec une identité visuelle institutionnelle
- ✅ **Responsive design** adaptatif pour tous les écrans
- ✅ **Header moderne** avec logo, navigation et outils d'accessibilité
- ✅ **Hero section** dynamique pour la page d'accueil
- ✅ **Système de cartes** pour articles, événements et services
- ✅ **Sidebar informative** avec informations pratiques
- ✅ **Footer structuré** avec liens institutionnels

### Accessibilité et Performance
- ✅ **Conformité RGAA** (Référentiel Général d'Amélioration de l'Accessibilité)
- ✅ **Navigation clavier** complète
- ✅ **Contrôles de taille de police** et contraste élevé
- ✅ **Images lazy loading** pour de meilleures performances
- ✅ **CSS critique** pour un rendu rapide
- ✅ **Animations respectueuses** des préférences utilisateur

### Fonctionnalités Avancées
- ✅ **Menu mobile** avec navigation tactile optimisée
- ✅ **Recherche intégrée** avec suggestions
- ✅ **Widgets sidebar** (horaires, contact, météo, actualités)
- ✅ **Partage social** et boutons d'interaction
- ✅ **Calendrier d'événements** avec export ICS/Google Calendar
- ✅ **SEO optimisé** avec structured data

## 📋 Prérequis

- **Drupal** 10.3+ ou 11.x
- **PHP** 8.2+
- **Node.js** 18+ (pour la compilation des assets)
- **Composer** pour la gestion des dépendances

## 🚀 Installation

### 1. Installation du thème

```bash
# Télécharger le thème dans le dossier themes/custom
cd /path/to/your/drupal/site
git clone [repository-url] web/themes/custom/commune_theme
```

### 2. Installation des dépendances

```bash
cd web/themes/custom/commune_theme
npm install
```

### 3. Compilation des assets

```bash
# Développement avec watch
npm run dev

# Production optimisée
npm run prod
```

### 4. Activation du thème

```bash
# Via Drush
drush theme:enable commune_theme
drush config:set system.theme default commune_theme

# Ou via l'interface d'administration
# Administration > Appearance > Install and set as default
```

## 🔧 Configuration Requise

### Types de contenu recommandés

#### Actualités
```yaml
Nom machine: actualites
Champs:
  - field_image_une (Image)
  - field_category (Taxonomy term - Catégories)
  - field_author (Text)
  - field_tags (Taxonomy term - Tags)
  - body (Text long avec résumé)
```

#### Événements
```yaml
Nom machine: evenements
Champs:
  - field_image (Image)
  - field_date_event (Date/heure)
  - field_lieu (Text)
  - field_price (Text)
  - field_organizer (Text)
  - field_registration_link (Link)
  - body (Text long)
```

### Régions de thème

Le thème définit les régions suivantes :

- `header_top` - Bandeau supérieur
- `header` - En-tête principal
- `logo` - Zone logo personnalisée
- `primary_menu` - Menu principal
- `mobile_menu` - Menu mobile
- `breadcrumb` - Fil d'Ariane
- `hero` - Zone hero (page d'accueil)
- `content` - Contenu principal
- `sidebar_first` - Informations pratiques
- `news` - Actualités (page d'accueil)
- `events` - Événements (page d'accueil)
- `services` - Services en ligne
- `footer_first` à `footer_fourth` - Colonnes du footer
- `footer_bottom` - Pied de page légal

### Configuration des blocs recommandée

#### Sidebar "Informations pratiques"
- **Horaires d'ouverture** (bloc personnalisé HTML)
- **Contact rapide** (bloc personnalisé avec tel/email)
- **Liens utiles** (menu bloc)
- **Actualités récentes** (vue personnalisée)

#### Page d'accueil
- **Hero section** (bloc personnalisé ou vue)
- **Actualités** (vue avec format card)
- **Événements à venir** (vue avec format event)
- **Services en ligne** (blocs personnalisés)

## 🎨 Personnalisation

### Variables CSS

Le thème utilise des propriétés CSS personnalisées facilement modifiables :

```css
:root {
  /* Couleurs institutionnelles */
  --color-primary: #1e3a8a;      /* Bleu principal */
  --color-secondary: #059669;     /* Vert nature */
  --color-accent: #dc2626;        /* Rouge urgent */
  
  /* Typographie */
  --font-family-heading: 'Marianne', Georgia, serif;
  --font-family-base: system-ui, sans-serif;
  
  /* Espacements */
  --spacing-xs: 0.25rem;
  --spacing-sm: 0.5rem;
  --spacing-md: 1rem;
  --spacing-lg: 1.5rem;
  --spacing-xl: 2rem;
  
  /* Layout */
  --container-max-width: 1200px;
  --sidebar-width: 320px;
}
```

### Logo et identité

1. Ajouter votre logo dans `/themes/custom/commune_theme/logo.svg`
2. Configurer via : Administration > Configuration > System > Site information
3. Ou utiliser la région `logo` pour un contrôle complet

### Couleurs de marque

Modifier les couleurs dans `assets/css/global.css` :

```css
:root {
  --color-primary: #VOTRE_COULEUR;        /* Couleur principale */
  --color-primary-dark: #VOTRE_COULEUR;   /* Variante foncée */
  --color-primary-light: #VOTRE_COULEUR;  /* Variante claire */
}
```

### Polices personnalisées

Pour utiliser des polices spécifiques (ex: Marianne pour l'institutionnel) :

1. Ajouter les fichiers de police dans `assets/fonts/`
2. Déclarer les @font-face dans `assets/css/global.css`
3. Mettre à jour les variables CSS

## 📱 Extensions Drupal Recommandées

### Essentielles
- **Admin Toolbar** - Navigation administrative améliorée
- **Metatag** - Gestion avancée des méta-données SEO
- **Pathauto** - URLs automatiques et optimisées
- **Redirect** - Gestion des redirections

### Contenu
- **Paragraphs** - Création de contenu modulaire
- **Field Group** - Organisation des champs de contenu
- **Entity Reference Revisions** - Références d'entités versionnées
- **Inline Entity Form** - Édition inline d'entités

### Médias et Images
- **Media** (core) - Gestion centralisée des médias
- **Image Effects** - Effets avancés sur les images
- **Focal Point** - Recadrage intelligent des images
- **WebP** - Conversion automatique en format WebP

### SEO et Performance
- **Schema.org Metatag** - Données structurées automatiques
- **XML Sitemap** - Génération de sitemap
- **Page Cache** - Mise en cache des pages
- **BigPipe** - Rendu progressif des pages

### Accessibilité
- **Block ARIA Landmark Roles** - Rôles ARIA automatiques
- **CKEditor Accessibility Checker** - Vérification accessibilité éditeur
- **Flysystem** - Gestion avancée des fichiers

### Fonctionnalités Avancées
- **Views Bulk Operations** - Actions en lot sur les contenus
- **Scheduler** - Publication/dépublication programmée
- **Webform** - Formulaires avancés
- **Search API** - Recherche performante
- **Geocoder** - Géolocalisation des contenus

## 🔒 Configuration Sécurité et RGPD

### Sécurité
```bash
# Installation des modules de sécurité
composer require drupal/security_review
composer require drupal/password_policy
composer require drupal/automated_logout
```

### RGPD et Cookies
```bash
# Gestion des cookies et consentement
composer require drupal/eu_cookie_compliance
composer require drupal/gdpr
```

### Configuration recommandée
- Activer HTTPS obligatoire
- Configurer les headers de sécurité
- Mettre en place une politique de mots de passe
- Limiter les tentatives de connexion

## 📊 Analytics et Suivi

### Google Analytics 4
```bash
composer require drupal/google_analytics
```

Configuration :
- Administration > Configuration > System > Google Analytics
- Respecter les normes RGPD
- Configurer l'anonymisation IP

### Matomo (alternative respectueuse)
```bash
composer require drupal/matomo
```

## 🛠️ Maintenance et Mises à Jour

### Scripts NPM disponibles

```bash
npm run build          # Construction complète
npm run dev             # Mode développement avec watch
npm run prod            # Build production optimisé
npm run lint:css        # Vérification CSS
npm run lint:js         # Vérification JavaScript
npm run test:a11y      # Tests d'accessibilité
npm run optimize:images # Optimisation des images
```

### Mises à jour Drupal

```bash
# Sauvegarde base de données
drush sql:dump --result-file=backup.sql

# Mise à jour via Composer
composer update drupal/core-* --with-dependencies

# Mise à jour base de données
drush updatedb

# Rebuild cache
drush cache:rebuild
```

## 🐛 Résolution de Problèmes

### CSS/JS non chargés
```bash
# Vider tous les caches
drush cache:rebuild

# Recompiler les assets
npm run build
```

### Problèmes de permissions
```bash
# Réparer les permissions Drupal
sudo chown -R www-data:www-data /path/to/drupal
sudo find /path/to/drupal -type d -exec chmod 755 {} \;
sudo find /path/to/drupal -type f -exec chmod 644 {} \;
```

### Debugging
```php
// Activer le mode debug dans settings.php
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
$config['system.logging']['error_level'] = 'verbose';
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;
```

## 📞 Support et Documentation

### Ressources
- **Documentation Drupal** : https://www.drupal.org/docs
- **RGAA 4.1** : https://accessibilite.numerique.gouv.fr/
- **Guidelines design** : Inclus dans `/docs/design-guidelines.md`
- **Tests accessibilité** : Scripts automatisés avec Pa11y

### Contribution
- Signaler les bugs via les issues GitHub
- Proposer des améliorations via Pull Requests
- Suivre les standards de codage Drupal

---

**Version** : 11.1.0  
**Compatibilité** : Drupal 10.3+ / 11.x  
**Dernière mise à jour** : Octobre 2025