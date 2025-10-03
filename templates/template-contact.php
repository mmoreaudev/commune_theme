<?php
/**
 * Template Name: Contact
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-contact">
    <div class="container">
        <?php mairie_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>
        
        <div class="contact-layout">
            
            <!-- Formulaire de contact -->
            <div class="contact-form-section">
                <h2><?php _e('Envoyez-nous un message', 'mairie-france'); ?></h2>
                
                <?php if (get_the_content()) : ?>
                    <div class="contact-intro">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
                
                <?php
                // Intégration Contact Form 7
                if (function_exists('wpcf7_contact_form')) {
                    // Afficher le premier formulaire trouvé ou celui spécifié
                    $cf7_id = get_post_meta(get_the_ID(), '_mairie_cf7_id', true);
                    
                    if ($cf7_id) {
                        echo do_shortcode('[contact-form-7 id="' . $cf7_id . '"]');
                    } else {
                        // Chercher le premier formulaire
                        $forms = get_posts(array(
                            'post_type'      => 'wpcf7_contact_form',
                            'posts_per_page' => 1,
                        ));
                        
                        if ($forms) {
                            echo do_shortcode('[contact-form-7 id="' . $forms[0]->ID . '"]');
                        } else {
                            echo '<p>' . __('Aucun formulaire de contact n\'est configuré.', 'mairie-france') . '</p>';
                        }
                    }
                } else {
                    echo '<p>' . __('Le plugin Contact Form 7 n\'est pas installé.', 'mairie-france') . '</p>';
                }
                ?>
            </div>
            
            <!-- Informations de contact -->
            <aside class="contact-info-section">
                
                <!-- Coordonnées -->
                <div class="contact-info-box">
                    <h3><?php _e('Coordonnées', 'mairie-france'); ?></h3>
                    
                    <address class="contact-details">
                        <?php if ($name = mairie_get_option('commune_name')) : ?>
                            <strong><?php echo esc_html($name); ?></strong><br>
                        <?php endif; ?>
                        
                        <?php if ($address = mairie_get_option('contact_address')) : ?>
                            <?php echo nl2br(esc_html($address)); ?><br>
                        <?php endif; ?>
                        
                        <?php if ($phone = mairie_get_option('contact_phone')) : ?>
                            <div class="contact-item">
                                <span class="icon-phone" aria-hidden="true"></span>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($email = mairie_get_option('contact_email')) : ?>
                            <div class="contact-item">
                                <span class="icon-email" aria-hidden="true"></span>
                                <a href="mailto:<?php echo esc_attr($email); ?>">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </address>
                </div>
                
                <!-- Horaires -->
                <?php if ($horaires = mairie_get_option('contact_horaires_full')) : ?>
                <div class="contact-info-box">
                    <h3><?php _e('Horaires d\'ouverture', 'mairie-france'); ?></h3>
                    <div class="horaires-content">
                        <?php echo wpautop(wp_kses_post($horaires)); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Accès -->
                <?php if ($maps_url = mairie_get_option('contact_maps_url')) : ?>
                <div class="contact-info-box">
                    <h3><?php _e('Accès', 'mairie-france'); ?></h3>
                    <a href="<?php echo esc_url($maps_url); ?>" class="button button-outline" target="_blank" rel="noopener noreferrer">
                        <span class="icon-map" aria-hidden="true"></span>
                        <?php _e('Voir sur Google Maps', 'mairie-france'); ?>
                    </a>
                </div>
                <?php endif; ?>
                
            </aside>
            
        </div>
        
        <!-- Carte Google Maps -->
        <?php if ($maps_embed = mairie_get_option('contact_maps_embed')) : ?>
        <div class="contact-map">
            <h2><?php _e('Nous trouver', 'mairie-france'); ?></h2>
            <div class="map-container">
                <?php echo wp_kses_post($maps_embed); ?>
            </div>
        </div>
        <?php endif; ?>
        
    </div>
</main>

<?php
get_footer();
