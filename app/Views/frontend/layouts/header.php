<!-- Header -->
<header class="bg-white shadow-md">
    <!-- Top bar -->
    <div class="bg-france-blue text-white">
        <div class="container mx-auto px-4 py-2">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center space-x-4">
                    <span>📍 <?= e(setting('city_name')) ?></span>
                    <?php if (setting('address')): ?>
                        <span class="hidden md:inline"><?= e(setting('address')) ?></span>
                    <?php endif; ?>
                </div>
                <div class="flex gap-4">
                    <?php if (setting('phone')): ?>
                        <a href="tel:<?= e(setting('phone')) ?>" class="hover:underline">
                            📞 <?= e(setting('phone')) ?>
                        </a>
                    <?php endif; ?>
                    <a href="/votre-mairie/contact" class="hover:underline">✉️ Contact</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main header -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-4 hover:opacity-90">
                    <img src="<?= asset('images/logo.png') ?>" alt="Logo <?= e(setting('city_name')) ?>" class="h-16 w-16 object-contain">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900"><?= e(setting('city_name')) ?></h1>
                        <?php if (setting('slogan')): ?>
                            <p class="text-sm text-gray-600"><?= e(setting('slogan')) ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            
            <!-- Search -->
            <div class="hidden md:block">
                <form action="/recherche" method="GET" class="flex">
                    <input type="search" name="q" placeholder="Rechercher..." 
                           value="<?= e($_GET['q'] ?? '') ?>"
                           class="px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary">
                        🔍
                    </button>
                </form>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="bg-gray-100" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4">
            <!-- Desktop Navigation -->
            <ul class="hidden md:flex space-x-6 py-3">
                <li>
                    <a href="/" class="hover:text-primary transition-colors <?= isActiveRoute('/') ? 'text-primary font-semibold' : 'text-gray-700' ?>">
                        Accueil
                    </a>
                </li>
                <li class="relative group">
                    <a href="/actualites" class="hover:text-primary transition-colors <?= isActiveRoute('/actualites') ? 'text-primary font-semibold' : 'text-gray-700' ?>">
                        Actualités
                    </a>
                </li>
                <li class="relative group">
                    <a href="/votre-mairie" class="hover:text-primary transition-colors <?= isActiveRoute('/votre-mairie') ? 'text-primary font-semibold' : 'text-gray-700' ?>">
                        Votre Mairie
                    </a>
                    <!-- Sous-menu -->
                    <ul class="absolute left-0 top-full bg-white shadow-lg rounded-md py-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <li><a href="/votre-mairie/conseil-municipal" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Le Conseil Municipal</a></li>
                        <li><a href="/votre-mairie/services" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Services Municipaux</a></li>
                        <li><a href="/votre-mairie/contact" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Contact</a></li>
                    </ul>
                </li>
                <li class="relative group">
                    <a href="/publications" class="hover:text-primary transition-colors <?= isActiveRoute('/publications') ? 'text-primary font-semibold' : 'text-gray-700' ?>">
                        Publications
                    </a>
                    <!-- Sous-menu -->
                    <ul class="absolute left-0 top-full bg-white shadow-lg rounded-md py-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <li><a href="/publications/bulletins" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Bulletins Municipaux</a></li>
                        <li><a href="/publications/magazines" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Magazines</a></li>
                        <li><a href="/publications/deliberations" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Délibérations</a></li>
                    </ul>
                </li>
                <li class="relative group">
                    <a href="/infos-pratiques" class="hover:text-primary transition-colors <?= isActiveRoute('/infos-pratiques') ? 'text-primary font-semibold' : 'text-gray-700' ?>">
                        Infos Pratiques
                    </a>
                    <!-- Sous-menu -->
                    <ul class="absolute left-0 top-full bg-white shadow-lg rounded-md py-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <li><a href="/infos-pratiques/horaires" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Horaires</a></li>
                        <li><a href="/infos-pratiques/demarches" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Démarches</a></li>
                        <li><a href="/infos-pratiques/faq" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">FAQ</a></li>
                        <li><a href="/infos-pratiques/numeros-utiles" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Numéros Utiles</a></li>
                    </ul>
                </li>
                <li class="relative group">
                    <a href="/vie-locale" class="hover:text-primary transition-colors <?= isActiveRoute('/vie-locale') ? 'text-primary font-semibold' : 'text-gray-700' ?>">
                        Vie Locale
                    </a>
                    <!-- Sous-menu -->
                    <ul class="absolute left-0 top-full bg-white shadow-lg rounded-md py-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <li><a href="/vie-locale/associations" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Associations</a></li>
                        <li><a href="/evenements" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Événements</a></li>
                    </ul>
                </li>
            </ul>
            
            <!-- Mobile Navigation -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden py-4">
                <ul class="space-y-2">
                    <li><a href="/" class="block py-2 <?= isActiveRoute('/') ? 'text-primary font-semibold' : 'text-gray-700' ?>">Accueil</a></li>
                    <li><a href="/actualites" class="block py-2 <?= isActiveRoute('/actualites') ? 'text-primary font-semibold' : 'text-gray-700' ?>">Actualités</a></li>
                    <li>
                        <div class="py-2 font-semibold text-gray-800">Votre Mairie</div>
                        <ul class="ml-4 space-y-1">
                            <li><a href="/votre-mairie/conseil-municipal" class="block py-1 text-sm text-gray-600">Le Conseil Municipal</a></li>
                            <li><a href="/votre-mairie/services" class="block py-1 text-sm text-gray-600">Services Municipaux</a></li>
                            <li><a href="/votre-mairie/contact" class="block py-1 text-sm text-gray-600">Contact</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="py-2 font-semibold text-gray-800">Publications</div>
                        <ul class="ml-4 space-y-1">
                            <li><a href="/publications/bulletins" class="block py-1 text-sm text-gray-600">Bulletins Municipaux</a></li>
                            <li><a href="/publications/magazines" class="block py-1 text-sm text-gray-600">Magazines</a></li>
                            <li><a href="/publications/deliberations" class="block py-1 text-sm text-gray-600">Délibérations</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="py-2 font-semibold text-gray-800">Infos Pratiques</div>
                        <ul class="ml-4 space-y-1">
                            <li><a href="/infos-pratiques/horaires" class="block py-1 text-sm text-gray-600">Horaires</a></li>
                            <li><a href="/infos-pratiques/demarches" class="block py-1 text-sm text-gray-600">Démarches</a></li>
                            <li><a href="/infos-pratiques/faq" class="block py-1 text-sm text-gray-600">FAQ</a></li>
                            <li><a href="/infos-pratiques/numeros-utiles" class="block py-1 text-sm text-gray-600">Numéros Utiles</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="py-2 font-semibold text-gray-800">Vie Locale</div>
                        <ul class="ml-4 space-y-1">
                            <li><a href="/vie-locale/associations" class="block py-1 text-sm text-gray-600">Associations</a></li>
                            <li><a href="/evenements" class="block py-1 text-sm text-gray-600">Événements</a></li>
                        </ul>
                    </li>
                    
                    <!-- Mobile search -->
                    <li class="pt-4">
                        <form action="/recherche" method="GET" class="flex">
                            <input type="search" name="q" placeholder="Rechercher..." 
                                   value="<?= e($_GET['q'] ?? '') ?>"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-primary">
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-r hover:bg-blue-700">
                                🔍
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>