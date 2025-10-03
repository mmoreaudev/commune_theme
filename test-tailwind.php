<?php
/**
 * Template Name: Test Tailwind CSS
 * 
 * Page de test pour vérifier que Tailwind CSS fonctionne correctement
 * 
 * Instructions :
 * 1. Créer une nouvelle page dans WordPress
 * 2. Sélectionner le modèle "Test Tailwind CSS"
 * 3. Publier et visiter la page
 * 4. Si les couleurs et mises en forme s'affichent, Tailwind fonctionne ✅
 * 
 * @package Mairie_France
 * @since 1.1.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        
        <!-- Titre principal -->
        <h1 class="text-4xl font-bold text-[#000091] mb-8 text-center">
            🎨 Test Tailwind CSS
        </h1>
        
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <p class="text-lg text-gray-700 mb-4">
                Cette page permet de vérifier que Tailwind CSS est correctement chargé et fonctionnel.
            </p>
            <p class="text-sm text-gray-500">
                Si vous voyez des couleurs, des ombres et une mise en forme moderne, Tailwind fonctionne correctement ! ✅
            </p>
        </div>

        <!-- Test des couleurs -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test des couleurs
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white border-2 border-gray-200 rounded-lg p-6 text-center shadow-md">
                    <div class="w-16 h-16 bg-[#000091] mx-auto mb-3 rounded-full"></div>
                    <p class="text-sm font-medium">Bleu France</p>
                    <p class="text-xs text-gray-500">#000091</p>
                </div>
                
                <div class="bg-white border-2 border-gray-200 rounded-lg p-6 text-center shadow-md">
                    <div class="w-16 h-16 bg-[#E1000F] mx-auto mb-3 rounded-full"></div>
                    <p class="text-sm font-medium">Rouge Marianne</p>
                    <p class="text-xs text-gray-500">#E1000F</p>
                </div>
                
                <div class="bg-white border-2 border-gray-200 rounded-lg p-6 text-center shadow-md">
                    <div class="w-16 h-16 bg-gray-900 mx-auto mb-3 rounded-full"></div>
                    <p class="text-sm font-medium">Gray 900</p>
                    <p class="text-xs text-gray-500">Tailwind</p>
                </div>
                
                <div class="bg-white border-2 border-gray-200 rounded-lg p-6 text-center shadow-md">
                    <div class="w-16 h-16 bg-gray-100 border-2 border-gray-300 mx-auto mb-3 rounded-full"></div>
                    <p class="text-sm font-medium">Gray 100</p>
                    <p class="text-xs text-gray-500">Tailwind</p>
                </div>
            </div>
        </div>

        <!-- Test du système de grille -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test de la grille responsive
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-[#000091] text-white p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-2">Colonne 1</h3>
                    <p class="text-sm">Cette grille s'adapte : 1 col mobile, 2 cols tablette, 3 cols desktop</p>
                </div>
                <div class="bg-[#E1000F] text-white p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-2">Colonne 2</h3>
                    <p class="text-sm">Redimensionnez la fenêtre pour voir la grille s'adapter</p>
                </div>
                <div class="bg-gray-700 text-white p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-2">Colonne 3</h3>
                    <p class="text-sm">Si cela fonctionne, Tailwind est OK ✅</p>
                </div>
            </div>
        </div>

        <!-- Test Flexbox -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test Flexbox
            </h2>
            
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-gray-100 p-6 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-[#000091] rounded-full flex items-center justify-center text-white font-bold">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="font-medium">Flexbox horizontal</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-[#E1000F] rounded-full flex items-center justify-center text-white font-bold">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="font-medium">Alignement centré</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center text-white font-bold">
                        <i class="fas fa-heart"></i>
                    </div>
                    <span class="font-medium">Espacement cohérent</span>
                </div>
            </div>
        </div>

        <!-- Test des espacements -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test des espacements (Spacing)
            </h2>
            
            <div class="space-y-4">
                <div class="bg-blue-100 border-l-4 border-[#000091] p-4">
                    <p class="font-medium">Padding 4 (1rem) - Classe : <code class="bg-gray-200 px-2 py-1 rounded text-sm">p-4</code></p>
                </div>
                <div class="bg-red-100 border-l-4 border-[#E1000F] p-6">
                    <p class="font-medium">Padding 6 (1.5rem) - Classe : <code class="bg-gray-200 px-2 py-1 rounded text-sm">p-6</code></p>
                </div>
                <div class="bg-gray-100 border-l-4 border-gray-700 p-8">
                    <p class="font-medium">Padding 8 (2rem) - Classe : <code class="bg-gray-200 px-2 py-1 rounded text-sm">p-8</code></p>
                </div>
            </div>
        </div>

        <!-- Test des ombres -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test des ombres (Shadow)
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm p-6 rounded-lg">
                    <p class="font-medium text-center">shadow-sm</p>
                    <p class="text-xs text-gray-500 text-center mt-2">Ombre légère</p>
                </div>
                <div class="bg-white shadow-md p-6 rounded-lg">
                    <p class="font-medium text-center">shadow-md</p>
                    <p class="text-xs text-gray-500 text-center mt-2">Ombre moyenne</p>
                </div>
                <div class="bg-white shadow-lg p-6 rounded-lg">
                    <p class="font-medium text-center">shadow-lg</p>
                    <p class="text-xs text-gray-500 text-center mt-2">Ombre forte</p>
                </div>
            </div>
        </div>

        <!-- Test Hover & Transitions -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test Hover & Transitions
            </h2>
            
            <div class="flex flex-wrap gap-4">
                <button class="bg-[#000091] text-white px-6 py-3 rounded-lg hover:bg-[#E1000F] transition-colors duration-300 font-medium">
                    Survol pour changer la couleur
                </button>
                
                <button class="bg-white border-2 border-[#000091] text-[#000091] px-6 py-3 rounded-lg hover:bg-[#000091] hover:text-white transition-all duration-300 font-medium">
                    Bouton outline avec hover
                </button>
                
                <button class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300 font-medium">
                    Hover avec effet lift
                </button>
            </div>
        </div>

        <!-- Test des icônes Font Awesome -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test Font Awesome (icônes)
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-[#000091] transition-colors">
                    <i class="fas fa-home text-3xl text-[#000091] mb-2"></i>
                    <p class="text-xs">fa-home</p>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-[#000091] transition-colors">
                    <i class="fas fa-phone text-3xl text-[#E1000F] mb-2"></i>
                    <p class="text-xs">fa-phone</p>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-[#000091] transition-colors">
                    <i class="fas fa-envelope text-3xl text-gray-700 mb-2"></i>
                    <p class="text-xs">fa-envelope</p>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-[#000091] transition-colors">
                    <i class="fas fa-map-marker-alt text-3xl text-[#000091] mb-2"></i>
                    <p class="text-xs">fa-map-marker</p>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-[#000091] transition-colors">
                    <i class="fas fa-calendar text-3xl text-[#E1000F] mb-2"></i>
                    <p class="text-xs">fa-calendar</p>
                </div>
            </div>
        </div>

        <!-- Test Typography -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-[#000091] pb-2">
                Test de la typographie
            </h2>
            
            <div class="bg-white p-8 rounded-lg shadow-md space-y-4">
                <h1 class="text-4xl font-bold text-gray-900">Titre H1 - text-4xl font-bold</h1>
                <h2 class="text-3xl font-bold text-gray-800">Titre H2 - text-3xl font-bold</h2>
                <h3 class="text-2xl font-semibold text-gray-700">Titre H3 - text-2xl font-semibold</h3>
                <p class="text-lg text-gray-600">Paragraphe normal - text-lg</p>
                <p class="text-base text-gray-500">Paragraphe base - text-base</p>
                <p class="text-sm text-gray-400">Petit texte - text-sm</p>
                <p class="text-xs text-gray-300">Très petit texte - text-xs</p>
            </div>
        </div>

        <!-- Résultat final -->
        <div class="bg-gradient-to-r from-[#000091] to-[#E1000F] text-white p-8 rounded-lg text-center">
            <h2 class="text-3xl font-bold mb-4">✅ Test réussi !</h2>
            <p class="text-lg mb-2">Si vous voyez cette page avec toutes les couleurs et mises en forme,</p>
            <p class="text-xl font-bold">Tailwind CSS fonctionne parfaitement ! 🎉</p>
        </div>

        <!-- Informations de débogage -->
        <div class="mt-8 bg-gray-100 p-6 rounded-lg">
            <h3 class="font-bold text-gray-800 mb-3">📋 Informations de débogage</h3>
            <div class="space-y-2 text-sm">
                <p><strong>Version du thème :</strong> <?php echo MAIRIE_THEME_VERSION; ?></p>
                <p><strong>Version WordPress :</strong> <?php echo get_bloginfo('version'); ?></p>
                <p><strong>URL du thème :</strong> <?php echo MAIRIE_THEME_URI; ?></p>
                <p><strong>Tailwind CDN chargé :</strong> 
                    <span class="text-green-600 font-bold">
                        <script>document.write(document.querySelector('link[href*="tailwind"]') ? '✅ OUI' : '❌ NON');</script>
                    </span>
                </p>
                <p><strong>Font Awesome chargé :</strong> 
                    <span class="text-green-600 font-bold">
                        <script>document.write(document.querySelector('link[href*="font-awesome"]') ? '✅ OUI' : '❌ NON');</script>
                    </span>
                </p>
            </div>
        </div>

    </div>
</div>

<?php
get_footer();
