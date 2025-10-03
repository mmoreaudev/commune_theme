# Thème WordPress - Mairie France

Thème WordPress professionnel et accessible pour sites de mairies et communes françaises.

## 📋 Caractéristiques

- **Design moderne et responsive** - Mobile-first, optimisé pour tous les écrans
- **Conforme RGAA** - Accessibilité niveau AA
- **Système de Design de l'État** - Respect de la charte graphique officielle
- **Performance optimisée** - Code léger et rapide
- **Multilingue ready** - Compatible avec WPML et Polylang
- **SEO-friendly** - Balisage sémantique et Schema.org

## 🎨 Design

- **Couleurs officielles** : Bleu France (#000091) et Rouge Marianne (#E1000F)
- **Typographies** : Marianne (titres) et Spectral (corps de texte)
- **Responsive** : Points de rupture à 768px, 1024px et 1440px
- **Accessibilité** : Contraste minimum 4.5:1, navigation au clavier, lecteurs d'écran

## 🔌 Plugins intégrés nativement

Le thème est conçu pour fonctionner avec ces plugins recommandés :

1. **The Events Calendar** - Gestion des événements municipaux
2. **Our Team Members** - Présentation du conseil municipal
3. **Download Manager** - Publications et documents à télécharger
4. **TablePress** - Tableaux pour tarifs et horaires
5. **Accordion** - Accordéons pour FAQ et infos pratiques
6. **Contact Form 7** - Formulaire de contact
7. **UpdraftPlus** - Sauvegardes automatiques
8. **Wordfence** - Sécurité du site

## 📦 Installation

### Prérequis

- WordPress 6.0 ou supérieur
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur

### Étapes d'installation

1. **Télécharger le thème**
   ```
   Téléchargez le fichier ZIP du thème
   ```

2. **Installer via l'admin WordPress**
   - Allez dans `Apparence > Thèmes`
   - Cliquez sur `Ajouter`
   - Cliquez sur `Téléverser un thème`
   - Sélectionnez le fichier ZIP
   - Cliquez sur `Installer`
   - Activez le thème

3. **Installer les plugins recommandés**
   - Une notification apparaîtra pour installer les plugins
   - Cliquez sur "Commencer l'installation des plugins"
   - Installez et activez tous les plugins recommandés

4. **Importer le contenu de démo** (optionnel)
   - Allez dans `Outils > Importer`
   - Importez le fichier `demo-content.xml`

## ⚙️ Configuration

### 1. Personnalisation (Customizer)

Allez dans `Apparence > Personnaliser` pour configurer :

#### Identité de la commune
- Nom de la commune
- Slogan
- Logo
- Blason/Armoiries

#### Coordonnées
- Adresse complète
- Téléphone
- Email
- Horaires d'ouverture
- URL Google Maps

#### Réseaux sociaux
- Facebook
- Twitter
- Instagram
- YouTube
- LinkedIn

#### Couleurs
- Couleur primaire
- Couleur secondaire
- Couleur des liens
- Couleur du footer

#### Page d'accueil
- Image hero
- Titre hero
- Texte hero
- Texte bouton CTA
- Lien bouton CTA

#### Footer
- Texte copyright personnalisé

### 2. Menus

Configurez vos menus dans `Apparence > Menus` :

- **Menu principal** - Navigation principale du site
- **Menu footer** - Liens dans le footer
- **Menu secondaire** - Liens rapides (optionnel)

### 3. Widgets

Le thème inclut 6 widgets personnalisés pour la sidebar :

1. **Liens Pratiques** - Liste de liens importants
2. **Numéros d'Urgence** - 15, 17, 18, 112 avec boutons d'appel
3. **Horaires Mairie** - Affichage des horaires avec statut ouvert/fermé
4. **Actualité à la Une** - Mise en avant d'un article
5. **Prochain Événement** - Affichage du prochain événement
6. **Accès Rapides** - Boutons vers pages importantes

Configurez-les dans `Apparence > Widgets`.

### 4. Pages

Le thème inclut 10 modèles de pages :

1. **Page d'accueil** (`template-home.php`)
2. **Actualités** (`template-actualites.php`)
3. **Conseil Municipal** (`template-conseil-municipal.php`)
4. **Contact** (`template-contact.php`)
5. **Publications** (`template-publications.php`)
6. **Événements** (`template-evenements.php`)
7. **Associations** (`template-associations.php`)
8. **Infos Pratiques** (`template-infos-pratiques.php`)
9. **Services** (`template-services.php`)
10. **Numéros Utiles** (`template-numeros-utiles.php`)

Pour utiliser un modèle :
- Créez une nouvelle page
- Dans l'éditeur, sélectionnez le modèle dans `Attributs de page > Modèle`

### 5. Types de contenu personnalisés

#### Numéros Utiles

Créez un annuaire téléphonique complet :

1. Allez dans `Numéros Utiles > Ajouter`
2. Remplissez les champs :
   - Nom du service (requis)
   - Téléphone (requis)
   - Email
   - Adresse
   - Horaires
   - Site web
3. Sélectionnez une catégorie
4. Publiez

Les numéros s'afficheront automatiquement sur la page "Numéros Utiles" avec recherche et filtres.

#### Services Municipaux

Présentez les services de la mairie :

1. Allez dans `Services > Ajouter`
2. Remplissez :
   - Nom du service
   - Description
   - Responsable
   - Contact
   - Horaires
3. Ajoutez une icône ou image
4. Publiez

#### Associations

Répertoire des associations locales :

1. Allez dans `Associations > Ajouter`
2. Complétez :
   - Nom de l'association
   - Description
   - Président
   - Contact
   - Site web
3. Catégorisez (sport, culture, etc.)
4. Publiez

## 📁 Structure des fichiers

```
mairie-france/
├── assets/
│   ├── css/
│   │   ├── main.css              # Styles principaux
│   │   ├── responsive.css        # Styles responsive
│   │   ├── accessibility.css     # Styles RGAA
│   │   └── admin.css            # Styles admin
│   └── js/
│       ├── main.js              # Scripts principaux
│       ├── navigation.js        # Navigation et menu
│       ├── filters.js           # Filtres AJAX
│       ├── admin.js             # Scripts admin
│       └── customizer.js        # Aperçu live Customizer
├── inc/
│   ├── custom-post-types.php    # CPT et taxonomies
│   ├── custom-fields.php        # Metaboxes
│   ├── widgets.php              # Widgets personnalisés
│   ├── customizer.php           # Options Customizer
│   ├── plugins-integration.php  # Intégration plugins
│   ├── navigation.php           # Menus et navigation
│   └── accessibility.php        # Fonctions RGAA
├── parts/
│   ├── content-article.php      # Carte article
│   ├── content-event.php        # Carte événement
│   ├── hero-section.php         # Section hero
│   └── breadcrumb.php           # Fil d'Ariane
├── templates/
│   ├── template-home.php
│   ├── template-actualites.php
│   ├── template-conseil-municipal.php
│   ├── template-contact.php
│   ├── template-publications.php
│   ├── template-evenements.php
│   ├── template-associations.php
│   ├── template-infos-pratiques.php
│   ├── template-services.php
│   └── template-numeros-utiles.php
├── style.css                     # Header du thème
├── functions.php                 # Configuration principale
├── header.php
├── footer.php
├── sidebar.php
├── index.php
├── page.php
├── single.php
├── archive.php
├── 404.php
├── screenshot.png               # Capture d'écran
└── README.md
```

## 🎯 Fonctionnalités principales

### Navigation

- Menu responsive avec toggle mobile
- Sous-menus déroulants
- Navigation au clavier (flèches, Tab, Escape)
- Skip links pour l'accessibilité

### Recherche

- Recherche en temps réel sur numéros utiles
- Filtres par catégorie
- Tri alphabétique et par date

### Événements

- Intégration The Events Calendar
- Affichage calendrier et liste
- Filtres par catégorie et date
- Widget "Prochain événement"

### Publications

- Onglets (Bulletins, Magazines, Délibérations)
- Téléchargement de documents
- Intégration Download Manager

### Accessibilité RGAA

- Contraste des couleurs conforme
- Navigation au clavier complète
- ARIA labels et rôles
- Lecteurs d'écran supportés
- Focus visible
- Textes alternatifs requis

### Performance

- CSS et JS minifiés en production
- Lazy loading des images
- Optimisation des requêtes
- Cache navigateur

## 🔧 Personnalisation avancée

### Fichier functions.php du thème enfant

```php
<?php
// Charger le style parent
add_action('wp_enqueue_scripts', 'mairie_child_enqueue_styles');
function mairie_child_enqueue_styles() {
    wp_enqueue_style('mairie-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('mairie-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('mairie-parent-style')
    );
}

// Vos personnalisations ici
```

### Hooks disponibles

- `mairie_before_header` - Avant le header
- `mairie_after_header` - Après le header
- `mairie_before_content` - Avant le contenu
- `mairie_after_content` - Après le contenu
- `mairie_before_footer` - Avant le footer
- `mairie_after_footer` - Après le footer

### Filtres disponibles

- `mairie_excerpt_length` - Longueur des extraits
- `mairie_excerpt_more` - Texte "lire la suite"
- `mairie_breadcrumb_separator` - Séparateur fil d'Ariane

## 🐛 Dépannage

### Le thème ne s'active pas

- Vérifiez que vous avez PHP 8.0+ et WordPress 6.0+
- Désactivez tous les plugins et réessayez
- Vérifiez les logs d'erreur PHP

### Les styles ne s'appliquent pas

- Videz le cache du navigateur (Ctrl+F5)
- Videz le cache WordPress si vous utilisez un plugin de cache
- Vérifiez que les fichiers CSS sont bien chargés (F12 > Network)

### Les widgets n'apparaissent pas

- Allez dans `Apparence > Widgets`
- Vérifiez que vous avez bien ajouté des widgets à "Sidebar principale"

### Les numéros utiles ne s'affichent pas

- Vérifiez que vous avez créé au moins un numéro utile
- Vérifiez que la page utilise le modèle "Numéros Utiles"
- Vérifiez que les numéros sont bien publiés (pas en brouillon)

## 📝 Support et documentation

- **Documentation complète** : Voir `docs/` dans le thème
- **Support** : Créez un ticket sur le dépôt GitHub
- **Mises à jour** : Vérifiez régulièrement les nouvelles versions

## 🔐 Sécurité

- Code validé selon WordPress Coding Standards
- Échappement de toutes les sorties
- Nonces pour les formulaires
- Sanitization des entrées
- Compatible avec Wordfence

## 📄 Licence

Ce thème est distribué sous licence GPL v2 ou ultérieure.

## 👥 Crédits

- **Développeur** : Votre nom
- **Design** : Système de Design de l'État français
- **Typographies** : Marianne et Spectral (SIL Open Font License)
- **Icônes** : Font Awesome

## 🚀 Mises à jour

### Version 1.0.0 - Date actuelle

- Release initiale
- Toutes les fonctionnalités de base
- Conformité RGAA
- Intégration des 8 plugins

---

**Made with ❤️ for French municipalities**
