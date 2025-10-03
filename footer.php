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

    </main><!-- #main-content -->
    
    <?php do_action('mairie_after_content'); ?>
    
    <!-- Footer -->
    <footer id="colophon" class="site-footer bg-gray-900 text-white mt-auto no-print" role="contentinfo">
        
        <!-- Widgets Footer -->
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
        <div class="footer-widgets py-12 border-b border-gray-800">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
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
        <div class="footer-info py-10 bg-gray-800">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Coordonnées -->
                    <div class="footer-info-section">
                        <h3 class="text-xl font-bold text-[#E1000F] mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <?php _e('Coordonnées', 'mairie-france'); ?>
                        </h3>
                        <address class="not-italic text-gray-300 space-y-2">
                            <?php if ($name = mairie_get_option('commune_name')) : ?>
                                <strong class="block text-white text-lg"><?php echo esc_html($name); ?></strong>
                            <?php endif; ?>
                            
                            <?php if ($address = mairie_get_option('contact_address')) : ?>
                                <p class="flex items-start">
                                    <i class="fas fa-building mr-2 mt-1 text-[#000091]"></i>
                                    <span><?php echo nl2br(esc_html($address)); ?></span>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($phone = mairie_get_option('contact_phone')) : ?>
                                <p class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-[#000091]"></i>
                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" 
                                       class="hover:text-[#E1000F] transition-colors">
                                        <?php echo esc_html($phone); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($email = mairie_get_option('contact_email')) : ?>
                                <p class="flex items-center">
                                    <i class="fas fa-envelope mr-2 text-[#000091]"></i>
                                    <a href="mailto:<?php echo esc_attr($email); ?>" 
                                       class="hover:text-[#E1000F] transition-colors">
                                        <?php echo esc_html($email); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </address>
                    </div>
                    
                    <!-- Horaires -->
                    <?php if ($horaires = mairie_get_option('contact_horaires_full')) : ?>
                    <div class="footer-info-section">
                        <h3 class="text-xl font-bold text-[#E1000F] mb-4 flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <?php _e('Horaires d\'ouverture', 'mairie-france'); ?>
                        </h3>
                        <div class="text-gray-300 space-y-1">
                            <?php echo wpautop(wp_kses_post($horaires)); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Accès rapides -->
                    <div class="footer-info-section">
                        <h3 class="text-xl font-bold text-[#E1000F] mb-4 flex items-center">
                            <i class="fas fa-link mr-2"></i>
                            <?php _e('Accès rapides', 'mairie-france'); ?>
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="<?php echo esc_url(home_url('/contact')); ?>" 
                                   class="flex items-center text-gray-300 hover:text-[#E1000F] transition-colors">
                                    <i class="fas fa-chevron-right mr-2 text-xs"></i>
                                    <?php _e('Nous contacter', 'mairie-france'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(home_url('/publications')); ?>" 
                                   class="flex items-center text-gray-300 hover:text-[#E1000F] transition-colors">
                                    <i class="fas fa-chevron-right mr-2 text-xs"></i>
                                    <?php _e('Publications', 'mairie-france'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(home_url('/evenements')); ?>" 
                                   class="flex items-center text-gray-300 hover:text-[#E1000F] transition-colors">
                                    <i class="fas fa-chevron-right mr-2 text-xs"></i>
                                    <?php _e('Agenda', 'mairie-france'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(home_url('/numeros-utiles')); ?>" 
                                   class="flex items-center text-gray-300 hover:text-[#E1000F] transition-colors">
                                    <i class="fas fa-chevron-right mr-2 text-xs"></i>
                                    <?php _e('Numéros utiles', 'mairie-france'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Barre de copyright et mentions légales -->
        <div class="footer-bottom bg-black py-6">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-sm text-gray-400">
                    <!-- Menu légal -->
                    <?php if (has_nav_menu('legal')) : ?>
                    <nav class="footer-legal-menu" aria-label="<?php esc_attr_e('Mentions légales', 'mairie-france'); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'legal',
                            'menu_class'     => 'flex flex-wrap justify-center space-x-4',
                            'container'      => false,
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        ));
                        ?>
                    </nav>
                    <?php endif; ?>
                    
                    <!-- Copyright -->
                    <div class="footer-copyright text-center md:text-right">
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
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
</div><!-- #page -->

<!-- Bouton retour en haut -->
<button id="back-to-top" class="no-print" aria-label="<?php esc_attr_e('Retour en haut', 'mairie-france'); ?>">
    <i class="fas fa-chevron-up"></i>
</button>

<?php wp_footer(); ?>

</body>
</html>
