<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Vie locale</h1>
        <p class="text-gray-600">Découvrez la vie associative et culturelle de <?= e(setting('city_name', 'Morton')) ?></p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                🏛️ Associations
            </h2>
            <p class="text-gray-700 mb-4">Découvrez toutes les associations de la commune et leurs activités.</p>
            <a href="/vie-locale/associations" class="inline-block bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Voir les associations
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                📅 Événements locaux  
            </h2>
            <p class="text-gray-700 mb-4">Les événements organisés par les associations et la commune.</p>
            <a href="/evenements" class="inline-block bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Voir les événements
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                🎭 Culture & Sport
            </h2>
            <p class="text-gray-700 mb-4">Activités culturelles et sportives proposées sur la commune.</p>
            <div class="text-sm text-gray-600">
                <p>Plus d'informations prochainement...</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                🏪 Commerces & Services
            </h2>
            <p class="text-gray-700 mb-4">Les commerces et services de proximité de la commune.</p>
            <div class="text-sm text-gray-600">
                <p>Informations à venir...</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                🌳 Patrimoine
            </h2>
            <p class="text-gray-700 mb-4">Découvrez le patrimoine historique et naturel de la commune.</p>
            <div class="text-sm text-gray-600">
                <p>Contenu en cours de préparation...</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                📰 Actualités locales
            </h2>
            <p class="text-gray-700 mb-4">Toute l'actualité de la vie locale et associative.</p>
            <a href="/actualites" class="inline-block bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Lire les actualités
            </a>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>