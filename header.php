<?php
/**
 * Header du thème
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to content link pour accessibilité -->
<a class="skip-link" href="#main-content">
    <?php _e('Aller au contenu principal', 'mairie-france'); ?>
</a>

<div id="page" class="site min-h-screen flex flex-col">
    
    <!-- Barre supérieure -->
    <?php if (has_nav_menu('top-bar') || mairie_get_option('social_facebook') || mairie_get_option('social_twitter')) : ?>
    <div class="bg-gray-900 text-white text-sm py-2 no-print">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <!-- Menu secondaire -->
                <?php if (has_nav_menu('top-bar')) : ?>
                <nav class="hidden md:block" aria-label="<?php esc_attr_e('Navigation secondaire', 'mairie-france'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'top-bar',
                        'menu_class'     => 'flex space-x-4',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>
                <?php endif; ?>
                
                <!-- Réseaux sociaux -->
                <?php if (mairie_get_option('social_facebook') || mairie_get_option('social_twitter') || mairie_get_option('social_instagram')) : ?>
                <div class="flex space-x-3">
                    <?php if ($facebook = mairie_get_option('social_facebook')) : ?>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-400 transition-colors" aria-label="<?php esc_attr_e('Facebook', 'mairie-france'); ?>">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($twitter = mairie_get_option('social_twitter')) : ?>
                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-400 transition-colors" aria-label="<?php esc_attr_e('Twitter', 'mairie-france'); ?>">
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($instagram = mairie_get_option('social_instagram')) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-400 transition-colors" aria-label="<?php esc_attr_e('Instagram', 'mairie-france'); ?>">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($youtube = mairie_get_option('social_youtube')) : ?>
                        <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-400 transition-colors" aria-label="<?php esc_attr_e('YouTube', 'mairie-france'); ?>">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($linkedin = mairie_get_option('social_linkedin')) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-400 transition-colors" aria-label="<?php esc_attr_e('LinkedIn', 'mairie-france'); ?>">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Header principal -->
    <header id="masthead" class="site-header bg-white shadow-md sticky top-0 z-50 no-print" role="banner">
        <div class="container mx-auto px-4">
            <!-- Partie haute du header -->
            <div class="flex items-center justify-between py-4 border-b border-gray-200">
                
                <!-- Logo et identité -->
                <div class="site-branding flex items-center space-x-4">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($blason = mairie_get_option('commune_blason')) : ?>
                        <img src="<?php echo esc_url($blason); ?>" 
                             alt="<?php esc_attr_e('Blason', 'mairie-france'); ?>" 
                             class="h-16 w-auto">
                    <?php endif; ?>
                    
                    <div class="site-titles">
                        <?php if (is_front_page()) : ?>
                            <h1 class="text-2xl md:text-3xl font-bold text-[#000091] m-0">
                                <a href="<?php echo esc_url(home_url('/')); ?>" 
                                   rel="home" 
                                   class="hover:text-[#E1000F] transition-colors no-underline">
                                    <?php echo esc_html(mairie_get_option('commune_name', get_bloginfo('name'))); ?>
                                </a>
                            </h1>
                        <?php else : ?>
                            <p class="text-2xl md:text-3xl font-bold text-[#000091] m-0">
                                <a href="<?php echo esc_url(home_url('/')); ?>" 
                                   rel="home" 
                                   class="hover:text-[#E1000F] transition-colors no-underline">
                                    <?php echo esc_html(mairie_get_option('commune_name', get_bloginfo('name'))); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($slogan = mairie_get_option('commune_slogan', get_bloginfo('description'))) : ?>
                            <p class="text-sm text-gray-600 m-0"><?php echo esc_html($slogan); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Contact rapide et menu toggle -->
                <div class="flex items-center space-x-4">
                    <!-- Contact rapide (desktop uniquement) -->
                    <div class="hidden lg:flex flex-col space-y-2 text-sm">
                        <?php if ($phone = mairie_get_option('contact_phone')) : ?>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-phone text-[#000091]"></i>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" 
                                   class="hover:text-[#E1000F] transition-colors">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($email = mairie_get_option('contact_email')) : ?>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-envelope text-[#000091]"></i>
                                <a href="mailto:<?php echo esc_attr($email); ?>" 
                                   class="hover:text-[#E1000F] transition-colors">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Bouton menu mobile -->
                    <button class="menu-toggle lg:hidden flex flex-col items-center justify-center p-2 text-[#000091] hover:text-[#E1000F] transition-colors" 
                            aria-controls="primary-menu" 
                            aria-expanded="false" 
                            aria-label="<?php esc_attr_e('Menu', 'mairie-france'); ?>">
                        <div class="menu-toggle-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <span class="text-xs mt-1"><?php _e('Menu', 'mairie-france'); ?></span>
                    </button>
                </div>
            </div>
            
            <!-- Navigation principale (conditionnelle si un menu est assigné) -->
            <?php if (has_nav_menu('primary')) : ?>
            <nav id="site-navigation" 
                 class="main-navigation lg:relative lg:transform-none lg:opacity-100 lg:shadow-none" 
                 role="navigation" 
                 aria-label="<?php esc_attr_e('Navigation principale', 'mairie-france'); ?>">
                <div class="lg:py-4">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'flex flex-col lg:flex-row lg:space-x-6 lg:items-center p-6 lg:p-0',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'walker'         => new Mairie_Nav_Walker(),
                    ));
                    ?>
                </div>
            </nav>
            <?php endif; ?>
        </div>
    </header>
    
    <!-- Début du contenu -->
    <main id="main-content" class="site-content flex-grow"><?php do_action('mairie_before_content'); ?>
