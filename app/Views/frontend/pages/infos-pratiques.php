<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Infos pratiques</h1>
        <p class="text-gray-600">Toutes les informations pratiques pour vos démarches à <?= e(setting('city_name', 'Morton')) ?></p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                🕒 Horaires
            </h2>
            <p class="text-gray-700"><?= e(setting('opening_hours', 'Horaires non renseignés')) ?></p>
            <a href="/infos-pratiques/horaires" class="inline-block mt-4 text-primary hover:underline">Voir tous les horaires →</a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                📋 Démarches
            </h2>
            <p class="text-gray-700">Retrouvez toutes les démarches administratives et leurs procédures.</p>
            <a href="/infos-pratiques/demarches" class="inline-block mt-4 text-primary hover:underline">Voir les démarches →</a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                ❓ FAQ
            </h2>
            <p class="text-gray-700">Questions fréquemment posées et leurs réponses.</p>
            <a href="/infos-pratiques/faq" class="inline-block mt-4 text-primary hover:underline">Consulter la FAQ →</a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                📞 Numéros utiles
            </h2>
            <p class="text-gray-700">Tous les numéros de téléphone utiles de la commune.</p>
            <a href="/infos-pratiques/numeros-utiles" class="inline-block mt-4 text-primary hover:underline">Voir les numéros →</a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                📍 Contact
            </h2>
            <div class="text-gray-700 space-y-2">
                <p><?= e(setting('address', '1 Place Prieuré')) ?></p>
                <p><?= e(setting('postal_code', '86120')) ?> <?= e(setting('city', 'Morton')) ?></p>
                <p>Tél : <?= e(setting('phone', '05 49 22 96 94')) ?></p>
            </div>
            <a href="/votre-mairie/contact" class="inline-block mt-4 text-primary hover:underline">Nous contacter →</a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                📄 Publications
            </h2>
            <p class="text-gray-700">Bulletins municipaux, magazines et délibérations.</p>
            <a href="/publications" class="inline-block mt-4 text-primary hover:underline">Voir les publications →</a>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>