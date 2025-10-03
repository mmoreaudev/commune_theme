<?php
/**
 * Mairie France - Functions
 * 
 * Configuration principale et chargement des modules du thème
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité : Empêche l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Constantes du thème
 */
define('MAIRIE_THEME_VERSION', '1.0.0');
define('MAIRIE_THEME_DIR', get_template_directory());
define('MAIRIE_THEME_URI', get_template_directory_uri());

/**
 * Configuration du thème
 */
function mairie_theme_setup() {
    // Support traduction
    load_theme_textdomain('mairie-france', MAIRIE_THEME_DIR . '/languages');
    
    // Support fonctionnalités WordPress
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    
    // Tailles d'images personnalisées
    add_image_size('mairie-featured', 1200, 600, true);
    add_image_size('mairie-thumbnail', 400, 300, true);
    add_image_size('mairie-card', 600, 400, true);
    add_image_size('mairie-hero', 1920, 800, true);
    add_image_size('mairie-team', 300, 300, true);
    
    // Support logo personnalisé
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Menus de navigation
    register_nav_menus(array(
        'primary'   => __('Menu Principal', 'mairie-france'),
        'footer'    => __('Menu Pied de Page', 'mairie-france'),
        'top-bar'   => __('Barre Supérieure', 'mairie-france'),
        'legal'     => __('Menu Mentions Légales', 'mairie-france'),
    ));
}
add_action('after_setup_theme', 'mairie_theme_setup');

/**
 * Configuration de la largeur du contenu
 */
if (!isset($content_width)) {
    $content_width = 1200;
}

/**
 * Enregistrement des zones de widgets
 */
function mairie_widgets_init() {
    // Sidebar principale
    register_sidebar(array(
        'name'          => __('Sidebar Principale', 'mairie-france'),
        'id'            => 'sidebar-main',
        'description'   => __('Widgets affichés sur toutes les pages avec sidebar', 'mairie-france'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Sidebar page d'accueil
    register_sidebar(array(
        'name'          => __('Sidebar Accueil', 'mairie-france'),
        'id'            => 'sidebar-home',
        'description'   => __('Widgets affichés uniquement sur la page d\'accueil', 'mairie-france'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer - Colonne 1
    register_sidebar(array(
        'name'          => __('Footer - Colonne 1', 'mairie-france'),
        'id'            => 'footer-1',
        'description'   => __('Première colonne du pied de page', 'mairie-france'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
    
    // Footer - Colonne 2
    register_sidebar(array(
        'name'          => __('Footer - Colonne 2', 'mairie-france'),
        'id'            => 'footer-2',
        'description'   => __('Deuxième colonne du pied de page', 'mairie-france'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
    
    // Footer - Colonne 3
    register_sidebar(array(
        'name'          => __('Footer - Colonne 3', 'mairie-france'),
        'id'            => 'footer-3',
        'description'   => __('Troisième colonne du pied de page', 'mairie-france'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
    
    // Footer - Colonne 4
    register_sidebar(array(
        'name'          => __('Footer - Colonne 4', 'mairie-france'),
        'id'            => 'footer-4',
        'description'   => __('Quatrième colonne du pied de page', 'mairie-france'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'mairie_widgets_init');

/**
 * Chargement des styles et scripts
 */
function mairie_enqueue_scripts() {
    // Styles
    wp_enqueue_style('mairie-main', MAIRIE_THEME_URI . '/assets/css/main.css', array(), MAIRIE_THEME_VERSION);
    wp_enqueue_style('mairie-responsive', MAIRIE_THEME_URI . '/assets/css/responsive.css', array('mairie-main'), MAIRIE_THEME_VERSION);
    wp_enqueue_style('mairie-accessibility', MAIRIE_THEME_URI . '/assets/css/accessibility.css', array('mairie-main'), MAIRIE_THEME_VERSION);
    
    // Scripts
    wp_enqueue_script('mairie-navigation', MAIRIE_THEME_URI . '/assets/js/navigation.js', array(), MAIRIE_THEME_VERSION, true);
    wp_enqueue_script('mairie-main', MAIRIE_THEME_URI . '/assets/js/main.js', array('jquery'), MAIRIE_THEME_VERSION, true);
    
    // Localisation pour AJAX
    wp_localize_script('mairie-main', 'mairieAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('mairie-ajax-nonce'),
        'strings' => array(
            'loading'    => __('Chargement...', 'mairie-france'),
            'error'      => __('Une erreur est survenue', 'mairie-france'),
            'no_results' => __('Aucun résultat trouvé', 'mairie-france'),
        )
    ));
    
    // Script commentaires si nécessaire
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mairie_enqueue_scripts');

/**
 * Chargement des styles et scripts admin
 */
function mairie_admin_enqueue_scripts($hook) {
    // Uniquement sur les pages d'édition de CPT
    $screens = array('post.php', 'post-new.php');
    if (!in_array($hook, $screens)) {
        return;
    }
    
    wp_enqueue_style('mairie-admin', MAIRIE_THEME_URI . '/assets/css/admin.css', array(), MAIRIE_THEME_VERSION);
    wp_enqueue_script('mairie-admin', MAIRIE_THEME_URI . '/assets/js/admin.js', array('jquery'), MAIRIE_THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'mairie_admin_enqueue_scripts');

/**
 * Chargement des modules du thème
 */
require_once MAIRIE_THEME_DIR . '/inc/custom-post-types.php';
require_once MAIRIE_THEME_DIR . '/inc/custom-fields.php';
require_once MAIRIE_THEME_DIR . '/inc/widgets.php';
require_once MAIRIE_THEME_DIR . '/inc/customizer.php';
require_once MAIRIE_THEME_DIR . '/inc/plugins-integration.php';
require_once MAIRIE_THEME_DIR . '/inc/navigation.php';
require_once MAIRIE_THEME_DIR . '/inc/accessibility.php';

/**
 * Fonction utilitaire : Récupérer une option du customizer
 */
function mairie_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

/**
 * Fonction utilitaire : Afficher le fil d'Ariane
 */
function mairie_breadcrumb() {
    get_template_part('parts/breadcrumb');
}

/**
 * Fonction utilitaire : Vérifier si une sidebar doit être affichée
 */
function mairie_has_sidebar() {
    // Pas de sidebar sur certains templates
    $no_sidebar_templates = array(
        'template-home.php',
        'template-contact.php',
    );
    
    if (is_page_template($no_sidebar_templates)) {
        return false;
    }
    
    return is_active_sidebar('sidebar-main');
}

/**
 * Personnalisation de l'excerpt
 */
function mairie_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'mairie_excerpt_length');

function mairie_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mairie_excerpt_more');

/**
 * Ajout de classes CSS body personnalisées
 */
function mairie_body_classes($classes) {
    if (mairie_has_sidebar()) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    if (is_front_page()) {
        $classes[] = 'is-home';
    }
    
    return $classes;
}
add_filter('body_class', 'mairie_body_classes');

/**
 * Désactivation de l'éditeur Gutenberg sur certains templates
 */
function mairie_disable_gutenberg($current_status, $post_type) {
    // Liste des templates où désactiver Gutenberg
    $disabled_templates = array(
        'template-home.php',
        'template-conseil-municipal.php',
        'template-numeros-utiles.php',
    );
    
    if ($post_type === 'page' && isset($_GET['post'])) {
        $template = get_post_meta($_GET['post'], '_wp_page_template', true);
        if (in_array($template, $disabled_templates)) {
            return false;
        }
    }
    
    return $current_status;
}
add_filter('use_block_editor_for_post', 'mairie_disable_gutenberg', 10, 2);
