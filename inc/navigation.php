<?php
/**
 * Navigation - Menus et navigation
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * Ajouter une classe active au menu parent
 */
function mairie_nav_menu_css_class($classes, $item, $args) {
    if (in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes)) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'mairie_nav_menu_css_class', 10, 3);

/**
 * Ajouter des attributs ARIA au menu
 */
function mairie_nav_menu_link_attributes($atts, $item, $args) {
    // Ajouter aria-current pour l'élément actif
    if (in_array('current-menu-item', $item->classes)) {
        $atts['aria-current'] = 'page';
    }
    
    // Ajouter aria-haspopup pour les menus avec sous-menus
    if (in_array('menu-item-has-children', $item->classes)) {
        $atts['aria-haspopup'] = 'true';
        $atts['aria-expanded'] = 'false';
    }
    
    return $atts;
}
add_filter('nav_menu_link_attributes', 'mairie_nav_menu_link_attributes', 10, 3);

/**
 * Ajouter un bouton toggle pour les sous-menus sur mobile
 */
function mairie_nav_menu_submenu_toggle($item_output, $item, $depth, $args) {
    if (in_array('menu-item-has-children', $item->classes)) {
        $item_output = str_replace(
            '</a>',
            '</a><button class="submenu-toggle" aria-expanded="false" aria-label="' . 
            esc_attr__('Afficher le sous-menu', 'mairie-france') . 
            '"><span class="icon-chevron-down" aria-hidden="true"></span></button>',
            $item_output
        );
    }
    
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'mairie_nav_menu_submenu_toggle', 10, 4);

/**
 * Pagination personnalisée
 */
function mairie_pagination($args = array()) {
    global $wp_query;
    
    $defaults = array(
        'mid_size'           => 2,
        'prev_text'          => '<span class="icon-arrow-left" aria-hidden="true"></span> ' . __('Précédent', 'mairie-france'),
        'next_text'          => __('Suivant', 'mairie-france') . ' <span class="icon-arrow-right" aria-hidden="true"></span>',
        'screen_reader_text' => __('Navigation de pagination', 'mairie-france'),
        'type'               => 'list',
        'before_page_number' => '<span class="screen-reader-text">' . __('Page', 'mairie-france') . ' </span>',
    );
    
    $args = wp_parse_args($args, $defaults);
    
    the_posts_pagination($args);
}

/**
 * Walker personnalisé pour le menu mobile
 */
class Mairie_Mobile_Nav_Walker extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\" role=\"menu\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . ' role="menuitem">';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Créer un menu de navigation si aucun n'existe
 */
function mairie_create_default_menu() {
    $menu_name = 'Menu Principal';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Ajouter des éléments par défaut
        $pages = array(
            'Accueil' => home_url('/'),
            'Actualités' => home_url('/actualites'),
            'Votre Mairie' => home_url('/votre-mairie'),
            'Publications' => home_url('/publications'),
            'Contact' => home_url('/contact'),
        );
        
        $order = 0;
        foreach ($pages as $title => $url) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'   => $title,
                'menu-item-url'     => $url,
                'menu-item-status'  => 'publish',
                'menu-item-position' => $order++,
            ));
        }
        
        // Assigner au theme location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'mairie_create_default_menu');
