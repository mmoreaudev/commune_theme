<?php
/**
 * Accessibilité (RGAA)
 * 
 * Fonctions pour améliorer l'accessibilité du thème
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * Ajouter attributs alt manquants aux images
 */
function mairie_add_missing_alt_tags($content) {
    // Rechercher toutes les balises img sans alt
    $content = preg_replace('/<img((?![^>]*alt=)[^>]*)>/i', '<img$1 alt="">', $content);
    return $content;
}
add_filter('the_content', 'mairie_add_missing_alt_tags');

/**
 * Ajouter role et aria-label aux formulaires de recherche
 */
function mairie_search_form_accessibility($form) {
    $form = str_replace(
        '<form',
        '<form role="search" aria-label="' . esc_attr__('Recherche', 'mairie-france') . '"',
        $form
    );
    
    // Ajouter label pour le champ de recherche
    $form = str_replace(
        'type="search"',
        'type="search" aria-label="' . esc_attr__('Rechercher sur le site', 'mairie-france') . '"',
        $form
    );
    
    return $form;
}
add_filter('get_search_form', 'mairie_search_form_accessibility');

/**
 * Améliorer l'accessibilité des read more links
 */
function mairie_excerpt_more_accessible($more) {
    global $post;
    return '... <a href="' . get_permalink($post->ID) . '" class="read-more" aria-label="' . 
           sprintf(esc_attr__('Lire la suite de %s', 'mairie-france'), get_the_title($post->ID)) . '">' . 
           __('Lire la suite', 'mairie-france') . ' <span aria-hidden="true">&raquo;</span></a>';
}
add_filter('excerpt_more', 'mairie_excerpt_more_accessible');

/**
 * Ajouter attributs ARIA aux widgets
 */
function mairie_widget_aria($params) {
    // Ajouter role et aria-label à la zone de widget
    $params[0]['before_widget'] = str_replace(
        'class="widget',
        'role="complementary" class="widget',
        $params[0]['before_widget']
    );
    
    return $params;
}
add_filter('dynamic_sidebar_params', 'mairie_widget_aria');

/**
 * Améliorer les titres de page pour les lecteurs d'écran
 */
function mairie_document_title_parts($title) {
    if (is_404()) {
        $title['title'] = __('Page non trouvée (404)', 'mairie-france');
    } elseif (is_search()) {
        $title['title'] = sprintf(__('Résultats de recherche pour : %s', 'mairie-france'), get_search_query());
    } elseif (is_archive()) {
        $title['title'] = get_the_archive_title();
    }
    
    return $title;
}
add_filter('document_title_parts', 'mairie_document_title_parts');

/**
 * Ajouter landmark roles
 */
function mairie_add_landmark_roles() {
    ?>
    <script>
    // Ajouter des rôles ARIA via JavaScript pour compatibilité
    document.addEventListener('DOMContentLoaded', function() {
        // Header
        var header = document.querySelector('.site-header');
        if (header && !header.hasAttribute('role')) {
            header.setAttribute('role', 'banner');
        }
        
        // Footer
        var footer = document.querySelector('.site-footer');
        if (footer && !footer.hasAttribute('role')) {
            footer.setAttribute('role', 'contentinfo');
        }
        
        // Navigation
        var nav = document.querySelector('.main-navigation');
        if (nav && !nav.hasAttribute('role')) {
            nav.setAttribute('role', 'navigation');
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'mairie_add_landmark_roles');

/**
 * Améliorer le contraste des couleurs
 */
function mairie_check_color_contrast() {
    // Fonction utilitaire pour vérifier le contraste
    // Peut être utilisée pour valider les couleurs du customizer
}

/**
 * Permettre la navigation au clavier dans les accordéons
 */
function mairie_accordion_keyboard_support() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Support clavier pour les accordéons
        var accordions = document.querySelectorAll('.accordion-item');
        
        accordions.forEach(function(accordion) {
            var button = accordion.querySelector('.accordion-header');
            if (!button) return;
            
            button.setAttribute('role', 'button');
            button.setAttribute('tabindex', '0');
            
            // Enter et Space pour activer
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    button.click();
                }
            });
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'mairie_accordion_keyboard_support');

/**
 * Vérifier et améliorer la hiérarchie des titres
 */
function mairie_check_heading_hierarchy($content) {
    // Cette fonction peut être étendue pour vérifier la hiérarchie des titres
    return $content;
}
add_filter('the_content', 'mairie_check_heading_hierarchy', 11);

/**
 * Ajouter des indications pour les champs obligatoires
 */
function mairie_required_field_indicator() {
    ?>
    <style>
    .required,
    .wpcf7-form-control-wrap .wpcf7-not-valid-tip {
        color: #d63638;
    }
    
    label .required::after,
    label.required::after {
        content: " *";
        color: #d63638;
    }
    
    .required-info {
        font-size: 0.9em;
        color: #646970;
        margin-bottom: 1em;
    }
    
    .required-info::before {
        content: "* ";
        color: #d63638;
    }
    </style>
    <?php
}
add_action('wp_head', 'mairie_required_field_indicator');

/**
 * Focus visible pour la navigation au clavier
 */
function mairie_focus_styles() {
    ?>
    <style>
    /* Focus visible pour accessibilité */
    a:focus,
    button:focus,
    input:focus,
    textarea:focus,
    select:focus {
        outline: 2px solid var(--color-primary, #000091);
        outline-offset: 2px;
    }
    
    /* Skip link visible au focus */
    .skip-link:focus {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999999;
        padding: 1em;
        background: #000091;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    
    /* Indicateur focus pour navigation */
    .main-navigation a:focus,
    .widget a:focus {
        background-color: rgba(0, 0, 145, 0.1);
    }
    </style>
    <?php
}
add_action('wp_head', 'mairie_focus_styles');

/**
 * Textes alternatifs pour les icônes décoratives
 */
function mairie_decorative_icons() {
    // Les icônes décoratives doivent avoir aria-hidden="true"
    // Cette fonction peut être utilisée pour s'assurer que c'est le cas
}

/**
 * Informations sur l'accessibilité dans l'admin
 */
function mairie_accessibility_admin_notice() {
    $screen = get_current_screen();
    
    if ($screen->id === 'themes') {
        ?>
        <div class="notice notice-info">
            <p>
                <strong><?php _e('Accessibilité RGAA', 'mairie-france'); ?></strong><br>
                <?php _e('Ce thème a été développé en respectant les normes RGAA (Référentiel Général d\'Amélioration de l\'Accessibilité).', 'mairie-france'); ?>
                <?php _e('Pour maintenir cette conformité, assurez-vous de :', 'mairie-france'); ?>
            </p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><?php _e('Ajouter des textes alternatifs à toutes les images', 'mairie-france'); ?></li>
                <li><?php _e('Utiliser une hiérarchie de titres logique (h1, h2, h3...)', 'mairie-france'); ?></li>
                <li><?php _e('Maintenir un contraste suffisant pour les textes', 'mairie-france'); ?></li>
                <li><?php _e('Tester la navigation au clavier', 'mairie-france'); ?></li>
            </ul>
        </div>
        <?php
    }
}
add_action('admin_notices', 'mairie_accessibility_admin_notice');
