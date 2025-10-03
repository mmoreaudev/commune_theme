<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Résultats de recherche</h1>
        <?php if (!empty($query)): ?>
            <p class="text-gray-600">Résultats pour : <strong><?= e($query) ?></strong></p>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($query)): ?>
        <?php if (!empty($results)): ?>
            <div class="space-y-6">
                <?php foreach ($results as $result): ?>
                    <article class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded"><?= e($result['type']) ?></span>
                                    <?php if (isset($result['date'])): ?>
                                        <span class="text-sm text-gray-500"><?= formatDate($result['date']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <h2 class="text-xl font-semibold mb-3">
                                    <a href="<?= e($result['url']) ?>" class="text-gray-900 hover:text-primary transition-colors">
                                        <?= e($result['title']) ?>
                                    </a>
                                </h2>
                                <p class="text-gray-600"><?= e($result['excerpt']) ?></p>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-gray-500">Aucun résultat trouvé pour votre recherche.</p>
                <p class="text-gray-400 mt-2">Essayez avec d'autres mots-clés.</p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="text-center py-12">
            <h2 class="text-xl font-semibold mb-4">Rechercher sur le site</h2>
            <form action="/recherche" method="GET" class="max-w-md mx-auto">
                <div class="flex">
                    <input type="search" name="q" placeholder="Tapez votre recherche..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>