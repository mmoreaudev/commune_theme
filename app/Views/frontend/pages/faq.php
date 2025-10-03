<?php 
$content = ob_start(); 
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Questions fréquentes</h1>
        <p class="text-gray-600">Retrouvez les réponses aux questions les plus posées</p>
    </div>
    
    <?php if (!empty($faqs)): ?>
        <?php foreach ($faqs as $category => $categoryFaqs): ?>
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-6 pb-2 border-b border-gray-200"><?= e(ucfirst($category)) ?></h2>
                <div class="space-y-4">
                    <?php foreach ($categoryFaqs as $faq): ?>
                        <div class="bg-white rounded-lg shadow-md">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-3 text-primary"><?= e($faq['question']) ?></h3>
                                <div class="text-gray-700"><?= nl2br(e($faq['answer'])) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune question fréquente configurée pour le moment.</p>
            <p class="text-gray-400 mt-2">Pour toute question, n'hésitez pas à nous contacter.</p>
            <a href="/votre-mairie/contact" class="inline-block mt-4 bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Nous contacter
            </a>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>