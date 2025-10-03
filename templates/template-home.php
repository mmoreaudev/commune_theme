<?php
/**
 * Template Name: Page d'Accueil
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-home">
    
    <?php
    // Section Hero
    get_template_part('parts/hero', 'section');
    ?>
    
    <div class="container">
        
        <!-- Actualités récentes -->
        <section class="home-section home-actualites">
            <div class="section-header">
                <h2 class="section-title"><?php _e('Dernières Actualités', 'mairie-france'); ?></h2>
                <a href="<?php echo esc_url(home_url('/actualites')); ?>" class="section-link">
                    <?php _e('Toutes les actualités', 'mairie-france'); ?> &raquo;
                </a>
            </div>
            
            <div class="posts-grid">
                <?php
                $posts_count = get_theme_mod('home_posts_count', 3);
                $recent_posts = new WP_Query(array(
                    'posts_per_page' => $posts_count,
                    'post_status'    => 'publish',
                ));
                
                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) :
                        $recent_posts->the_post();
                        get_template_part('parts/content', 'article');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('Aucune actualité pour le moment.', 'mairie-france') . '</p>';
                endif;
                ?>
            </div>
        </section>
        
        <!-- Prochains événements -->
        <?php if (class_exists('Tribe__Events__Main')) : ?>
        <section class="home-section home-evenements">
            <div class="section-header">
                <h2 class="section-title"><?php _e('Prochains Événements', 'mairie-france'); ?></h2>
                <a href="<?php echo esc_url(home_url('/evenements')); ?>" class="section-link">
                    <?php _e('Voir l\'agenda complet', 'mairie-france'); ?> &raquo;
                </a>
            </div>
            
            <div class="events-grid">
                <?php
                $events_count = get_theme_mod('home_events_count', 3);
                $events = tribe_get_events(array(
                    'posts_per_page' => $events_count,
                    'start_date'     => 'now',
                ));
                
                if ($events) :
                    foreach ($events as $event) :
                        setup_postdata($event);
                        get_template_part('parts/content', 'event');
                    endforeach;
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('Aucun événement à venir.', 'mairie-france') . '</p>';
                endif;
                ?>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- Accès rapides -->
        <section class="home-section home-acces-rapides">
            <h2 class="section-title"><?php _e('Accès Rapides', 'mairie-france'); ?></h2>
            
            <div class="acces-rapides-grid">
                <a href="<?php echo esc_url(home_url('/votre-mairie')); ?>" class="acces-rapide-card">
                    <span class="card-icon icon-building" aria-hidden="true"></span>
                    <h3><?php _e('Votre Mairie', 'mairie-france'); ?></h3>
                    <p><?php _e('Découvrez vos élus et les services municipaux', 'mairie-france'); ?></p>
                </a>
                
                <a href="<?php echo esc_url(home_url('/publications')); ?>" class="acces-rapide-card">
                    <span class="card-icon icon-file" aria-hidden="true"></span>
                    <h3><?php _e('Publications', 'mairie-france'); ?></h3>
                    <p><?php _e('Bulletins municipaux, magazines et délibérations', 'mairie-france'); ?></p>
                </a>
                
                <a href="<?php echo esc_url(home_url('/infos-pratiques')); ?>" class="acces-rapide-card">
                    <span class="card-icon icon-info" aria-hidden="true"></span>
                    <h3><?php _e('Infos Pratiques', 'mairie-france'); ?></h3>
                    <p><?php _e('Horaires, démarches administratives et FAQ', 'mairie-france'); ?></p>
                </a>
                
                <a href="<?php echo esc_url(home_url('/numeros-utiles')); ?>" class="acces-rapide-card">
                    <span class="card-icon icon-phone" aria-hidden="true"></span>
                    <h3><?php _e('Numéros Utiles', 'mairie-france'); ?></h3>
                    <p><?php _e('Tous les contacts dont vous pourriez avoir besoin', 'mairie-france'); ?></p>
                </a>
                
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="acces-rapide-card">
                    <span class="card-icon icon-email" aria-hidden="true"></span>
                    <h3><?php _e('Contact', 'mairie-france'); ?></h3>
                    <p><?php _e('Contactez la mairie et situez-nous', 'mairie-france'); ?></p>
                </a>
                
                <a href="<?php echo esc_url(home_url('/associations')); ?>" class="acces-rapide-card">
                    <span class="card-icon icon-groups" aria-hidden="true"></span>
                    <h3><?php _e('Associations', 'mairie-france'); ?></h3>
                    <p><?php _e('Découvrez la vie associative locale', 'mairie-france'); ?></p>
                </a>
            </div>
        </section>
        
        <!-- Widgets sidebar accueil -->
        <?php if (is_active_sidebar('sidebar-home')) : ?>
        <aside class="home-sidebar">
            <?php dynamic_sidebar('sidebar-home'); ?>
        </aside>
        <?php endif; ?>
        
    </div>
    
</main>

<?php
get_footer();
