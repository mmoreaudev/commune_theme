<?php
/**
 * Custom Post Types
 * 
 * Enregistrement des types de contenu personnalisés
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * Enregistrement des Custom Post Types
 */
function mairie_register_post_types() {
    
    // CPT Numéros Utiles
    register_post_type('numeros_utiles', array(
        'labels' => array(
            'name'                  => __('Numéros Utiles', 'mairie-france'),
            'singular_name'         => __('Numéro Utile', 'mairie-france'),
            'menu_name'             => __('Numéros Utiles', 'mairie-france'),
            'add_new'               => __('Ajouter un numéro', 'mairie-france'),
            'add_new_item'          => __('Ajouter un nouveau numéro', 'mairie-france'),
            'edit_item'             => __('Modifier le numéro', 'mairie-france'),
            'new_item'              => __('Nouveau numéro', 'mairie-france'),
            'view_item'             => __('Voir le numéro', 'mairie-france'),
            'search_items'          => __('Rechercher un numéro', 'mairie-france'),
            'not_found'             => __('Aucun numéro trouvé', 'mairie-france'),
            'not_found_in_trash'    => __('Aucun numéro dans la corbeille', 'mairie-france'),
            'all_items'             => __('Tous les numéros', 'mairie-france'),
        ),
        'public'                => true,
        'has_archive'           => false,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-phone',
        'supports'              => array('title', 'editor', 'thumbnail'),
        'rewrite'               => array('slug' => 'numero-utile'),
        'capability_type'       => 'post',
    ));
    
    // CPT Services Municipaux
    register_post_type('services', array(
        'labels' => array(
            'name'                  => __('Services Municipaux', 'mairie-france'),
            'singular_name'         => __('Service Municipal', 'mairie-france'),
            'menu_name'             => __('Services', 'mairie-france'),
            'add_new'               => __('Ajouter un service', 'mairie-france'),
            'add_new_item'          => __('Ajouter un nouveau service', 'mairie-france'),
            'edit_item'             => __('Modifier le service', 'mairie-france'),
            'new_item'              => __('Nouveau service', 'mairie-france'),
            'view_item'             => __('Voir le service', 'mairie-france'),
            'search_items'          => __('Rechercher un service', 'mairie-france'),
            'not_found'             => __('Aucun service trouvé', 'mairie-france'),
            'not_found_in_trash'    => __('Aucun service dans la corbeille', 'mairie-france'),
            'all_items'             => __('Tous les services', 'mairie-france'),
        ),
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'menu_position'         => 21,
        'menu_icon'             => 'dashicons-building',
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'               => array('slug' => 'services'),
        'capability_type'       => 'post',
    ));
    
    // CPT Associations
    register_post_type('associations', array(
        'labels' => array(
            'name'                  => __('Associations', 'mairie-france'),
            'singular_name'         => __('Association', 'mairie-france'),
            'menu_name'             => __('Associations', 'mairie-france'),
            'add_new'               => __('Ajouter une association', 'mairie-france'),
            'add_new_item'          => __('Ajouter une nouvelle association', 'mairie-france'),
            'edit_item'             => __('Modifier l\'association', 'mairie-france'),
            'new_item'              => __('Nouvelle association', 'mairie-france'),
            'view_item'             => __('Voir l\'association', 'mairie-france'),
            'search_items'          => __('Rechercher une association', 'mairie-france'),
            'not_found'             => __('Aucune association trouvée', 'mairie-france'),
            'not_found_in_trash'    => __('Aucune association dans la corbeille', 'mairie-france'),
            'all_items'             => __('Toutes les associations', 'mairie-france'),
        ),
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'menu_position'         => 22,
        'menu_icon'             => 'dashicons-groups',
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'               => array('slug' => 'associations'),
        'capability_type'       => 'post',
    ));
}
add_action('init', 'mairie_register_post_types');

/**
 * Enregistrement des taxonomies
 */
function mairie_register_taxonomies() {
    
    // Taxonomie pour les catégories de numéros utiles
    register_taxonomy('categorie_numero', array('numeros_utiles'), array(
        'labels' => array(
            'name'              => __('Catégories', 'mairie-france'),
            'singular_name'     => __('Catégorie', 'mairie-france'),
            'search_items'      => __('Rechercher une catégorie', 'mairie-france'),
            'all_items'         => __('Toutes les catégories', 'mairie-france'),
            'parent_item'       => __('Catégorie parente', 'mairie-france'),
            'parent_item_colon' => __('Catégorie parente :', 'mairie-france'),
            'edit_item'         => __('Modifier la catégorie', 'mairie-france'),
            'update_item'       => __('Mettre à jour', 'mairie-france'),
            'add_new_item'      => __('Ajouter une catégorie', 'mairie-france'),
            'new_item_name'     => __('Nouvelle catégorie', 'mairie-france'),
            'menu_name'         => __('Catégories', 'mairie-france'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categorie-numero'),
    ));
    
    // Taxonomie pour les catégories de services
    register_taxonomy('categorie_service', array('services'), array(
        'labels' => array(
            'name'              => __('Catégories de Services', 'mairie-france'),
            'singular_name'     => __('Catégorie', 'mairie-france'),
            'search_items'      => __('Rechercher une catégorie', 'mairie-france'),
            'all_items'         => __('Toutes les catégories', 'mairie-france'),
            'edit_item'         => __('Modifier la catégorie', 'mairie-france'),
            'update_item'       => __('Mettre à jour', 'mairie-france'),
            'add_new_item'      => __('Ajouter une catégorie', 'mairie-france'),
            'new_item_name'     => __('Nouvelle catégorie', 'mairie-france'),
            'menu_name'         => __('Catégories', 'mairie-france'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categorie-service'),
    ));
    
    // Taxonomie pour les catégories d'associations
    register_taxonomy('categorie_association', array('associations'), array(
        'labels' => array(
            'name'              => __('Catégories', 'mairie-france'),
            'singular_name'     => __('Catégorie', 'mairie-france'),
            'search_items'      => __('Rechercher une catégorie', 'mairie-france'),
            'all_items'         => __('Toutes les catégories', 'mairie-france'),
            'edit_item'         => __('Modifier la catégorie', 'mairie-france'),
            'update_item'       => __('Mettre à jour', 'mairie-france'),
            'add_new_item'      => __('Ajouter une catégorie', 'mairie-france'),
            'new_item_name'     => __('Nouvelle catégorie', 'mairie-france'),
            'menu_name'         => __('Catégories', 'mairie-france'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categorie-association'),
    ));
}
add_action('init', 'mairie_register_taxonomies');

/**
 * Création des termes par défaut pour catégories de numéros
 */
function mairie_create_default_numero_categories() {
    // Vérifier si déjà créées
    if (get_option('mairie_numero_categories_created')) {
        return;
    }
    
    $categories = array(
        'Urgences'        => 'Numéros d\'urgence (pompiers, police, SAMU...)',
        'Santé'           => 'Médecins, pharmacies, hôpitaux...',
        'Commerces'       => 'Magasins, commerces de proximité...',
        'Artisans'        => 'Plombiers, électriciens, menuisiers...',
        'Services Publics' => 'Mairie, préfecture, CAF...',
    );
    
    foreach ($categories as $name => $description) {
        if (!term_exists($name, 'categorie_numero')) {
            wp_insert_term($name, 'categorie_numero', array(
                'description' => $description,
                'slug'        => sanitize_title($name),
            ));
        }
    }
    
    // Marquer comme créées
    update_option('mairie_numero_categories_created', true);
}
add_action('init', 'mairie_create_default_numero_categories');

/**
 * Création des termes par défaut pour catégories d'associations
 */
function mairie_create_default_association_categories() {
    // Vérifier si déjà créées
    if (get_option('mairie_association_categories_created')) {
        return;
    }
    
    $categories = array(
        'Sport'    => 'Associations sportives',
        'Culture'  => 'Associations culturelles',
        'Social'   => 'Associations sociales et caritatives',
        'Loisirs'  => 'Clubs et associations de loisirs',
        'Éducation' => 'Associations éducatives',
    );
    
    foreach ($categories as $name => $description) {
        if (!term_exists($name, 'categorie_association')) {
            wp_insert_term($name, 'categorie_association', array(
                'description' => $description,
                'slug'        => sanitize_title($name),
            ));
        }
    }
    
    // Marquer comme créées
    update_option('mairie_association_categories_created', true);
}
add_action('init', 'mairie_create_default_association_categories');

/**
 * Modifier les colonnes affichées dans l'admin pour les numéros utiles
 */
function mairie_numeros_columns($columns) {
    $new_columns = array(
        'cb'        => $columns['cb'],
        'title'     => __('Nom', 'mairie-france'),
        'category'  => __('Catégorie', 'mairie-france'),
        'phone'     => __('Téléphone', 'mairie-france'),
        'email'     => __('Email', 'mairie-france'),
        'date'      => __('Date', 'mairie-france'),
    );
    
    return $new_columns;
}
add_filter('manage_numeros_utiles_posts_columns', 'mairie_numeros_columns');

/**
 * Remplir les colonnes personnalisées
 */
function mairie_numeros_custom_column($column, $post_id) {
    switch ($column) {
        case 'category':
            $terms = get_the_terms($post_id, 'categorie_numero');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo implode(', ', $term_names);
            } else {
                echo '—';
            }
            break;
            
        case 'phone':
            $phone = get_post_meta($post_id, '_mairie_numero_phone', true);
            echo $phone ? esc_html($phone) : '—';
            break;
            
        case 'email':
            $email = get_post_meta($post_id, '_mairie_numero_email', true);
            if ($email) {
                echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_numeros_utiles_posts_custom_column', 'mairie_numeros_custom_column', 10, 2);

/**
 * Rendre les colonnes triables
 */
function mairie_numeros_sortable_columns($columns) {
    $columns['phone'] = 'phone';
    $columns['category'] = 'category';
    return $columns;
}
add_filter('manage_edit-numeros_utiles_sortable_columns', 'mairie_numeros_sortable_columns');
