<?php
/**
 * CMS Mairie - Point d'entrée principal
 * 
 * @author mmoreaudev
 * @version 1.0.0
 * @date 2025-10-03
 */

// Configuration des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration de base
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('DATABASE_PATH', BASE_PATH . '/database');

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/Core/',
        APP_PATH . '/Controllers/Frontend/', 
        APP_PATH . '/Controllers/Admin/',
        APP_PATH . '/Models/',
        APP_PATH . '/Middleware/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    return false;
});

// Charger la configuration (fichiers dans app/Config)
if (file_exists(APP_PATH . '/Config/app.php')) {
    require_once APP_PATH . '/Config/app.php';
}

try {
    // Initialiser la base de données
    $database = Database::getInstance();
    
    // Créer l'instance du router
    $router = new Router();
    
    // Charger les routes (définies dans app/Config/routes.php)
    if (file_exists(APP_PATH . '/Config/routes.php')) {
        require_once APP_PATH . '/Config/routes.php';
    }
    
    // Résoudre la route actuelle
    $router->resolve();
    
} catch (Exception $e) {
    // Gestion d'erreur améliorée
    error_log('CMS Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    
    http_response_code(500);
    
    // Page d'erreur personnalisée
    if (file_exists(APP_PATH . '/Views/frontend/pages/500.php')) {
        include APP_PATH . '/Views/frontend/pages/500.php';
    } else {
        // Page d'erreur de fallback
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erreur 500 - CMS Mairie</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body class="bg-red-50 min-h-screen flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-md text-center">
                <div class="text-red-500 text-6xl mb-4">⚠️</div>
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Erreur du serveur</h1>
                <p class="text-gray-600 mb-6">Une erreur est survenue. Veuillez réessayer plus tard.</p>
                <?php if (defined('APP_DEBUG') && APP_DEBUG): ?>
                    <div class="bg-red-100 border border-red-300 p-4 rounded-md text-left">
                        <h3 class="font-semibold text-red-800">Détails de l'erreur :</h3>
                        <p class="text-red-700 font-mono text-sm"><?= htmlspecialchars($e->getMessage()) ?></p>
                        <p class="text-red-600 text-xs mt-2">
                            <?= htmlspecialchars($e->getFile()) ?>:<?= $e->getLine() ?>
                        </p>
                    </div>
                <?php endif; ?>
                <div class="mt-6">
                    <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}