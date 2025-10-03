<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Démarches administratives</h1>
        <p class="text-gray-600">Retrouvez toutes les démarches administratives et leurs procédures</p>
    </div>
    
    <?php if (!empty($demarches)): ?>
        <?php foreach ($demarches as $category => $categoryDemarches): ?>
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-6 pb-2 border-b border-gray-200"><?= e(ucfirst($category)) ?></h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <?php foreach ($categoryDemarches as $demarche): ?>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold mb-3"><?= e($demarche['title']) ?></h3>
                            <p class="text-gray-600 mb-4"><?= e($demarche['description'] ?? '') ?></p>
                            <?php if (isset($demarche['procedure']) && $demarche['procedure']): ?>
                                <div class="text-sm text-gray-700">
                                    <strong>Procédure :</strong>
                                    <div class="mt-2"><?= nl2br(e($demarche['procedure'])) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune démarche administrative configurée pour le moment.</p>
            <p class="text-gray-400 mt-2">Pour plus d'informations, contactez la mairie.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>