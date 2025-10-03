<?php $this->layout('admin/layouts/main', ['title' => 'Tableau de bord', 'currentRoute' => '/admin']); ?>

<?php $this->start('content'); ?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Articles</p>
                    <p class="text-3xl font-bold text-gray-900"><?= $stats['posts'] ?? 0 ?></p>
                    <p class="text-sm text-green-600">
                        +<?= $stats['posts_this_month'] ?? 0 ?> ce mois
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Événements</p>
                    <p class="text-3xl font-bold text-gray-900"><?= $stats['events'] ?? 0 ?></p>
                    <p class="text-sm text-blue-600">
                        <?= $stats['upcoming_events'] ?? 0 ?> à venir
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Utilisateurs</p>
                    <p class="text-3xl font-bold text-gray-900"><?= $stats['users'] ?? 0 ?></p>
                    <p class="text-sm text-purple-600">
                        <?= $stats['active_users'] ?? 0 ?> actifs
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Messages</p>
                    <p class="text-3xl font-bold text-gray-900"><?= $stats['messages'] ?? 0 ?></p>
                    <p class="text-sm text-orange-600">
                        <?= $stats['unread_messages'] ?? 0 ?> non lus
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Recent Posts -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="text-lg font-semibold">Articles récents</h3>
            <a href="/admin/posts" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Voir tout
            </a>
        </div>
        
        <div class="card-body p-0">
            <?php if (!empty($recentPosts)): ?>
                <div class="divide-y">
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 mb-1">
                                        <a href="/admin/posts/edit/<?= $post['id'] ?>" class="hover:text-blue-600">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </a>
                                    </h4>
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span><?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                                        <span class="badge badge-<?= $post['status'] === 'published' ? 'success' : 'warning' ?>">
                                            <?= $post['status'] === 'published' ? 'Publié' : 'Brouillon' ?>
                                        </span>
                                        <span><?= $post['views'] ?? 0 ?> vues</span>
                                    </div>
                                </div>
                                <?php if ($post['image']): ?>
                                    <img src="/uploads/posts/thumb_<?= htmlspecialchars($post['image']) ?>" 
                                         alt="<?= htmlspecialchars($post['title']) ?>"
                                         class="w-16 h-16 object-cover rounded ml-4">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                    <p>Aucun article récent</p>
                    <a href="/admin/posts/create" class="btn btn-primary mt-3">
                        Créer le premier article
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="text-lg font-semibold">Événements à venir</h3>
            <a href="/admin/events" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Voir tout
            </a>
        </div>
        
        <div class="card-body p-0">
            <?php if (!empty($upcomingEvents)): ?>
                <div class="divide-y">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 text-center">
                                    <div class="bg-blue-600 text-white rounded-lg p-2 min-w-[3rem]">
                                        <div class="text-xs"><?= strftime('%b', strtotime($event['event_date'])) ?></div>
                                        <div class="text-lg font-bold"><?= date('d', strtotime($event['event_date'])) ?></div>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 mb-1">
                                        <a href="/admin/events/edit/<?= $event['id'] ?>" class="hover:text-blue-600">
                                            <?= htmlspecialchars($event['title']) ?>
                                        </a>
                                    </h4>
                                    <div class="text-sm text-gray-500 mb-2">
                                        <?php if ($event['location']): ?>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                </svg>
                                                <?= htmlspecialchars($event['location']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($event['event_time']): ?>
                                            <div class="flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                <?= date('H:i', strtotime($event['event_time'])) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <p>Aucun événement prévu</p>
                    <a href="/admin/events/create" class="btn btn-primary mt-3">
                        Créer un événement
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Messages -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="text-lg font-semibold">Messages récents</h3>
                <a href="/admin/messages" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout
                </a>
            </div>
            
            <div class="card-body p-0">
                <?php if (!empty($recentMessages)): ?>
                    <div class="divide-y">
                        <?php foreach ($recentMessages as $message): ?>
                            <div class="p-4 hover:bg-gray-50 <?= $message['status'] === 'unread' ? 'bg-blue-50' : '' ?>">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-medium text-gray-900">
                                                <?= htmlspecialchars($message['firstname'] . ' ' . $message['lastname']) ?>
                                            </h4>
                                            <?php if ($message['status'] === 'unread'): ?>
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <?= htmlspecialchars($message['subject']) ?>
                                        </p>
                                        <p class="text-sm text-gray-500 line-clamp-2">
                                            <?= htmlspecialchars(substr($message['message'], 0, 100)) ?>
                                            <?php if (strlen($message['message']) > 100): ?>...<?php endif; ?>
                                        </p>
                                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                                            <span><?= date('d/m/Y H:i', strtotime($message['created_at'])) ?></span>
                                            <span><?= htmlspecialchars($message['email']) ?></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 ml-4">
                                        <a href="/admin/messages/view/<?= $message['id'] ?>" 
                                           class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <p>Aucun message récent</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions & System Info -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold">Actions rapides</h3>
            </div>
            
            <div class="card-body">
                <div class="space-y-3">
                    <a href="/admin/posts/create" class="btn btn-primary w-full justify-start">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Nouvel article
                    </a>
                    
                    <a href="/admin/events/create" class="btn btn-outline w-full justify-start">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Nouvel événement
                    </a>
                    
                    <a href="/admin/users/create" class="btn btn-outline w-full justify-start">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                        </svg>
                        Nouvel utilisateur
                    </a>
                    
                    <a href="/admin/settings" class="btn btn-outline w-full justify-start">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                        Paramètres
                    </a>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold">Informations système</h3>
            </div>
            
            <div class="card-body">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Version CMS</span>
                        <span class="font-medium">1.0.0</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">PHP</span>
                        <span class="font-medium"><?= PHP_VERSION ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Base de données</span>
                        <span class="font-medium">SQLite</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dernière sauvegarde</span>
                        <span class="font-medium">
                            <?= isset($lastBackup) ? date('d/m/Y H:i', strtotime($lastBackup)) : 'Aucune' ?>
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <a href="/admin/backup" class="btn btn-outline w-full text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Créer une sauvegarde
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop(); ?>