# Guide d'utilisation de Tailwind CSS dans le thème Mairie France

## 🎯 Pourquoi Tailwind CSS ?

Le thème utilise maintenant **Tailwind CSS via CDN** pour plusieurs raisons :

1. **Légèreté** - Pas de compilation nécessaire, CSS chargé via CDN
2. **Rapidité de développement** - Classes utilitaires prêtes à l'emploi
3. **Maintenance facile** - Code lisible et maintenable
4. **Performance** - Cache navigateur, chargement rapide
5. **Responsive natif** - Mobile-first intégré

## 📝 Classes Tailwind courantes dans le thème

### Layout & Spacing

```html
<!-- Conteneur -->
<div class="container mx-auto px-4">

<!-- Flexbox -->
<div class="flex items-center justify-between">
<div class="flex flex-col space-y-4">

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- Spacing -->
<div class="p-4">     <!-- padding -->
<div class="m-4">     <!-- margin -->
<div class="mt-8">    <!-- margin-top -->
<div class="py-6">    <!-- padding vertical -->
<div class="space-y-4"> <!-- espace entre enfants -->
```

### Couleurs du thème

```html
<!-- Bleu France (#000091) -->
<div class="bg-[#000091] text-white">
<a class="text-[#000091] hover:text-[#E1000F]">

<!-- Rouge Marianne (#E1000F) -->
<button class="bg-[#E1000F] text-white">

<!-- Couleurs grises -->
<div class="bg-gray-100 text-gray-800">
<div class="bg-gray-900 text-white">
```

### Typographie

```html
<!-- Tailles -->
<h1 class="text-3xl font-bold">     <!-- 30px -->
<h2 class="text-2xl font-semibold"> <!-- 24px -->
<p class="text-base">                <!-- 16px -->
<small class="text-sm">              <!-- 14px -->
<span class="text-xs">               <!-- 12px -->

<!-- Poids -->
<span class="font-light">   <!-- 300 -->
<span class="font-normal">  <!-- 400 -->
<span class="font-medium">  <!-- 500 -->
<span class="font-semibold"><!-- 600 -->
<span class="font-bold">    <!-- 700 -->

<!-- Alignement -->
<p class="text-left">
<p class="text-center">
<p class="text-right">
```

### Responsive Design

```html
<!-- Mobile-first : par défaut mobile, puis écrans plus grands -->

<!-- Mobile -->
<div class="block">

<!-- Tablet et plus (≥768px) -->
<div class="md:hidden md:flex">

<!-- Desktop et plus (≥1024px) -->
<div class="lg:grid lg:grid-cols-4">

<!-- Exemple complet -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
  <!-- 1 colonne mobile, 2 sur tablet, 4 sur desktop -->
</div>
```

### Boutons

```html
<!-- Bouton primaire -->
<button class="bg-[#000091] text-white px-6 py-3 rounded-lg hover:bg-[#E1000F] transition-colors">
  Cliquez ici
</button>

<!-- Bouton secondaire -->
<button class="border-2 border-[#000091] text-[#000091] px-6 py-3 rounded-lg hover:bg-[#000091] hover:text-white transition-colors">
  En savoir plus
</button>

<!-- Bouton lien -->
<a href="#" class="inline-flex items-center space-x-2 text-[#000091] hover:text-[#E1000F] transition-colors">
  <i class="fas fa-arrow-right"></i>
  <span>Voir plus</span>
</a>
```

### Cartes (Cards)

```html
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
  <!-- Image -->
  <img src="..." class="w-full h-48 object-cover">
  
  <!-- Contenu -->
  <div class="p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-2">Titre</h3>
    <p class="text-gray-600 mb-4">Description...</p>
    <a href="#" class="text-[#000091] hover:text-[#E1000F] font-semibold">
      Lire plus →
    </a>
  </div>
</div>
```

### Navigation

```html
<!-- Menu horizontal -->
<nav class="flex space-x-6">
  <a href="#" class="text-gray-800 hover:text-[#000091] font-medium transition-colors">
    Accueil
  </a>
  <a href="#" class="text-gray-800 hover:text-[#000091] font-medium transition-colors">
    Services
  </a>
</nav>

<!-- Menu avec icônes -->
<nav class="flex items-center space-x-4">
  <a href="#" class="flex items-center space-x-2 hover:text-[#000091]">
    <i class="fas fa-home"></i>
    <span>Accueil</span>
  </a>
</nav>
```

### Badges et Tags

```html
<!-- Badge -->
<span class="inline-block bg-[#000091] text-white px-3 py-1 rounded-full text-sm font-semibold">
  Nouveau
</span>

<!-- Tag -->
<span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm">
  Actualité
</span>
```

### Alertes et Messages

```html
<!-- Info -->
<div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
  <p class="text-blue-700">Message d'information</p>
</div>

<!-- Succès -->
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
  <p class="text-green-700">Opération réussie !</p>
</div>

<!-- Erreur -->
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
  <p class="text-red-700">Une erreur est survenue</p>
</div>

<!-- Avertissement -->
<div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
  <p class="text-yellow-700">Attention !</p>
</div>
```

### Images

```html
<!-- Image responsive -->
<img src="..." class="w-full h-auto rounded-lg">

<!-- Image avec ratio -->
<div class="aspect-w-16 aspect-h-9">
  <img src="..." class="object-cover rounded-lg">
</div>

<!-- Image ronde -->
<img src="..." class="w-24 h-24 rounded-full object-cover">

<!-- Image avec ombre -->
<img src="..." class="shadow-lg rounded-lg">
```

### Formulaires

```html
<!-- Input -->
<input type="text" 
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#000091]" 
       placeholder="Votre nom">

<!-- Textarea -->
<textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#000091]" 
          rows="4"></textarea>

<!-- Select -->
<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#000091]">
  <option>Option 1</option>
  <option>Option 2</option>
</select>

<!-- Checkbox -->
<label class="flex items-center space-x-2">
  <input type="checkbox" class="w-4 h-4 text-[#000091] border-gray-300 rounded focus:ring-[#000091]">
  <span>J'accepte les conditions</span>
</label>
```

## 🎨 Classes personnalisées (dans custom.css)

En plus de Tailwind, le thème ajoute quelques classes pour l'accessibilité RGAA :

```css
/* Skip link (accessibilité) */
.skip-link { /* ... */ }

/* Texte pour lecteurs d'écran uniquement */
.screen-reader-text { /* ... */ }

/* Variables CSS */
:root {
  --color-primary: #000091;
  --color-secondary: #E1000F;
}
```

## 💡 Astuces

### 1. Utiliser les variables CSS avec Tailwind

```html
<!-- Au lieu de -->
<div class="bg-[#000091]">

<!-- Vous pouvez aussi utiliser -->
<div style="background: var(--color-primary);">
```

### 2. Combiner les classes

```html
<!-- Les classes peuvent être combinées -->
<button class="bg-[#000091] hover:bg-[#E1000F] text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
  Bouton animé
</button>
```

### 3. States (hover, focus, active)

```html
<!-- Hover -->
<div class="hover:bg-gray-100">

<!-- Focus -->
<input class="focus:ring-2 focus:ring-[#000091]">

<!-- Active -->
<button class="active:scale-95">

<!-- Combinés -->
<a class="hover:text-[#000091] focus:outline-none focus:ring-2">
```

### 4. Dark mode (si souhaité)

```html
<!-- Ajoutez `dark:` pour le mode sombre -->
<div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
```

## 📱 Breakpoints Tailwind

- `sm:` - ≥640px
- `md:` - ≥768px (tablette)
- `lg:` - ≥1024px (desktop)
- `xl:` - ≥1280px (grand écran)
- `2xl:` - ≥1536px (très grand écran)

## 🔗 Ressources

- **Documentation Tailwind** : https://tailwindcss.com/docs
- **Tailwind Cheat Sheet** : https://nerdcave.com/tailwind-cheat-sheet
- **Font Awesome Icons** : https://fontawesome.com/icons

## ⚠️ Important

Le CSS est chargé via CDN. Si vous devez travailler hors ligne, téléchargez Tailwind CSS et modifiez `functions.php` :

```php
// Remplacer
wp_enqueue_style('tailwind-cdn', 'https://cdn.jsdelivr.net/...');

// Par
wp_enqueue_style('tailwind-local', get_template_directory_uri() . '/assets/css/tailwind.min.css');
```

---

**Besoin d'aide ?** Consultez la documentation Tailwind ou créez une issue sur GitHub !
