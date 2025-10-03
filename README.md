Morton Theme — Thème Drupal 11
================================

Thème minimaliste, accessible et moderne pour la commune de Morton (86). Utilise TailwindCSS, Flowbite et Font Awesome via CDN (pas de build, pas de Node/npm).

Installation
------------

1. Déposez le dossier `morton_theme` dans `/themes/` de votre site Drupal.
2. Activez le thème dans l'administration (Apparence).
3. Le thème charge TailwindCSS et Flowbite via CDN. Aucun build n'est nécessaire.

Points d'attention
------------------
- RGAA 4: contrasts, aria-labels, keyboard navigation fournis par défaut dans les templates, mais une validation manuelle complète est recommandée.
- Personnaliser les couleurs via le fichier CSS `css/style.css` ou en modifiant la configuration Tailwind inline si nécessaire.

Fichiers importants
- `morton_theme.info.yml` — définition du thème
- `morton_theme.libraries.yml` — bibliothèques CDN + assets locaux
- `templates/` — templates de pages, nodes et blocs
- `css/style.css` — overrides légers
- `js/script.js` — interactions minimales
