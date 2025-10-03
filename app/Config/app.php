<?php
/**
 * Configuration de l'application
 */

return [
    'app' => [
        'name' => 'CMS Mairie',
        'version' => '1.0.0',
        'debug' => $_ENV['APP_DEBUG'] ?? false,
        'url' => $_ENV['APP_URL'] ?? 'http://vpn.mateomoreau.com:8024',
        'timezone' => 'Europe/Paris'
    ],
    
    'database' => [
        'path' => $_ENV['DB_PATH'] ?? __DIR__ . '/../../database/mairie.db'
    ],
    
    'upload' => [
        'max_size' => $_ENV['UPLOAD_MAX_SIZE'] ?? '50M',
        'allowed_images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'allowed_documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'ods']
    ],
    
    'session' => [
        'lifetime' => $_ENV['SESSION_LIFETIME'] ?? 120, // minutes
        'name' => 'mairie_session',
        'secure' => false, // true en HTTPS
        'httponly' => true
    ],
    
    'mail' => [
        'from_email' => $_ENV['MAIL_FROM'] ?? 'contact@mairie.fr',
        'from_name' => $_ENV['MAIL_FROM_NAME'] ?? 'Mairie'
    ],
    
    'pagination' => [
        'per_page' => 10,
        'posts_per_page' => 6,
        'events_per_page' => 12
    ]
];