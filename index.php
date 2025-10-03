<?php
/**
 * Template principal - Index
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">
        <?php mairie_breadcrumb(); ?>
        
        <div class="content-area <?php echo mairie_has_sidebar() ? 'with-sidebar' : 'full-width'; ?>">
            <div class="content-primary">
                
                <header class="page-header">
                    <?php if (is_home()) : ?>
                        <h1 class="page-title"><?php _e('Actualités', 'mairie-france'); ?></h1>
                    <?php elseif (is_archive()) : ?>
                        <h1 class="page-title"><?php the_archive_title(); ?></h1>
                        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                    <?php elseif (is_search()) : ?>
                        <h1 class="page-title">
                            <?php printf(__('Résultats de recherche pour : %s', 'mairie-france'), '<span>' . get_search_query() . '</span>'); ?>
                        </h1>
                    <?php endif; ?>
                </header>
                
                <?php if (have_posts()) : ?>
                    
                    <div class="posts-grid">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('parts/content', get_post_type());
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
                    ?>
                    
                <?php else : ?>
                    
                    <div class="no-results">
                        <h2><?php _e('Aucun résultat trouvé', 'mairie-france'); ?></h2>
                        <p><?php _e('Désolé, aucun contenu ne correspond à votre recherche. Veuillez réessayer avec d\'autres mots-clés.', 'mairie-france'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                    
                <?php endif; ?>
                
            </div>
            
            <?php if (mairie_has_sidebar()) : ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
get_footer();
