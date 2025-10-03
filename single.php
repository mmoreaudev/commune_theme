<?php
/**
 * Template pour les articles individuels
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
                
                <?php
                while (have_posts()) :
                    the_post();
                ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
                        <header class="entry-header">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            
                            <div class="entry-meta">
                                <span class="posted-on">
                                    <span class="icon-calendar" aria-hidden="true"></span>
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </span>
                                
                                <?php if (has_category()) : ?>
                                    <span class="categories">
                                        <span class="icon-folder" aria-hidden="true"></span>
                                        <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <span class="author">
                                    <span class="icon-user" aria-hidden="true"></span>
                                    <?php the_author_posts_link(); ?>
                                </span>
                            </div>
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
                        
                        <footer class="entry-footer">
                            <?php if (has_tag()) : ?>
                                <div class="tags-links">
                                    <span class="icon-tag" aria-hidden="true"></span>
                                    <?php the_tags('', ', '); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (get_edit_post_link()) : ?>
                                <?php
                                edit_post_link(
                                    __('Modifier', 'mairie-france'),
                                    '<span class="edit-link">',
                                    '</span>'
                                );
                                ?>
                            <?php endif; ?>
                        </footer>
                        
                    </article>
                    
                    <!-- Navigation article précédent/suivant -->
                    <nav class="post-navigation" aria-label="<?php esc_attr_e('Navigation entre articles', 'mairie-france'); ?>">
                        <div class="nav-links">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if ($prev_post) : ?>
                                <div class="nav-previous">
                                    <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" rel="prev">
                                        <span class="nav-subtitle"><?php _e('Article précédent', 'mairie-france'); ?></span>
                                        <span class="nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($next_post) : ?>
                                <div class="nav-next">
                                    <a href="<?php echo esc_url(get_permalink($next_post)); ?>" rel="next">
                                        <span class="nav-subtitle"><?php _e('Article suivant', 'mairie-france'); ?></span>
                                        <span class="nav-title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </nav>
                    
                    <?php
                    // Commentaires si activés
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                    
                <?php endwhile; ?>
                
            </div>
            
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();
