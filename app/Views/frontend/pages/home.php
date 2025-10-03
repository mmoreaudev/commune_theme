<?php 
// Charger le layout principal
$content = ob_get_clean();
ob_start();
?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-france-blue to-blue-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Bienvenue à <?= e(setting('city_name')) ?>
            </h1>
            <?php if (setting('slogan')): ?>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    <?= e(setting('slogan')) ?>
                </p>
            <?php endif; ?>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/actualites" class="bg-white text-france-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    📰 Actualités
                </a>
                <a href="/votre-mairie/contact" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-france-blue transition-colors">
                    ✉️ Nous contacter
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Contenu principal -->
        <div class="flex-1">
            
            <!-- Actualités récentes -->
            <?php if (!empty($recentPosts)): ?>
                <section class="mb-12">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">Dernières actualités</h2>
                        <a href="/actualites" class="text-primary hover:underline font-semibold">
                            Voir toutes les actualités →
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($recentPosts as $post): ?>
                            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                <?php if ($post['featured_image']): ?>
                                    <img src="<?= e($post['featured_image']) ?>" 
                                         alt="<?= e($post['title']) ?>" 
                                         class="w-full h-48 object-cover">
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <div class="text-sm text-gray-500 mb-2">
                                        <?= formatDate($post['published_at'], 'd/m/Y') ?>
                                        <?php if ($post['category_name']): ?>
                                            • <span class="text-primary"><?= e($post['category_name']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="text-xl font-semibold mb-3">
                                        <a href="/actualites/<?= e($post['slug']) ?>" class="hover:text-primary transition-colors">
                                            <?= e($post['title']) ?>
                                        </a>
                                    </h3>
                                    
                                    <?php if ($post['excerpt']): ?>
                                        <p class="text-gray-600 mb-4">
                                            <?= e(str_limit($post['excerpt'], 120)) ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <a href="/actualites/<?= e($post['slug']) ?>" 
                                       class="inline-flex items-center text-primary hover:underline font-semibold">
                                        Lire la suite →
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
            
            <!-- Prochains événements -->
            <?php if (!empty($upcomingEvents)): ?>
                <section class="mb-12">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">Prochains événements</h2>
                        <a href="/evenements" class="text-primary hover:underline font-semibold">
                            Voir tous les événements →
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($upcomingEvents as $event): ?>
                            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                <?php if ($event['image']): ?>
                                    <img src="<?= e($event['image']) ?>" 
                                         alt="<?= e($event['title']) ?>" 
                                         class="w-full h-48 object-cover">
                                <?php else: ?>
                                    <div class="w-full h-48 bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center text-white text-6xl">
                                        📅
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <div class="text-sm text-primary font-semibold mb-2">
                                        📅 <?= formatDate($event['start_date'], 'd/m/Y à H:i') ?>
                                    </div>
                                    
                                    <h3 class="text-xl font-semibold mb-3">
                                        <a href="/evenements/<?= e($event['slug']) ?>" class="hover:text-primary transition-colors">
                                            <?= e($event['title']) ?>
                                        </a>
                                    </h3>
                                    
                                    <?php if ($event['location']): ?>
                                        <p class="text-gray-600 mb-2">
                                            📍 <?= e($event['location']) ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if ($event['description']): ?>
                                        <p class="text-gray-600 mb-4">
                                            <?= e(str_limit($event['description'], 100)) ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <a href="/evenements/<?= e($event['slug']) ?>" 
                                       class="inline-flex items-center text-primary hover:underline font-semibold">
                                        En savoir plus →
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
            
            <!-- Statistiques -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Votre commune en chiffres</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-primary mb-2">
                                <?= $stats['posts_count'] ?>
                            </div>
                            <div class="text-gray-600">
                                <?= pluralize($stats['posts_count'], 'Article publié') ?>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-4xl font-bold text-primary mb-2">
                                <?= $stats['events_count'] ?>
                            </div>
                            <div class="text-gray-600">
                                <?= pluralize($stats['events_count'], 'Événement organisé') ?>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-4xl font-bold text-primary mb-2">
                                <?= $stats['services_count'] ?>
                            </div>
                            <div class="text-gray-600">
                                <?= pluralize($stats['services_count'], 'Service municipal') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Liens rapides -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Accès rapide</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="/infos-pratiques/demarches" 
                       class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📋</div>
                        <h3 class="font-semibold text-gray-900">Démarches</h3>
                        <p class="text-sm text-gray-600 mt-1">Administratives</p>
                    </a>
                    
                    <a href="/infos-pratiques/horaires" 
                       class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🕒</div>
                        <h3 class="font-semibold text-gray-900">Horaires</h3>
                        <p class="text-sm text-gray-600 mt-1">d'ouverture</p>
                    </a>
                    
                    <a href="/publications" 
                       class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📄</div>
                        <h3 class="font-semibold text-gray-900">Publications</h3>
                        <p class="text-sm text-gray-600 mt-1">Bulletins & docs</p>
                    </a>
                    
                    <a href="/infos-pratiques/numeros-utiles" 
                       class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📞</div>
                        <h3 class="font-semibold text-gray-900">Numéros</h3>
                        <p class="text-sm text-gray-600 mt-1">utiles</p>
                    </a>
                </div>
            </section>
            
        </div>
        
        <!-- Sidebar -->
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>
    </div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();

// Inclure le layout
include __DIR__ . '/../layouts/main.php';
?>