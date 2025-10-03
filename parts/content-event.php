<?php
/**
 * Template part pour afficher un événement
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Vérifier que The Events Calendar est actif
if (!class_exists('Tribe__Events__Main')) {
    return;
}
?>

<article id="event-<?php the_ID(); ?>" <?php post_class('event-card'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="event-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('mairie-card', array('loading' => 'lazy')); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="event-content">
        
        <div class="event-date-badge">
            <span class="event-day"><?php echo tribe_get_start_date(null, false, 'd'); ?></span>
            <span class="event-month"><?php echo tribe_get_start_date(null, false, 'M'); ?></span>
        </div>
        
        <header class="event-header">
            <?php the_title('<h2 class="event-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
            
            <div class="event-meta">
                <time class="event-datetime" datetime="<?php echo esc_attr(tribe_get_start_date(null, false, 'c')); ?>">
                    <span class="icon-clock" aria-hidden="true"></span>
                    <?php echo tribe_get_start_date(null, false, 'H:i'); ?>
                </time>
                
                <?php if ($venue = tribe_get_venue()) : ?>
                    <span class="event-venue">
                        <span class="icon-map" aria-hidden="true"></span>
                        <?php echo esc_html($venue); ?>
                    </span>
                <?php endif; ?>
            </div>
        </header>
        
        <?php if (has_excerpt()) : ?>
            <div class="event-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
        
        <a href="<?php the_permalink(); ?>" class="button button-outline">
            <?php _e('Voir les détails', 'mairie-france'); ?>
        </a>
        
    </div>
    
</article>
