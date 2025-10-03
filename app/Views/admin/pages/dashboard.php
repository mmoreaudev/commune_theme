<?php
/**
 * Dashboard Admin - Tableau de bord
 * @var array $stats
 * @var array $recentActivities
 * @var array $recentMessages
 * @var array $popularPosts
 * @var array $upcomingEvents
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Tableau de bord') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
                    <p class="text-gray-600">Administration - <?= e(setting('city_name', 'Ma Commune')) ?></p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Connecté en tant que <?= e(auth()['full_name'] ?? 'Admin') ?></span>
                    <a href="/admin/logout" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-blue-900 text-white">
        <div class="px-6 py-3">
            <div class="flex space-x-6">
                <a href="/admin" class="text-blue-200 hover:text-white">Dashboard</a>
                <a href="/admin/posts" class="text-blue-200 hover:text-white">Articles</a>
                <a href="/admin/events" class="text-blue-200 hover:text-white">Événements</a>
                <a href="/admin/pages" class="text-blue-200 hover:text-white">Pages</a>
                <a href="/admin/contact-messages" class="text-blue-200 hover:text-white">Messages</a>
                <a href="/admin/settings" class="text-blue-200 hover:text-white">Paramètres</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="p-6">
        <!-- Flash Messages -->
        <?php if (hasFlash('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?= e(flash('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (hasFlash('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?= e(flash('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Articles</h3>
                        <p class="text-3xl font-bold text-blue-600"><?= $stats['posts']['total'] ?? 0 ?></p>
                        <p class="text-sm text-gray-600">Publiés: <?= $stats['posts']['status']['published'] ?? 0 ?></p>
                    </div>
                    <div class="text-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Événements</h3>
                        <p class="text-3xl font-bold text-green-600"><?= $stats['events']['total'] ?? 0 ?></p>
                        <p class="text-sm text-gray-600">À venir: <?= $stats['events']['upcoming'] ?? 0 ?></p>
                    </div>
                    <div class="text-green-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Messages</h3>
                        <p class="text-3xl font-bold text-orange-600"><?= $stats['messages']['new'] ?? 0 ?></p>
                        <p class="text-sm text-gray-600">Non lus</p>
                    </div>
                    <div class="text-orange-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Utilisateurs</h3>
                        <p class="text-3xl font-bold text-purple-600"><?= $stats['users']['active'] ?? 0 ?></p>
                        <p class="text-sm text-gray-600">Actifs</p>
                    </div>
                    <div class="text-purple-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Messages récents -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Messages récents</h2>
                </div>
                <div class="p-6">
                    <?php if (!empty($recentMessages)): ?>
                        <div class="space-y-4">
                            <?php foreach (array_slice($recentMessages, 0, 5) as $message): ?>
                                <div class="flex items-start space-x-3">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900"><?= e($message['name'] ?? 'Anonyme') ?></p>
                                        <p class="text-sm text-gray-600"><?= e(excerpt($message['message'] ?? '', 100)) ?></p>
                                        <p class="text-xs text-gray-500"><?= timeAgo($message['created_at'] ?? '') ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-4">
                            <a href="/admin/contact-messages" class="text-blue-600 hover:underline">Voir tous les messages →</a>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">Aucun message récent</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Articles populaires -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Articles populaires</h2>
                </div>
                <div class="p-6">
                    <?php if (!empty($popularPosts)): ?>
                        <div class="space-y-4">
                            <?php foreach (array_slice($popularPosts, 0, 5) as $post): ?>
                                <div class="flex items-start space-x-3">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900"><?= e($post['title']) ?></p>
                                        <p class="text-sm text-gray-600"><?= $post['views'] ?? 0 ?> vues</p>
                                        <p class="text-xs text-gray-500"><?= formatDate($post['published_at'] ?? $post['created_at']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-4">
                            <a href="/admin/posts" class="text-blue-600 hover:underline">Gérer les articles →</a>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">Aucun article publié</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Prochains événements -->
        <?php if (!empty($upcomingEvents)): ?>
            <div class="mt-8 bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Prochains événements</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach (array_slice($upcomingEvents, 0, 6) as $event): ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="font-medium text-gray-900"><?= e($event['title']) ?></h3>
                                <p class="text-sm text-gray-600 mt-1"><?= formatDate($event['start_date']) ?></p>
                                <?php if (isset($event['location'])): ?>
                                    <p class="text-xs text-gray-500"><?= e($event['location']) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4">
                        <a href="/admin/events" class="text-blue-600 hover:underline">Gérer les événements →</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Actions rapides -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Actions rapides</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="/admin/posts/create" class="bg-blue-600 text-white p-4 rounded-lg text-center hover:bg-blue-700 transition-colors">
                        <div class="text-2xl mb-2">📝</div>
                        <div class="text-sm">Nouvel article</div>
                    </a>
                    <a href="/admin/events/create" class="bg-green-600 text-white p-4 rounded-lg text-center hover:bg-green-700 transition-colors">
                        <div class="text-2xl mb-2">📅</div>
                        <div class="text-sm">Nouvel événement</div>
                    </a>
                    <a href="/admin/pages/create" class="bg-purple-600 text-white p-4 rounded-lg text-center hover:bg-purple-700 transition-colors">
                        <div class="text-2xl mb-2">📄</div>
                        <div class="text-sm">Nouvelle page</div>
                    </a>
                    <a href="/" target="_blank" class="bg-gray-600 text-white p-4 rounded-lg text-center hover:bg-gray-700 transition-colors">
                        <div class="text-2xl mb-2">🌐</div>
                        <div class="text-sm">Voir le site</div>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>