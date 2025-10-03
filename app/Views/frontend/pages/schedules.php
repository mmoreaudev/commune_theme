<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Horaires</h1>
        <p class="text-gray-600">Horaires d'ouverture des services municipaux</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Mairie</h2>
        <div class="text-gray-700">
            <?= nl2br(e(setting('opening_hours', 'Horaires non renseignés'))) ?>
        </div>
        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-800"><strong>Contact :</strong> <?= e(setting('phone', '05 49 22 96 94')) ?></p>
            <p class="text-sm text-blue-800"><strong>Email :</strong> <?= e(setting('email', 'mairie.morton@wanadoo.fr')) ?></p>
        </div>
    </div>
    
    <?php if (!empty($schedules)): ?>
        <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($schedules as $schedule): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-3"><?= e($schedule['name'] ?? $schedule['service'] ?? 'Service') ?></h3>
                    <div class="text-gray-700">
                        <?= nl2br(e($schedule['hours'] ?? $schedule['schedule'] ?? 'Horaires non renseignés')) ?>
                    </div>
                    <?php if (isset($schedule['phone']) && $schedule['phone']): ?>
                        <p class="text-sm text-gray-600 mt-3">
                            <strong>Tél :</strong> <?= e($schedule['phone']) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (isset($schedule['email']) && $schedule['email']): ?>
                        <p class="text-sm text-gray-600">
                            <strong>Email :</strong> <?= e($schedule['email']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-8">
            <p class="text-gray-500">Aucun horaire spécifique configuré.</p>
            <p class="text-gray-400 mt-2">Référez-vous aux horaires de la mairie ci-dessus.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>