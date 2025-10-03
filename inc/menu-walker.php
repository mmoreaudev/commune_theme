<?php
/**
 * Walker Menu Tailwind - Mairie France Theme
 * Custom Walker pour les menus WordPress avec classes Tailwind CSS
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * Walker personnalisé pour les menus avec Tailwind CSS
 */
class Mairie_Nav_Walker extends Walker_Nav_Menu {
    
    /**
     * Début d'un élément de menu
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Classes Tailwind selon le niveau
        if ($depth === 0) {
            $li_class = 'relative group';
            $link_class = 'block px-4 py-2 lg:py-4 text-gray-800 hover:text-[#000091] transition-colors font-medium text-base';
        } else {
            $li_class = 'relative border-b border-gray-100 last:border-0';
            $link_class = 'block px-6 py-3 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#000091] transition-colors';
        }
        
        // Classe active
        if (in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes)) {
            $link_class .= ' text-[#000091] font-bold border-l-4 lg:border-l-0 lg:border-b-2 border-[#000091]';
        }
        
        // Si a des enfants
        $has_children = in_array('menu-item-has-children', $classes);
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($li_class . ' ' . $class_names) . '"' : ' class="' . esc_attr($li_class) . '"';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = $link_class;
        
        if ($has_children) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }
        
        if (in_array('current-menu-item', $classes)) {
            $atts['aria-current'] = 'page';
        }
        
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
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . $title . (isset($args->link_after) ? $args->link_after : '');
        
        // Icône pour sous-menu
        if ($has_children) {
            if ($depth === 0) {
                $item_output .= ' <i class="fas fa-chevron-down ml-1 text-xs transition-transform lg:group-hover:rotate-180"></i>';
            } else {
                $item_output .= ' <i class="fas fa-chevron-right ml-1 text-xs"></i>';
            }
        }
        
        $item_output .= '</a>';
        
        // Bouton toggle pour mobile si a des enfants
        if ($has_children) {
            $item_output .= '<button class="submenu-toggle lg:hidden absolute right-2 top-2 p-2 text-gray-600 hover:text-[#000091]" aria-expanded="false" aria-label="' . esc_attr__('Ouvrir le sous-menu', 'mairie-france') . '">';
            $item_output .= '<i class="fas fa-chevron-down text-xs transition-transform"></i>';
            $item_output .= '</button>';
        }
        
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /**
     * Début d'un sous-menu
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if ($depth === 0) {
            // Premier niveau de sous-menu (dropdown)
            $classes = 'sub-menu hidden lg:absolute lg:left-0 lg:top-full lg:min-w-[220px] lg:bg-white lg:shadow-xl lg:rounded-lg lg:py-2 lg:mt-0 lg:group-hover:block lg:z-50 border-t-2 border-[#000091]';
        } else {
            // Sous-sous-menu
            $classes = 'sub-menu hidden pl-4 lg:pl-0 lg:absolute lg:left-full lg:top-0 lg:min-w-[220px] lg:bg-white lg:shadow-xl lg:rounded-lg lg:py-2 border-t-2 border-[#000091]';
        }
        
        $output .= "\n$indent<ul class=\"$classes\">\n";
    }
}
