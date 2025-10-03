<?php $this->layout('frontend/layouts/main', ['title' => 'Actualités']); ?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">Actualités de la commune</h1>
                <p class="text-xl opacity-90">Restez informé des dernières nouvelles et événements</p>
            </div>
        </div>
    </div>

    <!-- Fil d'Ariane -->
    <nav class="breadcrumb bg-gray-50 py-3" aria-label="Fil d'Ariane">
        <div class="container mx-auto px-4">
            <a href="/" class="text-blue-600 hover:text-blue-800">Accueil</a>
            <span class="breadcrumb-separator">></span>
            <span class="text-gray-600">Actualités</span>
        </div>
    </nav>

    <!-- Contenu Principal -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Liste des actualités -->
            <div class="lg:col-span-2">
                <?php if (!empty($posts)): ?>
                    <div class="space-y-8">
                        <?php foreach ($posts as $post): ?>
                            <article class="card hover:shadow-lg transition-shadow">
                                <?php if ($post['image']): ?>
                                    <div class="aspect-video overflow-hidden">
                                        <img src="/uploads/posts/<?= htmlspecialchars($post['image']) ?>" 
                                             alt="<?= htmlspecialchars($post['title']) ?>"
                                             class="w-full h-full object-cover">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        <time datetime="<?= date('Y-m-d', strtotime($post['created_at'])) ?>">
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
                                    </div>
                                    
                                    <h2 class="text-2xl font-bold mb-3">
                                        <a href="/actualites/<?= $post['slug'] ?>" class="text-gray-900 hover:text-blue-600 transition-colors">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </a>
                                    </h2>
                                    
                                    <div class="prose max-w-none mb-4">
                                        <?= nl2br(htmlspecialchars(substr($post['content'], 0, 300))) ?>
                                        <?php if (strlen($post['content']) > 300): ?>...<?php endif; ?>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <a href="/actualites/<?= $post['slug'] ?>" class="btn btn-primary">
                                            Lire la suite
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                        
                                        <div class="flex items-center gap-2">
                                            <button class="text-gray-500 hover:text-blue-600 transition-colors" title="Partager">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <nav class="pagination" aria-label="Navigation des pages">
                            <?php if ($currentPage > 1): ?>
                                <a href="/actualites?page=<?= $currentPage - 1 ?>" aria-label="Page précédente">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php if ($i == $currentPage): ?>
                                    <span class="current" aria-current="page"><?= $i ?></span>
                                <?php else: ?>
                                    <a href="/actualites?page=<?= $i ?>"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="/actualites?page=<?= $currentPage + 1 ?>" aria-label="Page suivante">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune actualité</h3>
                        <p class="text-gray-600">Aucune actualité n'a été publiée pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Recherche -->
                <div class="widget">
                    <h3 class="widget-title">Rechercher</h3>
                    <form method="GET" action="/actualites">
                        <div class="flex gap-2">
                            <input type="text" 
                                   name="search" 
                                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                                   placeholder="Rechercher une actualité..."
                                   class="form-input flex-1">
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Catégories -->
                <?php if (!empty($categories)): ?>
                    <div class="widget">
                        <h3 class="widget-title">Catégories</h3>
                        <ul class="space-y-2">
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="/actualites?category=<?= $category['slug'] ?>" 
                                       class="flex items-center justify-between text-gray-700 hover:text-blue-600 transition-colors">
                                        <span><?= htmlspecialchars($category['name']) ?></span>
                                        <span class="badge badge-primary"><?= $category['posts_count'] ?? 0 ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Articles récents -->
                <?php if (!empty($recentPosts)): ?>
                    <div class="widget">
                        <h3 class="widget-title">Articles récents</h3>
                        <div class="space-y-4">
                            <?php foreach ($recentPosts as $recent): ?>
                                <article class="flex gap-3">
                                    <?php if ($recent['image']): ?>
                                        <div class="flex-shrink-0">
                                            <img src="/uploads/posts/thumb_<?= htmlspecialchars($recent['image']) ?>" 
                                                 alt="<?= htmlspecialchars($recent['title']) ?>"
                                                 class="w-16 h-16 object-cover rounded">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-sm leading-tight mb-1">
                                            <a href="/actualites/<?= $recent['slug'] ?>" 
                                               class="text-gray-900 hover:text-blue-600 transition-colors">
                                                <?= htmlspecialchars($recent['title']) ?>
                                            </a>
                                        </h4>
                                        <time class="text-xs text-gray-500" 
                                              datetime="<?= date('Y-m-d', strtotime($recent['created_at'])) ?>">
                                            <?= strftime('%d/%m/%Y', strtotime($recent['created_at'])) ?>
                                        </time>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Newsletter -->
                <div class="widget bg-blue-50 border border-blue-200">
                    <h3 class="widget-title text-blue-900">Newsletter</h3>
                    <p class="text-sm text-blue-800 mb-4">Recevez les dernières actualités par email</p>
                    
                    <form method="POST" action="/newsletter/subscribe" class="space-y-3">
                        <input type="email" 
                               name="email" 
                               placeholder="Votre adresse email"
                               required
                               class="form-input">
                        <button type="submit" class="btn btn-primary w-full">
                            S'abonner
                        </button>
                    </form>
                </div>

                <!-- Archives -->
                <div class="widget">
                    <h3 class="widget-title">Archives</h3>
                    <select class="form-input" onchange="if(this.value) window.location.href=this.value">
                        <option value="">Sélectionner un mois</option>
                        <?php 
                        // Générer les archives par mois (exemple)
                        for ($i = 0; $i < 12; $i++): 
                            $month = date('Y-m', strtotime("-$i months"));
                            $monthName = strftime('%B %Y', strtotime($month . '-01'));
                        ?>
                            <option value="/actualites?archive=<?= $month ?>">
                                <?= ucfirst($monthName) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </aside>
        </div>
    </div>
</div>