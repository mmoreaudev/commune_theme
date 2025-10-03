<?php
/**
 * Customizer - Options du thème
 * 
 * Configuration du panneau d'options WordPress
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * Enregistrement des options du Customizer
 */
function mairie_customize_register($wp_customize) {
    
    // ===== SECTION : Identité de la Commune =====
    $wp_customize->add_section('mairie_commune', array(
        'title'       => __('Identité de la Commune', 'mairie-france'),
        'description' => __('Informations principales de votre commune', 'mairie-france'),
        'priority'    => 20,
    ));
    
    // Nom de la commune
    $wp_customize->add_setting('commune_name', array(
        'default'           => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('commune_name', array(
        'label'    => __('Nom de la commune', 'mairie-france'),
        'section'  => 'mairie_commune',
        'type'     => 'text',
        'priority' => 10,
    ));
    
    // Slogan
    $wp_customize->add_setting('commune_slogan', array(
        'default'           => get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('commune_slogan', array(
        'label'    => __('Slogan / Devise', 'mairie-france'),
        'section'  => 'mairie_commune',
        'type'     => 'text',
        'priority' => 20,
    ));
    
    // Blason/Armoiries
    $wp_customize->add_setting('commune_blason', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'commune_blason', array(
        'label'    => __('Blason / Armoiries', 'mairie-france'),
        'section'  => 'mairie_commune',
        'priority' => 30,
    )));
    
    // ===== SECTION : Coordonnées =====
    $wp_customize->add_section('mairie_contact', array(
        'title'       => __('Coordonnées', 'mairie-france'),
        'description' => __('Informations de contact de la mairie', 'mairie-france'),
        'priority'    => 30,
    ));
    
    // Adresse
    $wp_customize->add_setting('contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('contact_address', array(
        'label'       => __('Adresse complète', 'mairie-france'),
        'description' => __('L\'adresse de la mairie', 'mairie-france'),
        'section'     => 'mairie_contact',
        'type'        => 'textarea',
        'priority'    => 10,
    ));
    
    // Téléphone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_phone', array(
        'label'    => __('Téléphone', 'mairie-france'),
        'section'  => 'mairie_contact',
        'type'     => 'tel',
        'priority' => 20,
    ));
    
    // Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => get_bloginfo('admin_email'),
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email', array(
        'label'    => __('Email', 'mairie-france'),
        'section'  => 'mairie_contact',
        'type'     => 'email',
        'priority' => 30,
    ));
    
    // Horaires (court)
    $wp_customize->add_setting('contact_horaires', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_horaires', array(
        'label'       => __('Horaires (format court)', 'mairie-france'),
        'description' => __('Ex: Lun-Ven 9h-17h', 'mairie-france'),
        'section'     => 'mairie_contact',
        'type'        => 'text',
        'priority'    => 40,
    ));
    
    // Horaires (détaillés)
    $wp_customize->add_setting('contact_horaires_full', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('contact_horaires_full', array(
        'label'       => __('Horaires détaillés', 'mairie-france'),
        'description' => __('Pour affichage dans le footer', 'mairie-france'),
        'section'     => 'mairie_contact',
        'type'        => 'textarea',
        'priority'    => 50,
    ));
    
    // Lien Google Maps
    $wp_customize->add_setting('contact_maps_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('contact_maps_url', array(
        'label'       => __('Lien Google Maps', 'mairie-france'),
        'description' => __('URL complète vers Google Maps', 'mairie-france'),
        'section'     => 'mairie_contact',
        'type'        => 'url',
        'priority'    => 60,
    ));
    
    // Code embed Google Maps
    $wp_customize->add_setting('contact_maps_embed', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('contact_maps_embed', array(
        'label'       => __('Code Embed Google Maps', 'mairie-france'),
        'description' => __('Code iframe de Google Maps', 'mairie-france'),
        'section'     => 'mairie_contact',
        'type'        => 'textarea',
        'priority'    => 70,
    ));
    
    // ===== SECTION : Réseaux Sociaux =====
    $wp_customize->add_section('mairie_social', array(
        'title'       => __('Réseaux Sociaux', 'mairie-france'),
        'description' => __('Liens vers vos profils sur les réseaux sociaux', 'mairie-france'),
        'priority'    => 40,
    ));
    
    $social_networks = array(
        'facebook'  => __('Facebook', 'mairie-france'),
        'twitter'   => __('Twitter / X', 'mairie-france'),
        'instagram' => __('Instagram', 'mairie-france'),
        'youtube'   => __('YouTube', 'mairie-france'),
        'linkedin'  => __('LinkedIn', 'mairie-france'),
    );
    
    $priority = 10;
    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('social_' . $network, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('social_' . $network, array(
            'label'    => $label,
            'section'  => 'mairie_social',
            'type'     => 'url',
            'priority' => $priority,
        ));
        $priority += 10;
    }
    
    // ===== SECTION : Couleurs =====
    $wp_customize->add_section('mairie_colors', array(
        'title'       => __('Couleurs du Thème', 'mairie-france'),
        'description' => __('Personnalisez les couleurs principales', 'mairie-france'),
        'priority'    => 50,
    ));
    
    // Couleur primaire
    $wp_customize->add_setting('color_primary', array(
        'default'           => '#000091',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_primary', array(
        'label'    => __('Couleur Primaire', 'mairie-france'),
        'section'  => 'mairie_colors',
        'priority' => 10,
    )));
    
    // Couleur secondaire
    $wp_customize->add_setting('color_secondary', array(
        'default'           => '#E1000F',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_secondary', array(
        'label'    => __('Couleur Secondaire', 'mairie-france'),
        'section'  => 'mairie_colors',
        'priority' => 20,
    )));
    
    // Couleur des liens
    $wp_customize->add_setting('color_links', array(
        'default'           => '#000091',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_links', array(
        'label'    => __('Couleur des Liens', 'mairie-france'),
        'section'  => 'mairie_colors',
        'priority' => 30,
    )));
    
    // Couleur footer
    $wp_customize->add_setting('color_footer', array(
        'default'           => '#161616',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_footer', array(
        'label'    => __('Couleur du Footer', 'mairie-france'),
        'section'  => 'mairie_colors',
        'priority' => 40,
    )));
    
    // ===== SECTION : Page d'Accueil =====
    $wp_customize->add_section('mairie_home', array(
        'title'       => __('Page d\'Accueil', 'mairie-france'),
        'description' => __('Paramètres de la section hero', 'mairie-france'),
        'priority'    => 60,
    ));
    
    // Image Hero
    $wp_customize->add_setting('home_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'home_hero_image', array(
        'label'    => __('Image Hero', 'mairie-france'),
        'section'  => 'mairie_home',
        'priority' => 10,
    )));
    
    // Titre Hero
    $wp_customize->add_setting('home_hero_title', array(
        'default'           => __('Bienvenue sur le site de votre commune', 'mairie-france'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('home_hero_title', array(
        'label'    => __('Titre Hero', 'mairie-france'),
        'section'  => 'mairie_home',
        'type'     => 'text',
        'priority' => 20,
    ));
    
    // Sous-titre Hero
    $wp_customize->add_setting('home_hero_subtitle', array(
        'default'           => __('Toute l\'actualité et les services de votre mairie', 'mairie-france'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('home_hero_subtitle', array(
        'label'    => __('Sous-titre Hero', 'mairie-france'),
        'section'  => 'mairie_home',
        'type'     => 'text',
        'priority' => 30,
    ));
    
    // Bouton CTA - Texte
    $wp_customize->add_setting('home_hero_cta_text', array(
        'default'           => __('Découvrir', 'mairie-france'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('home_hero_cta_text', array(
        'label'    => __('Texte du bouton', 'mairie-france'),
        'section'  => 'mairie_home',
        'type'     => 'text',
        'priority' => 40,
    ));
    
    // Bouton CTA - Lien
    $wp_customize->add_setting('home_hero_cta_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('home_hero_cta_url', array(
        'label'    => __('Lien du bouton', 'mairie-france'),
        'section'  => 'mairie_home',
        'type'     => 'url',
        'priority' => 50,
    ));
    
    // Nombre d'actualités sur l'accueil
    $wp_customize->add_setting('home_posts_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('home_posts_count', array(
        'label'       => __('Nombre d\'actualités', 'mairie-france'),
        'description' => __('Nombre d\'articles à afficher sur l\'accueil', 'mairie-france'),
        'section'     => 'mairie_home',
        'type'        => 'number',
        'priority'    => 60,
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 12,
            'step' => 1,
        ),
    ));
    
    // Nombre d'événements sur l'accueil
    $wp_customize->add_setting('home_events_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('home_events_count', array(
        'label'       => __('Nombre d\'événements', 'mairie-france'),
        'description' => __('Nombre d\'événements à afficher sur l\'accueil', 'mairie-france'),
        'section'     => 'mairie_home',
        'type'        => 'number',
        'priority'    => 70,
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 12,
            'step' => 1,
        ),
    ));
    
    // ===== SECTION : Footer =====
    $wp_customize->add_section('mairie_footer', array(
        'title'       => __('Footer', 'mairie-france'),
        'description' => __('Paramètres du pied de page', 'mairie-france'),
        'priority'    => 70,
    ));
    
    // Copyright
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => sprintf(
            __('&copy; %1$s %2$s - Tous droits réservés', 'mairie-france'),
            date('Y'),
            get_bloginfo('name')
        ),
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('footer_copyright', array(
        'label'    => __('Texte Copyright', 'mairie-france'),
        'section'  => 'mairie_footer',
        'type'     => 'textarea',
        'priority' => 10,
    ));
    
    // Afficher crédits du thème
    $wp_customize->add_setting('footer_show_credits', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('footer_show_credits', array(
        'label'    => __('Afficher les crédits du thème', 'mairie-france'),
        'section'  => 'mairie_footer',
        'type'     => 'checkbox',
        'priority' => 20,
    ));
}
add_action('customize_register', 'mairie_customize_register');

/**
 * CSS personnalisé généré depuis le Customizer
 */
function mairie_customizer_css() {
    $color_primary   = get_theme_mod('color_primary', '#000091');
    $color_secondary = get_theme_mod('color_secondary', '#E1000F');
    $color_links     = get_theme_mod('color_links', '#000091');
    $color_footer    = get_theme_mod('color_footer', '#161616');
    ?>
    <style type="text/css">
        :root {
            --color-primary: <?php echo esc_attr($color_primary); ?>;
            --color-secondary: <?php echo esc_attr($color_secondary); ?>;
            --color-links: <?php echo esc_attr($color_links); ?>;
            --color-footer: <?php echo esc_attr($color_footer); ?>;
        }
        
        /* Couleur primaire */
        .button-primary,
        .site-header,
        .main-navigation,
        .widget-title,
        .entry-meta a:hover {
            background-color: <?php echo esc_attr($color_primary); ?>;
        }
        
        /* Couleur secondaire */
        .button-secondary,
        .widget-numeros-urgence .numero-urgence:hover {
            background-color: <?php echo esc_attr($color_secondary); ?>;
        }
        
        /* Liens */
        a,
        .entry-title a:hover {
            color: <?php echo esc_attr($color_links); ?>;
        }
        
        /* Footer */
        .site-footer {
            background-color: <?php echo esc_attr($color_footer); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'mairie_customizer_css');

/**
 * JavaScript pour live preview dans le Customizer
 */
function mairie_customizer_live_preview() {
    wp_enqueue_script(
        'mairie-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array('jquery', 'customize-preview'),
        MAIRIE_THEME_VERSION,
        true
    );
}
add_action('customize_preview_init', 'mairie_customizer_live_preview');
