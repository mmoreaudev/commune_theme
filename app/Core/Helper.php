<?php
/**
 * Fonctions Helper - Utilitaires globaux
 */

/**
 * Obtenir une configuration
 */
function config($key, $default = null)
{
    static $config = null;
    
    if ($config === null) {
        $config = require __DIR__ . '/../Config/app.php';
    }
    
    $keys = explode('.', $key);
    $value = $config;
    
    foreach ($keys as $k) {
        if (!isset($value[$k])) {
            return $default;
        }
        $value = $value[$k];
    }
    
    return $value;
}

/**
 * Obtenir un paramètre de configuration du site
 */
function setting($key, $default = null)
{
    static $settings = null;
    
    if ($settings === null) {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
        $results = $stmt->fetchAll();
        
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    
    return $settings[$key] ?? $default;
}

/**
 * Créer un slug à partir d'un texte
 */
function slugify($text)
{
    // Remplacer les caractères accentués
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    
    // Convertir en minuscules
    $text = strtolower($text);
    
    // Remplacer les caractères non alphanumériques par des tirets
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    
    // Supprimer les tirets en début et fin
    $text = trim($text, '-');
    
    return $text;
}

/**
 * Échapper du HTML
 */
function e($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Formater une date
 */
function formatDate($date, $format = 'd/m/Y')
{
    if (!$date) {
        return '';
    }
    
    $timestamp = is_numeric($date) ? $date : strtotime($date);
    return date($format, $timestamp);
}

/**
 * Formater une date avec l'heure
 */
function formatDateTime($date, $format = 'd/m/Y H:i')
{
    return formatDate($date, $format);
}

/**
 * Obtenir l'URL complète
 */
function url($path = '')
{
    return Router::url($path);
}

/**
 * Obtenir l'URL des assets
 */
function asset($path)
{
    return url('assets/' . ltrim($path, '/'));
}

/**
 * Obtenir l'utilisateur connecté
 */
function auth()
{
    return Auth::user();
}

/**
 * Vérifier si l'utilisateur est connecté
 */
function isLoggedIn()
{
    return Auth::check();
}

/**
 * Obtenir un message flash
 */
function flash($key)
{
    return Session::getFlash($key);
}

/**
 * Vérifier si un message flash existe
 */
function hasFlash($key)
{
    return Session::hasFlash($key);
}

/**
 * Token CSRF
 */
function csrf_token()
{
    return Session::csrfToken();
}

/**
 * Champ CSRF caché
 */
function csrf_field()
{
    return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
}

/**
 * Limiter le nombre de caractères
 */
function str_limit($string, $limit = 100, $end = '...')
{
    if (strlen($string) <= $limit) {
        return $string;
    }
    
    return substr($string, 0, $limit) . $end;
}

/**
 * Obtenir l'extrait d'un texte
 */
function excerpt($text, $limit = 150)
{
    $text = strip_tags($text);
    return str_limit($text, $limit);
}

/**
 * Pluraliser un mot
 */
function pluralize($count, $singular, $plural = null)
{
    if ($plural === null) {
        $plural = $singular . 's';
    }
    
    return $count === 1 ? $singular : $plural;
}

/**
 * Obtenir le temps écoulé depuis une date
 */
function timeAgo($date)
{
    $time = is_numeric($date) ? $date : strtotime($date);
    $diff = time() - $time;
    
    if ($diff < 60) {
        return 'à l\'instant';
    } elseif ($diff < 3600) {
        $minutes = intval($diff / 60);
        return "il y a {$minutes} " . pluralize($minutes, 'minute');
    } elseif ($diff < 86400) {
        $hours = intval($diff / 3600);
        return "il y a {$hours} " . pluralize($hours, 'heure');
    } elseif ($diff < 2592000) {
        $days = intval($diff / 86400);
        return "il y a {$days} " . pluralize($days, 'jour');
    } else {
        return formatDate($date);
    }
}

/**
 * Obtenir la pagination HTML
 */
function paginate($pagination, $baseUrl)
{
    if ($pagination['total_pages'] <= 1) {
        return '';
    }
    
    $html = '<nav class="flex justify-center mt-8"><ul class="flex space-x-2">';
    
    // Page précédente
    if ($pagination['has_prev']) {
        $prevPage = $pagination['current_page'] - 1;
        $html .= '<li><a href="' . $baseUrl . '?page=' . $prevPage . '" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded">Précédent</a></li>';
    }
    
    // Pages
    $start = max(1, $pagination['current_page'] - 2);
    $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
    
    for ($i = $start; $i <= $end; $i++) {
        $class = $i === $pagination['current_page'] ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300';
        $html .= '<li><a href="' . $baseUrl . '?page=' . $i . '" class="px-3 py-2 ' . $class . ' rounded">' . $i . '</a></li>';
    }
    
    // Page suivante
    if ($pagination['has_next']) {
        $nextPage = $pagination['current_page'] + 1;
        $html .= '<li><a href="' . $baseUrl . '?page=' . $nextPage . '" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded">Suivant</a></li>';
    }
    
    $html .= '</ul></nav>';
    
    return $html;
}

/**
 * Vérifier si la route actuelle correspond
 */
function isActiveRoute($route)
{
    $currentRoute = $_SERVER['REQUEST_URI'];
    return strpos($currentRoute, $route) === 0;
}

/**
 * Classe CSS active pour navigation
 */
function activeRoute($route, $class = 'active')
{
    return isActiveRoute($route) ? $class : '';
}

/**
 * Afficher les erreurs de validation
 */
function showErrors($field)
{
    if (Session::hasFlash('errors')) {
        $errors = Session::getFlash('errors');
        if (isset($errors[$field])) {
            $html = '<div class="text-red-500 text-sm mt-1">';
            foreach ($errors[$field] as $error) {
                $html .= '<div>' . e($error) . '</div>';
            }
            $html .= '</div>';
            return $html;
        }
    }
    return '';
}

/**
 * Obtenir l'ancienne valeur d'un champ
 */
function old($field, $default = '')
{
    $oldData = Session::getFlash('old');
    return $oldData[$field] ?? $default;
}

/**
 * Rendre les widgets d'une zone
 */
function renderWidgets($zone = 'sidebar-main')
{
    $widgets = Widget::where('zone', $zone);
    $widgets = array_filter($widgets, function($widget) {
        return $widget['is_active'] == 1;
    });
    
    // Trier par position
    usort($widgets, function($a, $b) {
        return $a['order_position'] <=> $b['order_position'];
    });
    
    foreach ($widgets as $widget) {
        $templatePath = __DIR__ . '/../Views/frontend/components/widgets/' . $widget['widget_type'] . '.php';
        if (file_exists($templatePath)) {
            include $templatePath;
        }
    }
}