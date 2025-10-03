<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Administration' ?> - Mairie CMS</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico">
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg" x-data="{ sidebarOpen: true }">
            <div class="p-6 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-gray-900">Mairie CMS</h1>
                        <p class="text-sm text-gray-500">Administration</p>
                    </div>
                </div>
            </div>

            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="/admin" class="nav-link flex items-center gap-3 <?= $currentRoute === '/admin' ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                            Tableau de bord
                        </a>
                    </li>
                    
                    <li>
                        <div class="nav-link font-medium text-gray-400 text-sm uppercase tracking-wide">
                            Contenu
                        </div>
                    </li>
                    
                    <li>
                        <a href="/admin/posts" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/posts') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            Articles
                            <?php if (isset($stats['posts']) && $stats['posts'] > 0): ?>
                                <span class="badge badge-primary ml-auto"><?= $stats['posts'] ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/pages" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/pages') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"/>
                            </svg>
                            Pages
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/events" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/events') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            Événements
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/services" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/services') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/>
                            </svg>
                            Services
                        </a>
                    </li>
                    
                    <li>
                        <div class="nav-link font-medium text-gray-400 text-sm uppercase tracking-wide">
                            Structure
                        </div>
                    </li>
                    
                    <li>
                        <a href="/admin/team" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/team') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                            Équipe municipale
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/associations" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/associations') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Associations
                        </a>
                    </li>
                    
                    <li>
                        <div class="nav-link font-medium text-gray-400 text-sm uppercase tracking-wide">
                            Configuration
                        </div>
                    </li>
                    
                    <li>
                        <a href="/admin/users" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/users') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            Utilisateurs
                            <?php if (isset($stats['users']) && $stats['users'] > 0): ?>
                                <span class="badge badge-primary ml-auto"><?= $stats['users'] ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/settings" class="nav-link flex items-center gap-3 <?= strpos($currentRoute, '/admin/settings') === 0 ? 'active bg-blue-50 text-blue-600' : '' ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                            </svg>
                            Paramètres
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <h2 class="text-2xl font-semibold text-gray-900"><?= $title ?? 'Administration' ?></h2>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700 relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM19 7V4a1 1 0 00-1-1H5a1 1 0 00-1 1v3m16 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0H3"/>
                                </svg>
                                <?php if (isset($notifications) && count($notifications) > 0): ?>
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">
                                        <?= count($notifications) ?>
                                    </span>
                                <?php endif; ?>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border z-50">
                                <div class="p-4 border-b">
                                    <h3 class="font-semibold text-gray-900">Notifications</h3>
                                </div>
                                
                                <div class="max-h-96 overflow-y-auto">
                                    <?php if (isset($notifications) && count($notifications) > 0): ?>
                                        <?php foreach ($notifications as $notification): ?>
                                            <div class="p-4 border-b hover:bg-gray-50">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                                    <div class="flex-1">
                                                        <p class="text-sm text-gray-900"><?= htmlspecialchars($notification['message']) ?></p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            <?= date('d/m/Y H:i', strtotime($notification['created_at'])) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="p-4 text-center text-gray-500">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                            </svg>
                                            <p class="text-sm">Aucune notification</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="btn btn-primary flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Nouveau
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border z-50">
                                <a href="/admin/posts/create" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Nouvel article
                                </a>
                                <a href="/admin/events/create" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Nouvel événement
                                </a>
                                <a href="/admin/pages/create" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Nouvelle page
                                </a>
                                <a href="/admin/users/create" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Nouvel utilisateur
                                </a>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        <?= strtoupper(substr($currentUser['firstname'], 0, 1) . substr($currentUser['lastname'], 0, 1)) ?>
                                    </span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($currentUser['firstname'] . ' ' . $currentUser['lastname']) ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?= ucfirst($currentUser['role']) ?>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border z-50">
                                <a href="/admin/profile" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                                    </svg>
                                    Mon profil
                                </a>
                                
                                <a href="/" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Voir le site
                                </a>
                                
                                <div class="border-t"></div>
                                
                                <a href="/admin/logout" class="flex items-center gap-2 px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Se déconnecter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                <?= $this->section('content') ?>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/assets/js/main.js"></script>
</body>
</html>