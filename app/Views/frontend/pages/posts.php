<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= e($title ?? 'Actualités') ?></h1>
        <p class="text-gray-600">Retrouvez toutes les actualités de <?= e(setting('city_name', 'votre commune')) ?></p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach (($posts['items'] ?? []) as $p): ?>
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-3">
                        <a href="/actualites/<?= e($p['slug']) ?>" class="text-gray-900 hover:text-primary transition-colors">
                            <?= e($p['title']) ?>
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-4"><?= e($p['excerpt'] ?? '') ?></p>
                    <div class="text-sm text-gray-500">
                        <?= formatDate($p['published_at'] ?? $p['created_at']) ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($posts['items'])): ?>
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune actualité pour le moment.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
