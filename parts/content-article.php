<?php
/**
 * Template part pour afficher un article
 * 
 * @package Mairie_France
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('mairie-card', array('loading' => 'lazy')); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="post-content">
        
        <header class="post-header">
            <?php the_title('<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
            
            <div class="post-meta">
                <time class="post-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <span class="icon-calendar" aria-hidden="true"></span>
                    <?php echo get_the_date(); ?>
                </time>
                
                <?php if (has_category()) : ?>
                    <span class="post-category">
                        <span class="icon-folder" aria-hidden="true"></span>
                        <?php the_category(', '); ?>
                    </span>
                <?php endif; ?>
            </div>
        </header>
        
        <div class="post-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <a href="<?php the_permalink(); ?>" class="read-more" aria-label="<?php echo esc_attr(sprintf(__('Lire l\'article : %s', 'mairie-france'), get_the_title())); ?>">
            <?php _e('Lire la suite', 'mairie-france'); ?> &raquo;
        </a>
        
    </div>
    
</article>
