<?php
/**
 * Template pour les archives
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">
        <?php mairie_breadcrumb(); ?>
        
        <div class="content-area with-sidebar">
            <div class="content-primary">
                
                <header class="page-header">
                    <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="archive-description">', '</div>');
                    ?>
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
                        <h2><?php _e('Aucun contenu trouvé', 'mairie-france'); ?></h2>
                        <p><?php _e('Aucun contenu n\'a été trouvé dans cette section.', 'mairie-france'); ?></p>
                    </div>
                    
                <?php endif; ?>
                
            </div>
            
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();
