<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Numéros utiles</h1>
        <p class="text-gray-600">Retrouvez tous les numéros utiles de <?= e(setting('city_name', 'votre commune')) ?></p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach (($numbers ?? []) as $n): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-2"><?= e($n['label']) ?></h3>
                <a href="tel:<?= e($n['number']) ?>" class="text-2xl font-bold text-primary hover:text-blue-700">
                    <?= e($n['number']) ?>
                </a>
                <?php if (isset($n['description']) && $n['description']): ?>
                    <p class="text-gray-600 mt-2"><?= e($n['description']) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($numbers)): ?>
        <div class="text-center py-12">
            <p class="text-gray-500">Aucun numéro utile configuré pour le moment.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
