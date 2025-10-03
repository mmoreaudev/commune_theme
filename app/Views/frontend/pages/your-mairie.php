<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Votre Mairie</h1>
        <p class="text-gray-600">Découvrez votre mairie, ses services et son équipe.</p>
    </div>
    
    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4">Informations pratiques</h2>
            <div class="space-y-3">
                <p><strong>Adresse :</strong> <?= e(setting('address', '1 Place de la Mairie')) ?></p>
                <p><strong>Code postal :</strong> <?= e(setting('postal_code', '75000')) ?></p>
                <p><strong>Ville :</strong> <?= e(setting('city', 'Paris')) ?></p>
                <p><strong>Téléphone :</strong> <?= e(setting('phone', '01 23 45 67 89')) ?></p>
                <p><strong>Email :</strong> <a href="mailto:<?= e(setting('email', 'contact@mairie.fr')) ?>" class="text-primary hover:underline"><?= e(setting('email', 'contact@mairie.fr')) ?></a></p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4">Horaires d'ouverture</h2>
            <p class="text-gray-700"><?= e(setting('opening_hours', 'Lundi-Vendredi: 9h-12h, 14h-17h')) ?></p>
            
            <div class="mt-6">
                <a href="/votre-mairie/contact" class="inline-block bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Nous contacter
                </a>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
