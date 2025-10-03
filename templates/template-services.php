<?php
/**
 * Template Name: Services Municipaux
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-services">
    <div class="container">
        <?php mairie_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if (get_the_content()) : ?>
                <div class="page-description">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </header>
        
        <!-- Liste des services -->
        <div class="services-grid">
            <?php
            $services = new WP_Query(array(
                'post_type'      => 'services',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ));
            
            if ($services->have_posts()) :
                while ($services->have_posts()) :
                    $services->the_post();
                    
                    $responsable   = get_post_meta(get_the_ID(), '_mairie_service_responsable', true);
                    $phone         = get_post_meta(get_the_ID(), '_mairie_service_phone', true);
                    $email         = get_post_meta(get_the_ID(), '_mairie_service_email', true);
                    $horaires      = get_post_meta(get_the_ID(), '_mairie_service_horaires', true);
                    $localisation  = get_post_meta(get_the_ID(), '_mairie_service_localisation', true);
                    ?>
                    
                    <article class="service-card" id="service-<?php the_ID(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="service-icon">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="service-content">
                            <h2 class="service-title"><?php the_title(); ?></h2>
                            
                            <?php if (has_excerpt()) : ?>
                                <div class="service-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <ul class="service-meta">
                                <?php if ($responsable) : ?>
                                    <li>
                                        <strong><?php _e('Responsable:', 'mairie-france'); ?></strong>
                                        <?php echo esc_html($responsable); ?>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if ($phone) : ?>
                                    <li>
                                        <span class="icon-phone" aria-hidden="true"></span>
                                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                                            <?php echo esc_html($phone); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if ($email) : ?>
                                    <li>
                                        <span class="icon-email" aria-hidden="true"></span>
                                        <a href="mailto:<?php echo esc_attr($email); ?>">
                                            <?php echo esc_html($email); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if ($localisation) : ?>
                                    <li>
                                        <span class="icon-map" aria-hidden="true"></span>
                                        <?php echo esc_html($localisation); ?>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if ($horaires) : ?>
                                    <li class="service-horaires">
                                        <span class="icon-clock" aria-hidden="true"></span>
                                        <div><?php echo nl2br(esc_html($horaires)); ?></div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            
                            <a href="<?php the_permalink(); ?>" class="button button-outline">
                                <?php _e('En savoir plus', 'mairie-france'); ?>
                            </a>
                        </div>
                    </article>
                    
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p><?php _e('Aucun service n\'a encore été ajouté.', 'mairie-france'); ?></p>
                <?php
            endif;
            ?>
        </div>
        
    </div>
</main>

<?php
get_footer();
