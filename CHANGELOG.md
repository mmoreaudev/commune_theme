# Changelog - Thème Mairie France

## Version 1.1.0 - Refactoring Tailwind CSS (3 Octobre 2025)

### ✨ Nouveautés majeures

#### Migration vers Tailwind CSS
- ✅ **Tailwind CSS 3.4** intégré via CDN
- ✅ **Font Awesome 6.5** pour les icônes (via CDN)
- ✅ Suppression de main.css, responsive.css, accessibility.css volumineux
- ✅ Nouveau fichier `custom.css` minimal (uniquement RGAA et surcharges)
- ✅ Classes Tailwind utilisées dans tout le thème

#### Corrections critiques

**Menu mobile**
- ✅ **CORRIGÉ** : Le menu hamburger fonctionne maintenant correctement
- ✅ Menu slide depuis la droite avec overlay sombre
- ✅ Fermeture en cliquant dehors ou avec Escape
- ✅ Blocage du scroll body quand menu ouvert
- ✅ Animation fluide de l'icône hamburger (transformation en X)
- ✅ Sous-menus déroulants avec boutons toggle
- ✅ Fermeture automatique en mode desktop

**Menus WordPress**
- ✅ **CORRIGÉ** : Aucun menu par défaut affiché
- ✅ Les menus se créent uniquement via `Apparence > Menus`
- ✅ Walker personnalisé avec classes Tailwind (`inc/menu-walker.php`)
- ✅ Support complet des sous-menus multi-niveaux
- ✅ ARIA attributes pour l'accessibilité

#### Header refactorisé
- ✅ Design moderne avec Tailwind
- ✅ Barre supérieure (réseaux sociaux + menu secondaire optionnel)
- ✅ Header principal avec :
  - Logo personnalisé
  - Blason de la commune
  - Nom et slogan
  - Contact rapide (téléphone + email) sur desktop
  - Bouton menu hamburger responsive
- ✅ Header sticky avec `position: sticky`
- ✅ Classes Tailwind : `container mx-auto px-4`, `flex items-center justify-between`, etc.

#### Footer refactorisé
- ✅ Zones de widgets avec grid responsive
- ✅ Section informations (coordonnées, horaires, accès rapides)
- ✅ Footer bottom avec menu légal et copyright
- ✅ Design moderne avec fond sombre
- ✅ Icônes Font Awesome
- ✅ Classes Tailwind : `grid grid-cols-1 md:grid-cols-3`, `bg-gray-900 text-white`, etc.

### 📁 Nouveaux fichiers

```
inc/
└── menu-walker.php          # Walker personnalisé pour menus Tailwind

assets/css/
└── custom.css               # CSS minimal (RGAA + surcharges)

README-TAILWIND.md           # Documentation Tailwind
GUIDE-TAILWIND.md            # Guide d'utilisation Tailwind
CHANGELOG.md                 # Ce fichier
```

### 🔧 Fichiers modifiés

**functions.php**
- Chargement Tailwind CSS via CDN
- Chargement Font Awesome via CDN
- Chargement de custom.css
- Require du nouveau menu-walker.php

**header.php**
- Refactorisation complète avec classes Tailwind
- Barre supérieure responsive
- Header principal avec contact rapide
- Menu conditionnel (affiché seulement si assigné)
- Bouton hamburger avec icône animée

**footer.php**
- Refactorisation avec Tailwind
- Grid responsive pour widgets
- Section informations stylée
- Footer bottom moderne

**assets/js/navigation.js**
- **Script entièrement réécrit**
- Gestion du menu mobile corrigée
- Toggle hamburger fonctionnel
- Overlay et fermeture améliorés
- Support clavier (flèches, Escape)
- Responsive automatique

**assets/css/custom.css**
- Fichier minimal créé
- Variables CSS (couleurs officielles)
- Styles RGAA (skip link, focus, screen reader)
- Menu mobile (animations, overlay)
- Bouton retour en haut
- Utilitaires (container, impression)

### 🎨 Améliorations esthétiques

- ✅ Design moderne et épuré
- ✅ Espacements cohérents avec Tailwind
- ✅ Couleurs officielles respectées (Bleu France, Rouge Marianne)
- ✅ Transitions et animations fluides
- ✅ Ombres et bordures subtiles
- ✅ Typographie améliorée
- ✅ Icônes Font Awesome partout

### ♿ Accessibilité RGAA maintenue

- ✅ Skip link fonctionnel
- ✅ Focus visible (outline 2px)
- ✅ ARIA labels et attributs
- ✅ Navigation au clavier
- ✅ Contraste des couleurs conforme
- ✅ Textes alternatifs requis
- ✅ Support lecteurs d'écran
- ✅ Mode contraste élevé compatible
- ✅ Réduction animations respectée

### 📱 Responsive amélioré

**Mobile (< 768px)**
- Menu hamburger fonctionnel
- Navigation slide-in depuis la droite
- Contact rapide masqué (seulement icône menu)
- Widgets footer en colonne unique

**Tablet (768px - 1023px)**
- Contact rapide masqué
- Menu hamburger conservé
- Widgets footer en 2 colonnes
- Grid adaptée

**Desktop (≥ 1024px)**
- Menu horizontal complet
- Contact rapide visible (téléphone + email)
- Widgets footer en 4 colonnes
- Sous-menus dropdown au hover

### ⚡ Performance

- ✅ **Tailwind CSS 3.4 via CDN** - Cache navigateur, CDN global
- ✅ **Font Awesome via CDN** - Pas de fichier lourd à héberger
- ✅ **custom.css minimal** - Seulement ~300 lignes au lieu de 1500+
- ✅ **JavaScript optimisé** - Code refactorisé et efficace

### 🐛 Bugs corrigés

1. ✅ **Menu mobile ne s'ouvrait pas** - CORRIGÉ
2. ✅ **Menu par défaut affiché sans configuration** - CORRIGÉ
3. ✅ **Sous-menus non fonctionnels** - CORRIGÉS
4. ✅ **Éléments sans mise en forme** - CORRIGÉS
5. ✅ **Icon hamburger statique** - Animation ajoutée
6. ✅ **Scroll non bloqué quand menu ouvert** - CORRIGÉ

### 🔄 Changements breaking

⚠️ **Migration CSS nécessaire si vous aviez personnalisé le thème :**

**Ancien système (main.css)**
```css
.site-header { ... }
.primary-menu { ... }
```

**Nouveau système (Tailwind)**
```html
<header class="bg-white shadow-md sticky top-0">
<nav class="flex space-x-6">
```

### 📚 Documentation ajoutée

1. **README-TAILWIND.md** - Documentation complète du thème avec Tailwind
2. **GUIDE-TAILWIND.md** - Guide pratique d'utilisation de Tailwind
3. **CHANGELOG.md** - Historique des modifications

### 🚀 Migration recommandée

Si vous utilisez la version 1.0.0 :

1. **Sauvegardez votre site** (fichiers + base de données)
2. **Mettez à jour le thème** vers la version 1.1.0
3. **Recréez vos menus** via `Apparence > Menus`
4. **Vérifiez l'affichage** sur mobile, tablet, desktop
5. **Testez la navigation** au clavier et sur mobile

### 🎯 Prochaines étapes (v1.2.0)

- [ ] Ajouter un configurateur Tailwind pour personnaliser les couleurs
- [ ] Créer des templates de blocs Gutenberg avec Tailwind
- [ ] Ajouter un mode sombre (dark mode)
- [ ] Optimiser encore plus la performance
- [ ] Ajouter des animations au scroll

---

## Version 1.0.0 - Release initiale (Date précédente)

### Fonctionnalités initiales

- ✅ Thème WordPress complet pour mairies
- ✅ 10 templates de pages personnalisés
- ✅ 3 custom post types (numéros utiles, services, associations)
- ✅ 6 widgets personnalisés pour sidebar
- ✅ Intégration de 8 plugins recommandés
- ✅ Customizer avec options complètes
- ✅ CSS custom (main.css, responsive.css, accessibility.css)
- ✅ JavaScript (navigation.js, main.js, admin.js, customizer.js, filters.js)
- ✅ Conformité RGAA niveau AA
- ✅ Design Système de l'État français

### Problèmes connus (corrigés en v1.1.0)

- ⚠️ Menu mobile ne fonctionnait pas
- ⚠️ Menu par défaut affiché sans configuration
- ⚠️ CSS volumineux (main.css ~800 lignes)
- ⚠️ Certains éléments sans mise en forme

---

**Développé avec ❤️ pour les communes françaises**
