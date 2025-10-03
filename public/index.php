<?php
/**
 * CMS Mairie - Point d'entrée principal
 * 
 * @author mmoreaudev
 * @version 1.0.0
 * @date 2025-10-03
 */

// Démarrer la session
session_start();

// Gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Autoloader simple
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/Core/',
        __DIR__ . '/../app/Controllers/Frontend/',
        __DIR__ . '/../app/Controllers/Admin/',
        __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Middleware/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Charger les helpers
require_once __DIR__ . '/../app/Core/Helper.php';

// Initialiser l'application
try {
    // Créer l'instance du router
    $router = new Router();
    
    // Charger les routes
    require_once __DIR__ . '/../app/Config/routes.php';
    
    // Résoudre la route actuelle
    $router->resolve();
    
} catch (Exception $e) {
    // Logger l'erreur
    error_log($e->getMessage());
    
    // Afficher page d'erreur
    http_response_code(500);
    if (file_exists(__DIR__ . '/../app/Views/frontend/pages/500.php')) {
        include __DIR__ . '/../app/Views/frontend/pages/500.php';
    } else {
        echo "Une erreur est survenue. Veuillez réessayer plus tard.";
    }
}