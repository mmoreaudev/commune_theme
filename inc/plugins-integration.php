<?php
/**
 * Intégration des plugins
 * 
 * Support et intégration native des plugins requis
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * The Events Calendar - Support et personnalisation
 */
function mairie_events_calendar_support() {
    if (!class_exists('Tribe__Events__Main')) {
        return;
    }
    
    // Personnaliser les slugs
    add_filter('tribe_events_single_event_the_meta_group_venue', '__return_true');
    
    // Modifier le nombre d'événements par page
    add_filter('tribe_events_views_v2_view_repository_args', 'mairie_events_per_page', 10, 3);
}
add_action('after_setup_theme', 'mairie_events_calendar_support');

function mairie_events_per_page($repository_args, $context, $view) {
    $repository_args['posts_per_page'] = get_theme_mod('home_events_count', 3);
    return $repository_args;
}

/**
 * Our Team Members - Styles personnalisés
 */
function mairie_team_members_support() {
    if (!function_exists('our_team_enhanced_init')) {
        return;
    }
    
    // Ajouter des classes CSS personnalisées
    add_filter('our_team_enhanced_wrapper_class', function($class) {
        return $class . ' mairie-team-grid';
    });
}
add_action('after_setup_theme', 'mairie_team_members_support');

/**
 * Download Manager - Configuration
 */
function mairie_download_manager_support() {
    if (!function_exists('wpdm_init')) {
        return;
    }
    
    // Personnaliser les templates
    add_filter('wpdm_default_template', function() {
        return 'link-template-default';
    });
}
add_action('after_setup_theme', 'mairie_download_manager_support');

/**
 * TablePress - Styles personnalisés
 */
function mairie_tablepress_support() {
    if (!class_exists('TablePress')) {
        return;
    }
    
    // Ajouter responsive par défaut
    add_filter('tablepress_table_output_options', function($options) {
        $options['table_head'] = true;
        $options['table_foot'] = false;
        $options['alternating_row_colors'] = true;
        return $options;
    });
}
add_action('after_setup_theme', 'mairie_tablepress_support');

/**
 * Contact Form 7 - Personnalisation
 */
function mairie_cf7_support() {
    if (!function_exists('wpcf7')) {
        return;
    }
    
    // Retirer les CSS par défaut (on utilise les nôtres)
    add_filter('wpcf7_load_css', '__return_false');
    
    // Personnaliser les messages
    add_filter('wpcf7_display_message', 'mairie_cf7_custom_messages', 10, 2);
}
add_action('after_setup_theme', 'mairie_cf7_support');

function mairie_cf7_custom_messages($message, $status) {
    if ($status == 'mail_sent') {
        $message = '<div class="alert alert-success" role="alert">' . $message . '</div>';
    } elseif ($status == 'mail_failed' || $status == 'validation_failed') {
        $message = '<div class="alert alert-error" role="alert">' . $message . '</div>';
    }
    return $message;
}

/**
 * Accordion - Support
 */
function mairie_accordion_support() {
    // Désactiver les styles par défaut si nécessaire
    // add_action('wp_enqueue_scripts', function() {
    //     wp_dequeue_style('accordion-style');
    // }, 100);
}
add_action('after_setup_theme', 'mairie_accordion_support');

/**
 * Vérification des plugins requis
 */
function mairie_check_required_plugins() {
    $required_plugins = array(
        'The Events Calendar'        => class_exists('Tribe__Events__Main'),
        'Our Team Members'           => function_exists('our_team_enhanced_init'),
        'Download Manager'           => function_exists('wpdm_init'),
        'TablePress'                 => class_exists('TablePress'),
        'Contact Form 7'             => function_exists('wpcf7'),
        'UpdraftPlus'                => class_exists('UpdraftPlus'),
        'Wordfence'                  => class_exists('wordfence'),
    );
    
    $missing_plugins = array();
    foreach ($required_plugins as $plugin => $active) {
        if (!$active) {
            $missing_plugins[] = $plugin;
        }
    }
    
    if (!empty($missing_plugins) && current_user_can('install_plugins')) {
        add_action('admin_notices', function() use ($missing_plugins) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><strong><?php _e('Mairie France - Plugins recommandés', 'mairie-france'); ?></strong></p>
                <p><?php _e('Pour profiter de toutes les fonctionnalités du thème, veuillez installer et activer les plugins suivants :', 'mairie-france'); ?></p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <?php foreach ($missing_plugins as $plugin) : ?>
                        <li><?php echo esc_html($plugin); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        });
    }
}
add_action('admin_init', 'mairie_check_required_plugins');

/**
 * AJAX - Filtrer les numéros utiles
 */
function mairie_ajax_filter_numeros() {
    check_ajax_referer('mairie-ajax-nonce', 'nonce');
    
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $search   = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    
    $args = array(
        'post_type'      => 'numeros_utiles',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    );
    
    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie_numero',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }
    
    if ($search) {
        $args['s'] = $search;
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) {
        echo '<div class="numeros-grid">';
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('parts/content', 'numero');
        }
        echo '</div>';
    } else {
        echo '<p class="no-results">' . __('Aucun numéro trouvé.', 'mairie-france') . '</p>';
    }
    
    wp_reset_postdata();
    
    $html = ob_get_clean();
    
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_filter_numeros', 'mairie_ajax_filter_numeros');
add_action('wp_ajax_nopriv_filter_numeros', 'mairie_ajax_filter_numeros');

/**
 * AJAX - Filtrer les événements
 */
function mairie_ajax_filter_events() {
    check_ajax_referer('mairie-ajax-nonce', 'nonce');
    
    if (!class_exists('Tribe__Events__Main')) {
        wp_send_json_error(array('message' => __('The Events Calendar non activé', 'mairie-france')));
    }
    
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $month    = isset($_POST['month']) ? sanitize_text_field($_POST['month']) : '';
    
    $args = array(
        'posts_per_page' => 12,
        'start_date'     => 'now',
    );
    
    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => Tribe__Events__Main::TAXONOMY,
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }
    
    $events = tribe_get_events($args);
    
    ob_start();
    
    if ($events) {
        echo '<div class="events-grid">';
        foreach ($events as $event) {
            setup_postdata($event);
            get_template_part('parts/content', 'event');
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p class="no-results">' . __('Aucun événement trouvé.', 'mairie-france') . '</p>';
    }
    
    $html = ob_get_clean();
    
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_filter_events', 'mairie_ajax_filter_events');
add_action('wp_ajax_nopriv_filter_events', 'mairie_ajax_filter_events');

/**
 * Shortcode pour afficher un tableau TablePress responsive
 */
function mairie_tablepress_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
    ), $atts);
    
    if (empty($atts['id']) || !class_exists('TablePress')) {
        return '';
    }
    
    return do_shortcode('[table id="' . $atts['id'] . '" responsive="scroll" /]');
}
add_shortcode('mairie_table', 'mairie_tablepress_shortcode');

/**
 * Shortcode pour afficher un formulaire Contact Form 7
 */
function mairie_cf7_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
    ), $atts);
    
    if (empty($atts['id']) || !function_exists('wpcf7_contact_form')) {
        return '';
    }
    
    return do_shortcode('[contact-form-7 id="' . $atts['id'] . '"]');
}
add_shortcode('mairie_contact_form', 'mairie_cf7_shortcode');
