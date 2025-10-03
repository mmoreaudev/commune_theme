<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Événements</h1>
        <p class="text-gray-600">Découvrez les événements organisés par <?= e(setting('city_name', 'votre commune')) ?></p>
    </div>
    
    <div class="space-y-6">
        <?php foreach (($events['items'] ?? []) as $e): ?>
            <article class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col md:flex-row md:items-start gap-4">
                    <div class="flex-1">
                        <h2 class="text-2xl font-semibold mb-3">
                            <a href="/evenements/<?= e($e['slug']) ?>" class="text-gray-900 hover:text-primary transition-colors">
                                <?= e($e['title']) ?>
                            </a>
                        </h2>
                        <p class="text-gray-600 mb-4"><?= e($e['description'] ?? '') ?></p>
                        <div class="text-sm text-gray-500">
                            <?php if (isset($e['start_date'])): ?>
                                <span>📅 <?= formatDate($e['start_date']) ?></span>
                            <?php endif; ?>
                            <?php if (isset($e['location'])): ?>
                                <span class="ml-4">📍 <?= e($e['location']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($events['items'])): ?>
        <div class="text-center py-12">
            <p class="text-gray-500">Aucun événement programmé pour le moment.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
