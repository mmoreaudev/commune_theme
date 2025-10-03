# Thème WordPress - Mairie France (Version Tailwind CSS)

Thème WordPress professionnel et accessible pour sites de mairies et communes françaises, entièrement stylé avec **Tailwind CSS via CDN**.

## 🎨 Mise à jour majeure : Tailwind CSS

Le thème utilise maintenant **Tailwind CSS 3.4** via CDN pour une gestion moderne et légère du CSS :

- ✅ **Performance optimale** - CSS via CDN, cache navigateur
- ✅ **Classes utilitaires** - Développement rapide et maintenable
- ✅ **Responsive natif** - Mobile-first avec Tailwind
- ✅ **Fichier custom.css minimal** - Uniquement pour RGAA et surcharges spécifiques
- ✅ **Menu mobile corrigé** - Fonctionne parfaitement sur tous les écrans
- ✅ **Aucun menu par défaut** - Les menus se créent uniquement via WordPress

## 📋 Caractéristiques

- **Design moderne** - Utilise Tailwind CSS + Font Awesome pour les icônes
- **100% Responsive** - Mobile-first avec breakpoints adaptés
- **Conforme RGAA** - Accessibilité niveau AA maintenue
- **Menu dynamique** - Créez vos menus via WordPress (Apparence > Menus)
- **Performance optimisée** - Code léger, CDN, chargement rapide
- **SEO-friendly** - Balisage sémantique HTML5

## 🎨 Couleurs officielles

- **Bleu France** : `#000091` (variable CSS : `--color-primary`)
- **Rouge Marianne** : `#E1000F` (variable CSS : `--color-secondary`)
- Classes Tailwind custom : `text-[#000091]`, `bg-[#E1000F]`

## 📦 Installation

### Prérequis

- WordPress 6.0 ou supérieur
- PHP 8.0 ou supérieur
- Connexion Internet (pour charger Tailwind CSS et Font Awesome via CDN)

### Installation rapide

1. **Téléchargez le thème**
2. **Allez dans** `Apparence > Thèmes > Ajouter`
3. **Téléversez le ZIP** et activez le thème
4. **Installez les plugins recommandés** (notification automatique)

## ⚙️ Configuration du menu

**IMPORTANT** : Le thème n'affiche AUCUN menu par défaut. Vous devez créer vos menus :

### Créer le menu principal

1. Allez dans `Apparence > Menus`
2. Créez un nouveau menu (ex: "Menu Principal")
3. Ajoutez vos pages au menu
4. Cochez "Menu Principal" dans "Réglages du menu"
5. Cliquez sur "Enregistrer le menu"

### Emplacements de menus disponibles

- **Menu Principal** (`primary`) - Navigation principale (header)
- **Barre Supérieure** (`top-bar`) - Petite barre en haut (optionnel)
- **Menu Pied de Page** (`footer`) - Dans le footer (optionnel)
- **Menu Mentions Légales** (`legal`) - Liens légaux en bas du footer (optionnel)

## 🔧 Personnalisation (Customizer)

Allez dans `Apparence > Personnaliser` :

### Identité du site
- Logo personnalisé
- Nom de la commune
- Slogan
- Blason/Armoiries

### Contact
- Adresse complète
- Téléphone (apparaît dans le header desktop)
- Email (apparaît dans le header desktop)
- Horaires d'ouverture

### Réseaux sociaux
- Facebook, Twitter, Instagram, YouTube, LinkedIn
- Affichés dans la barre supérieure

### Couleurs
Vous pouvez personnaliser les couleurs via le Customizer (optionnel)

## 🎯 Menu mobile

Le menu mobile a été **entièrement corrigé** :

### Fonctionnalités
- ✅ **Toggle hamburger** fonctionnel
- ✅ **Overlay sombre** derrière le menu
- ✅ **Fermeture** en cliquant dehors ou sur Escape
- ✅ **Sous-menus déroulants** avec boutons toggle
- ✅ **Blocage du scroll** quand le menu est ouvert
- ✅ **Animation fluide** d'ouverture/fermeture
- ✅ **Responsive automatique** - se ferme automatiquement en mode desktop

### Icône hamburger animée
L'icône du bouton menu s'anime en "X" quand le menu est ouvert

## 📁 Structure CSS

```
assets/css/
├── custom.css           # CSS personnalisé minimal (RGAA + surcharges)
```

### Qu'est-ce qui est dans custom.css ?

- Variables CSS (couleurs officielles)
- **Accessibilité RGAA** (skip links, focus, lecteurs d'écran)
- **Menu mobile** (animations, overlay)
- **Bouton retour en haut**
- **Utilitaires** (conteneur, impression)

### Tailwind CSS (via CDN)

Toutes les classes Tailwind sont disponibles :
- `flex`, `grid`, `space-x-4`, etc.
- `text-gray-800`, `bg-white`, `hover:text-blue-500`
- `md:`, `lg:` pour le responsive
- Et bien plus...

## 🔌 Plugins recommandés

1. **The Events Calendar** - Événements
2. **Our Team Members** - Conseil municipal
3. **Download Manager** - Documents
4. **TablePress** - Tableaux
5. **Accordion** - Accordéons/FAQ
6. **Contact Form 7** - Formulaires
7. **UpdraftPlus** - Sauvegardes
8. **Wordfence** - Sécurité

## 📝 Templates de pages

10 modèles de pages personnalisés :

1. **Page d'accueil** - Hero + actualités + événements
2. **Actualités** - Archive des articles
3. **Conseil Municipal** - Membres du conseil
4. **Contact** - Formulaire + coordonnées
5. **Publications** - Documents municipaux
6. **Événements** - Calendrier
7. **Associations** - Annuaire
8. **Infos Pratiques** - FAQ et infos
9. **Services** - Services municipaux
10. **Numéros Utiles** - Annuaire téléphonique avec recherche

## 🎨 Classe Tailwind utiles

### Navigation
```html
<nav class="flex space-x-4">
  <a class="hover:text-[#000091] transition-colors">Lien</a>
</nav>
```

### Boutons
```html
<button class="bg-[#000091] text-white px-6 py-3 rounded-lg hover:bg-[#E1000F] transition-colors">
  Bouton
</button>
```

### Grilles
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <!-- Contenu -->
</div>
```

## 🔐 Accessibilité RGAA

- ✅ **Skip link** fonctionnel
- ✅ **Focus visible** sur tous les éléments interactifs
- ✅ **ARIA labels** sur navigation et boutons
- ✅ **Contraste des couleurs** conforme (4.5:1 minimum)
- ✅ **Navigation au clavier** complète
- ✅ **Lecteurs d'écran** supportés
- ✅ **Mode contraste élevé** compatible
- ✅ **Réduction animations** respectée

## 🐛 Corrections apportées

### Menu mobile
- ✅ Corrigé : le menu s'ouvre maintenant correctement
- ✅ Ajout de l'overlay sombre
- ✅ Animation fluide
- ✅ Fermeture automatique en mode desktop

### Menus WordPress
- ✅ Aucun menu par défaut affiché
- ✅ Les menus se créent uniquement via l'admin WordPress
- ✅ Walker personnalisé avec classes Tailwind
- ✅ Sous-menus fonctionnels

### Esthétique
- ✅ Design moderne avec Tailwind
- ✅ Header avec logo, contact rapide, menu hamburger
- ✅ Footer avec widgets, infos, copyright
- ✅ Tous les éléments stylés correctement

## 📚 Documentation

- **CSS** : Utilisez les classes Tailwind directement
- **Personnalisation** : Éditez `custom.css` pour vos besoins spécifiques
- **Menu Walker** : `inc/menu-walker.php` pour modifier la structure du menu

## 🚀 Performance

- **Tailwind CSS** : Chargé via CDN (cache navigateur)
- **Font Awesome** : Chargé via CDN
- **JavaScript** : Minifié, chargé en footer
- **Images** : Lazy loading natif

## 📄 Licence

GPL v2 ou ultérieure

## 👥 Crédits

- **Design** : Système de Design de l'État français
- **CSS Framework** : Tailwind CSS 3.4
- **Icônes** : Font Awesome 6.5
- **Développeur** : mmoreaudev

---

**Made with ❤️ for French municipalities**
