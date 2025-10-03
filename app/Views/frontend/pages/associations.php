<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Associations</h1>
        <p class="text-gray-600">Découvrez les associations de <?= e(setting('city_name', 'Morton')) ?></p>
    </div>
    
    <?php if (!empty($associations)): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($associations as $association): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-3"><?= e($association['name'] ?? 'Association') ?></h3>
                    <?php if (isset($association['description']) && $association['description']): ?>
                        <p class="text-gray-600 mb-4"><?= e(excerpt($association['description'], 120)) ?></p>
                    <?php endif; ?>
                    
                    <div class="text-sm text-gray-500 space-y-1">
                        <?php if (isset($association['category']) && $association['category']): ?>
                            <p><strong>Catégorie :</strong> <?= e($association['category']) ?></p>
                        <?php endif; ?>
                        <?php if (isset($association['president']) && $association['president']): ?>
                            <p><strong>Président :</strong> <?= e($association['president']) ?></p>
                        <?php endif; ?>
                        <?php if (isset($association['phone']) && $association['phone']): ?>
                            <p><strong>Tél :</strong> <?= e($association['phone']) ?></p>
                        <?php endif; ?>
                        <?php if (isset($association['email']) && $association['email']): ?>
                            <p><strong>Email :</strong> <a href="mailto:<?= e($association['email']) ?>" class="text-primary hover:underline"><?= e($association['email']) ?></a></p>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (isset($association['slug']) && $association['slug']): ?>
                        <div class="mt-4">
                            <a href="/vie-locale/associations/<?= e($association['slug']) ?>" class="text-primary hover:underline">
                                En savoir plus →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune association enregistrée pour le moment.</p>
            <p class="text-gray-400 mt-2">Les associations peuvent se faire connaître en contactant la mairie.</p>
            <a href="/votre-mairie/contact" class="inline-block mt-4 bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Contacter la mairie
            </a>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>