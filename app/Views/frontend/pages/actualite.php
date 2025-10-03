<?php $this->layout('frontend/layouts/main', ['title' => htmlspecialchars($post['title'])]); ?>

<div class="bg-white">
    <!-- Fil d'Ariane -->
    <nav class="breadcrumb bg-gray-50 py-3" aria-label="Fil d'Ariane">
        <div class="container mx-auto px-4">
            <a href="/" class="text-blue-600 hover:text-blue-800">Accueil</a>
            <span class="breadcrumb-separator">></span>
            <a href="/actualites" class="text-blue-600 hover:text-blue-800">Actualités</a>
            <span class="breadcrumb-separator">></span>
            <span class="text-gray-600"><?= htmlspecialchars($post['title']) ?></span>
        </div>
    </nav>

    <!-- Contenu Principal -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Article -->
            <article class="lg:col-span-2">
                <header class="mb-8">
                    <?php if ($post['image']): ?>
                        <div class="aspect-video overflow-hidden rounded-lg mb-6">
                            <img src="/uploads/posts/<?= htmlspecialchars($post['image']) ?>" 
                                 alt="<?= htmlspecialchars($post['title']) ?>"
                                 class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>

                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                        <time datetime="<?= date('Y-m-d', strtotime($post['created_at'])) ?>">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <?= strftime('%d %B %Y', strtotime($post['created_at'])) ?>
                        </time>
                        
                        <?php if ($post['category_name']): ?>
                            <span class="badge badge-primary"><?= htmlspecialchars($post['category_name']) ?></span>
                        <?php endif; ?>
                        
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            <?= $post['views'] ?? 0 ?> vues
                        </span>

                        <?php if ($post['updated_at'] && $post['updated_at'] !== $post['created_at']): ?>
                            <span class="text-orange-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"/>
                                </svg>
                                Mis à jour le <?= strftime('%d/%m/%Y', strtotime($post['updated_at'])) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-6"><?= htmlspecialchars($post['title']) ?></h1>

                    <?php if ($post['excerpt']): ?>
                        <div class="text-xl text-gray-600 leading-relaxed mb-8 p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                            <?= nl2br(htmlspecialchars($post['excerpt'])) ?>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- Contenu de l'article -->
                <div class="prose max-w-none mb-8">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>

                <!-- Pièces jointes -->
                <?php if (!empty($post['attachments'])): ?>
                    <div class="border-t pt-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Documents joints</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($post['attachments'] as $attachment): ?>
                                <a href="/uploads/documents/<?= htmlspecialchars($attachment['filename']) ?>" 
                                   target="_blank"
                                   class="flex items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <div class="font-medium"><?= htmlspecialchars($attachment['title']) ?></div>
                                        <div class="text-sm text-gray-500">
                                            <?= strtoupper(pathinfo($attachment['filename'], PATHINFO_EXTENSION)) ?> 
                                            - <?= $this->formatFileSize($attachment['filesize'] ?? 0) ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Tags -->
                <?php if (!empty($post['tags'])): ?>
                    <div class="border-t pt-6 mb-8">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Mots-clés</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach (explode(',', $post['tags']) as $tag): ?>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                    #<?= trim(htmlspecialchars($tag)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Partage -->
                <div class="border-t pt-6 mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Partager</h3>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl) ?>" 
                           target="_blank"
                           class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"/>
                            </svg>
                            Facebook
                        </a>
                        
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($currentUrl) ?>&text=<?= urlencode($post['title']) ?>" 
                           target="_blank"
                           class="flex items-center gap-2 px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                            Twitter
                        </a>
                        
                        <button onclick="navigator.share ? navigator.share({title: '<?= htmlspecialchars($post['title']) ?>', url: window.location.href}) : copyToClipboard(window.location.href)"
                                class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                            </svg>
                            Partager
                        </button>
                        
                        <button onclick="window.print()" 
                                class="flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Imprimer
                        </button>
                    </div>
                </div>

                <!-- Navigation article précédent/suivant -->
                <nav class="border-t pt-6 mb-8">
                    <div class="flex justify-between">
                        <?php if (!empty($previousPost)): ?>
                            <a href="/actualites/<?= $previousPost['slug'] ?>" 
                               class="flex-1 mr-4 p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="text-sm text-gray-500 mb-1">← Article précédent</div>
                                <div class="font-medium"><?= htmlspecialchars($previousPost['title']) ?></div>
                            </a>
                        <?php else: ?>
                            <div class="flex-1 mr-4"></div>
                        <?php endif; ?>

                        <?php if (!empty($nextPost)): ?>
                            <a href="/actualites/<?= $nextPost['slug'] ?>" 
                               class="flex-1 ml-4 p-4 border rounded-lg hover:bg-gray-50 transition-colors text-right">
                                <div class="text-sm text-gray-500 mb-1">Article suivant →</div>
                                <div class="font-medium"><?= htmlspecialchars($nextPost['title']) ?></div>
                            </a>
                        <?php else: ?>
                            <div class="flex-1 ml-4"></div>
                        <?php endif; ?>
                    </div>
                </nav>
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Articles similaires -->
                <?php if (!empty($relatedPosts)): ?>
                    <div class="widget">
                        <h3 class="widget-title">Articles similaires</h3>
                        <div class="space-y-4">
                            <?php foreach ($relatedPosts as $related): ?>
                                <article class="flex gap-3">
                                    <?php if ($related['image']): ?>
                                        <div class="flex-shrink-0">
                                            <img src="/uploads/posts/thumb_<?= htmlspecialchars($related['image']) ?>" 
                                                 alt="<?= htmlspecialchars($related['title']) ?>"
                                                 class="w-16 h-16 object-cover rounded">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-sm leading-tight mb-1">
                                            <a href="/actualites/<?= $related['slug'] ?>" 
                                               class="text-gray-900 hover:text-blue-600 transition-colors">
                                                <?= htmlspecialchars($related['title']) ?>
                                            </a>
                                        </h4>
                                        <time class="text-xs text-gray-500" 
                                              datetime="<?= date('Y-m-d', strtotime($related['created_at'])) ?>">
                                            <?= strftime('%d/%m/%Y', strtotime($related['created_at'])) ?>
                                        </time>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Retour à la liste -->
                <div class="widget">
                    <a href="/actualites" class="btn btn-outline w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Toutes les actualités
                    </a>
                </div>

                <!-- Contact rapide -->
                <div class="widget bg-blue-50 border border-blue-200">
                    <h3 class="widget-title text-blue-900">Une question ?</h3>
                    <p class="text-sm text-blue-800 mb-4">Contactez-nous pour plus d'informations</p>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-blue-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            01 23 45 67 89
                        </div>
                        
                        <div class="flex items-center gap-2 text-blue-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            contact@mairie.fr
                        </div>
                    </div>
                    
                    <a href="/contact" class="btn btn-primary w-full mt-4">
                        Nous contacter
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        window.mairieCMS.showNotification('Lien copié dans le presse-papiers', 'success', 3000);
    }).catch(() => {
        window.mairieCMS.showNotification('Erreur lors de la copie', 'error', 3000);
    });
}
</script>