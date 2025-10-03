<?php
/**
 * Template pour les pages
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
                
                <?php
                while (have_posts()) :
                    the_post();
                ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
                        <header class="entry-header">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        </header>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="entry-thumbnail">
                                <?php the_post_thumbnail('mairie-featured', array('loading' => 'eager')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="entry-content">
                            <?php
                            the_content();
                            
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . __('Pages :', 'mairie-france'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>
                        
                        <?php if (get_edit_post_link()) : ?>
                            <footer class="entry-footer">
                                <?php
                                edit_post_link(
                                    __('Modifier', 'mairie-france'),
                                    '<span class="edit-link">',
                                    '</span>'
                                );
                                ?>
                            </footer>
                        <?php endif; ?>
                        
                    </article>
                    
                    <?php
                    // Commentaires si activés
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                    
                <?php endwhile; ?>
                
            </div>
            
            <?php if (mairie_has_sidebar()) : ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
get_footer();
