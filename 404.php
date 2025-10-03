<?php
/**
 * Template 404 - Page non trouvée
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">
        
        <div class="content-area full-width">
            <div class="error-404">
                
                <header class="page-header">
                    <h1 class="page-title"><?php _e('404', 'mairie-france'); ?></h1>
                    <p class="error-subtitle"><?php _e('Page non trouvée', 'mairie-france'); ?></p>
                </header>
                
                <div class="error-content">
                    <p><?php _e('Désolé, la page que vous recherchez semble introuvable.', 'mairie-france'); ?></p>
                    <p><?php _e('Elle a peut-être été déplacée ou supprimée. Voici quelques suggestions :', 'mairie-france'); ?></p>
                    
                    <div class="error-actions">
                        <!-- Recherche -->
                        <div class="error-search">
                            <h2><?php _e('Rechercher', 'mairie-france'); ?></h2>
                            <?php get_search_form(); ?>
                        </div>
                        
                        <!-- Liens rapides -->
                        <div class="error-links">
                            <h2><?php _e('Pages principales', 'mairie-france'); ?></h2>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Accueil', 'mairie-france'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/actualites')); ?>"><?php _e('Actualités', 'mairie-france'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/votre-mairie')); ?>"><?php _e('Votre Mairie', 'mairie-france'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php _e('Contact', 'mairie-france'); ?></a></li>
                            </ul>
                        </div>
                        
                        <!-- Articles récents -->
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish'
                        ));
                        
                        if ($recent_posts) :
                        ?>
                            <div class="error-recent">
                                <h2><?php _e('Dernières actualités', 'mairie-france'); ?></h2>
                                <ul>
                                    <?php foreach ($recent_posts as $post) : ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>">
                                                <?php echo esc_html($post['post_title']); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                    
                    <div class="error-back">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="button button-primary">
                            <?php _e('Retour à l\'accueil', 'mairie-france'); ?>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</main>

<?php
get_footer();
