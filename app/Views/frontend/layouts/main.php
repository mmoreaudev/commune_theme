<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Mairie') ?></title>
    <meta name="description" content="<?= e(setting('site_description', 'Site officiel de la commune')) ?>">
    <meta name="keywords" content="<?= e(setting('site_keywords', 'mairie, commune, municipalité')) ?>">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuration Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000091',
                        secondary: '#E1000F',
                        'france-blue': '#000091',
                        'france-red': '#E1000F'
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
    
    <!-- Alpine.js pour interactivité -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
</head>
<body class="font-sans antialiased bg-gray-50">
    
    <!-- Skip Links (RGAA) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-0 focus:left-0 bg-primary text-white p-2 z-50">Aller au contenu principal</a>
    
    <?php include __DIR__ . '/header.php'; ?>
    
    <!-- Main Content -->
    <main id="main-content" class="min-h-screen">
        <?= $content ?? '' ?>
    </main>
    
    <?php include __DIR__ . '/footer.php'; ?>
    
    <!-- Scripts -->
    <script src="<?= asset('js/main.js') ?>"></script>
    
    <!-- Messages Flash -->
    <?php if (hasFlash('success')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <?= e(flash('success')) ?>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200">&times;</button>
        </div>
    <?php endif; ?>
    
    <?php if (hasFlash('error')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" 
             class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <?= e(flash('error')) ?>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200">&times;</button>
        </div>
    <?php endif; ?>
    
</body>
</html>