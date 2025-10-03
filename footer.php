<?php
/**
 * Footer du thème
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;
?>

    </div><!-- #content -->
    
    <!-- Footer -->
    <footer id="colophon" class="site-footer" role="contentinfo">
        
        <!-- Widgets Footer -->
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets-grid">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-4'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Informations de la commune -->
        <div class="footer-info">
            <div class="container">
                <div class="footer-info-grid">
                    
                    <!-- Coordonnées -->
                    <div class="footer-info-section">
                        <h3><?php _e('Coordonnées', 'mairie-france'); ?></h3>
                        <address>
                            <?php if ($name = mairie_get_option('commune_name')) : ?>
                                <strong><?php echo esc_html($name); ?></strong><br>
                            <?php endif; ?>
                            
                            <?php if ($address = mairie_get_option('contact_address')) : ?>
                                <?php echo nl2br(esc_html($address)); ?><br>
                            <?php endif; ?>
                            
                            <?php if ($phone = mairie_get_option('contact_phone')) : ?>
                                <span class="icon-phone" aria-hidden="true"></span>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                                    <?php echo esc_html($phone); ?>
                                </a><br>
                            <?php endif; ?>
                            
                            <?php if ($email = mairie_get_option('contact_email')) : ?>
                                <span class="icon-email" aria-hidden="true"></span>
                                <a href="mailto:<?php echo esc_attr($email); ?>">
                                    <?php echo esc_html($email); ?>
                                </a>
                            <?php endif; ?>
                        </address>
                    </div>
                    
                    <!-- Horaires -->
                    <?php if ($horaires = mairie_get_option('contact_horaires_full')) : ?>
                    <div class="footer-info-section">
                        <h3><?php _e('Horaires d\'ouverture', 'mairie-france'); ?></h3>
                        <div class="horaires-content">
                            <?php echo wpautop(wp_kses_post($horaires)); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Accès rapides -->
                    <div class="footer-info-section">
                        <h3><?php _e('Accès rapides', 'mairie-france'); ?></h3>
                        <ul class="footer-quick-links">
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php _e('Nous contacter', 'mairie-france'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/publications')); ?>"><?php _e('Publications', 'mairie-france'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/evenements')); ?>"><?php _e('Agenda', 'mairie-france'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/numeros-utiles')); ?>"><?php _e('Numéros utiles', 'mairie-france'); ?></a></li>
                        </ul>
                    </div>
                    
                    <!-- Réseaux sociaux -->
                    <?php if (mairie_get_option('social_facebook') || mairie_get_option('social_twitter') || mairie_get_option('social_instagram')) : ?>
                    <div class="footer-info-section">
                        <h3><?php _e('Suivez-nous', 'mairie-france'); ?></h3>
                        <div class="footer-social-links">
                            <?php if ($facebook = mairie_get_option('social_facebook')) : ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" class="social-link facebook" aria-label="<?php esc_attr_e('Facebook', 'mairie-france'); ?>">
                                    <span class="icon-facebook" aria-hidden="true"></span>
                                    <span class="social-link-text">Facebook</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($twitter = mairie_get_option('social_twitter')) : ?>
                                <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" class="social-link twitter" aria-label="<?php esc_attr_e('Twitter', 'mairie-france'); ?>">
                                    <span class="icon-twitter" aria-hidden="true"></span>
                                    <span class="social-link-text">Twitter</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($instagram = mairie_get_option('social_instagram')) : ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="social-link instagram" aria-label="<?php esc_attr_e('Instagram', 'mairie-france'); ?>">
                                    <span class="icon-instagram" aria-hidden="true"></span>
                                    <span class="social-link-text">Instagram</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($youtube = mairie_get_option('social_youtube')) : ?>
                                <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener noreferrer" class="social-link youtube" aria-label="<?php esc_attr_e('YouTube', 'mairie-france'); ?>">
                                    <span class="icon-youtube" aria-hidden="true"></span>
                                    <span class="social-link-text">YouTube</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($linkedin = mairie_get_option('social_linkedin')) : ?>
                                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="social-link linkedin" aria-label="<?php esc_attr_e('LinkedIn', 'mairie-france'); ?>">
                                    <span class="icon-linkedin" aria-hidden="true"></span>
                                    <span class="social-link-text">LinkedIn</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Barre de copyright et mentions légales -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <!-- Menu légal -->
                    <?php if (has_nav_menu('legal')) : ?>
                    <nav class="footer-legal-menu" aria-label="<?php esc_attr_e('Mentions légales', 'mairie-france'); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'legal',
                            'menu_class'     => 'legal-menu',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                        ?>
                    </nav>
                    <?php endif; ?>
                    
                    <!-- Copyright -->
                    <div class="footer-copyright">
                        <?php
                        $copyright = mairie_get_option('footer_copyright', 
                            sprintf(
                                __('&copy; %1$s %2$s - Tous droits réservés', 'mairie-france'),
                                date('Y'),
                                mairie_get_option('commune_name', get_bloginfo('name'))
                            )
                        );
                        echo wp_kses_post($copyright);
                        ?>
                        
                        <?php if (mairie_get_option('footer_show_credits', true)) : ?>
                            <span class="separator">|</span>
                            <span class="theme-credits">
                                <?php 
                                printf(
                                    __('Thème %s par %s', 'mairie-france'),
                                    '<strong>Mairie France</strong>',
                                    '<a href="https://github.com/mmoreaudev" target="_blank" rel="noopener">mmoreaudev</a>'
                                );
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
</div><!-- #page -->

<!-- Bouton retour en haut -->
<button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Retour en haut', 'mairie-france'); ?>">
    <span class="icon-arrow-up" aria-hidden="true"></span>
</button>

<?php wp_footer(); ?>

</body>
</html>
