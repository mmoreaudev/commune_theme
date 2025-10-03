<?php
/**
 * Template Name: Actualités
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-actualites">
    <div class="container">
        <?php mairie_breadcrumb(); ?>
        
        <div class="content-area with-sidebar">
            <div class="content-primary">
                
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <?php
                // Récupérer la catégorie filtrée si présente
                $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
                
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 12,
                    'paged'          => $paged,
                );
                
                if ($category) {
                    $args['category_name'] = $category;
                }
                
                $actualites = new WP_Query($args);
                
                if ($actualites->have_posts()) :
                    ?>
                    
                    <div class="posts-grid">
                        <?php
                        while ($actualites->have_posts()) :
                            $actualites->the_post();
                            get_template_part('parts/content', 'article');
                        endwhile;
                        ?>
                    </div>
                    
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('&laquo; Précédent', 'mairie-france'),
                        'next_text' => __('Suivant &raquo;', 'mairie-france'),
                    ));
                    
                    wp_reset_postdata();
                    ?>
                    
                <?php else : ?>
                    
                    <div class="no-results">
                        <h2><?php _e('Aucune actualité trouvée', 'mairie-france'); ?></h2>
                        <p><?php _e('Il n\'y a pas encore d\'actualité publiée.', 'mairie-france'); ?></p>
                    </div>
                    
                <?php endif; ?>
                
            </div>
            
            <!-- Sidebar -->
            <aside class="content-sidebar">
                <!-- Recherche -->
                <div class="widget widget-search">
                    <h3 class="widget-title"><?php _e('Rechercher', 'mairie-france'); ?></h3>
                    <?php get_search_form(); ?>
                </div>
                
                <!-- Catégories -->
                <div class="widget widget-categories">
                    <h3 class="widget-title"><?php _e('Catégories', 'mairie-france'); ?></h3>
                    <ul>
                        <li><a href="<?php echo esc_url(get_permalink()); ?>"><?php _e('Toutes', 'mairie-france'); ?></a></li>
                        <?php
                        wp_list_categories(array(
                            'title_li'    => '',
                            'show_count'  => true,
                            'hierarchical' => true,
                        ));
                        ?>
                    </ul>
                </div>
                
                <!-- Sidebar widgets -->
                <?php if (is_active_sidebar('sidebar-main')) : ?>
                    <?php dynamic_sidebar('sidebar-main'); ?>
                <?php endif; ?>
            </aside>
        </div>
        
    </div>
</main>

<?php
get_footer();
