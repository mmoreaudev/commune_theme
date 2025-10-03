# Thème Commune CDN pour Drupal 11

Un thème moderne et accessible pour les sites de communes françaises, utilisant uniquement des CDN (pas de Node.js/npm requis).

## Fonctionnalités

- ✅ **CDN uniquement** : Tailwind CSS et Alpine.js via CDN
- ✅ **Compatible Drupal 11** : Testé et optimisé
- ✅ **Responsive** : Design mobile-first
- ✅ **Accessible** : Liens d'évitement, navigation clavier
- ✅ **Templates spécialisés** : Articles, événements, services

## Installation

1. Télécharger le thème dans `/themes/custom/commune_theme_cdn/`
2. Activer le thème dans l'interface d'administration Drupal
3. Aucune compilation requise !

## Structure

```
commune_theme_cdn/
├── commune_theme_cdn.info.yml     # Configuration du thème
├── commune_theme_cdn.libraries.yml # Librairies CSS/JS
├── commune_theme_cdn.theme         # Fonctions PHP
├── assets/
│   ├── css/custom.css              # Styles personnalisés
│   └── js/custom.js                # JavaScript personnalisé
└── templates/                      # Templates Twig
    ├── page--cdn.html.twig         # Template principal
    ├── node--article.html.twig     # Template articles
    ├── node--event.html.twig       # Template événements
    ├── block.html.twig             # Template blocs
    ├── menu.html.twig              # Template menus
    ├── breadcrumb.html.twig        # Fil d'Ariane
    ├── field.html.twig             # Template champs
    └── region.html.twig            # Template régions
```

## CDN Utilisés

- **Tailwind CSS** : https://cdn.tailwindcss.com
- **Alpine.js** : https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js
- **Google Fonts** : https://fonts.googleapis.com (Inter)

## Utilisation

### Personnalisation des couleurs

Modifier la configuration Tailwind dans `page--cdn.html.twig` :

```javascript
tailwind.config = {
  theme: {
    extend: {
      colors: {
        'commune': {
          // Vos couleurs ici
        }
      }
    }
  }
}
```

### Composants Alpine.js

Le thème inclut des composants réutilisables :

```html
<!-- Dropdown -->
<div x-data="dropdown()">
  <button @click="toggle()">Menu</button>
  <div x-show="open">Contenu</div>
</div>

<!-- Modal -->
<div x-data="modal()">
  <button @click="show()">Ouvrir</button>
  <div x-show="open">Modal</div>
</div>
```

## Support

Ce thème est conçu pour les communes françaises avec :
- Templates pour actualités et événements
- Navigation accessible
- Design institutionnel
- Compatibilité mobile

## Licence

GPL-2.0+