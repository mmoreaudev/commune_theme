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
<a class="skip-link screen-reader-text" href="#main-content">
    <?php _e('Aller au contenu principal', 'mairie-france'); ?>
</a>

<div id="page" class="site">
    
    <!-- Barre supérieure -->
    <?php if (has_nav_menu('top-bar')) : ?>
    <div class="top-bar">
        <div class="container">
            <nav class="top-bar-navigation" aria-label="<?php esc_attr_e('Navigation secondaire', 'mairie-france'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'top-bar',
                    'menu_class'     => 'top-bar-menu',
                    'container'      => false,
                    'depth'          => 1,
                ));
                ?>
            </nav>
            
            <!-- Réseaux sociaux -->
            <?php if (mairie_get_option('social_facebook') || mairie_get_option('social_twitter') || mairie_get_option('social_instagram')) : ?>
            <div class="social-links">
                <?php if ($facebook = mairie_get_option('social_facebook')) : ?>
                    <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Facebook', 'mairie-france'); ?>">
                        <span class="icon-facebook" aria-hidden="true"></span>
                    </a>
                <?php endif; ?>
                
                <?php if ($twitter = mairie_get_option('social_twitter')) : ?>
                    <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Twitter', 'mairie-france'); ?>">
                        <span class="icon-twitter" aria-hidden="true"></span>
                    </a>
                <?php endif; ?>
                
                <?php if ($instagram = mairie_get_option('social_instagram')) : ?>
                    <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Instagram', 'mairie-france'); ?>">
                        <span class="icon-instagram" aria-hidden="true"></span>
                    </a>
                <?php endif; ?>
                
                <?php if ($youtube = mairie_get_option('social_youtube')) : ?>
                    <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('YouTube', 'mairie-france'); ?>">
                        <span class="icon-youtube" aria-hidden="true"></span>
                    </a>
                <?php endif; ?>
                
                <?php if ($linkedin = mairie_get_option('social_linkedin')) : ?>
                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('LinkedIn', 'mairie-france'); ?>">
                        <span class="icon-linkedin" aria-hidden="true"></span>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Header principal -->
    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="header-inner">
                
                <!-- Logo et identité -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="site-identity">
                        <?php if ($blason = mairie_get_option('commune_blason')) : ?>
                            <img src="<?php echo esc_url($blason); ?>" alt="<?php esc_attr_e('Blason', 'mairie-france'); ?>" class="site-blason">
                        <?php endif; ?>
                        
                        <div class="site-titles">
                            <?php if (is_front_page()) : ?>
                                <h1 class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php echo esc_html(mairie_get_option('commune_name', get_bloginfo('name'))); ?>
                                    </a>
                                </h1>
                            <?php else : ?>
                                <p class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php echo esc_html(mairie_get_option('commune_name', get_bloginfo('name'))); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($slogan = mairie_get_option('commune_slogan', get_bloginfo('description'))) : ?>
                                <p class="site-description"><?php echo esc_html($slogan); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Contact rapide -->
                <div class="header-contact">
                    <?php if ($phone = mairie_get_option('contact_phone')) : ?>
                        <div class="header-contact-item">
                            <span class="icon-phone" aria-hidden="true"></span>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($email = mairie_get_option('contact_email')) : ?>
                        <div class="header-contact-item">
                            <span class="icon-email" aria-hidden="true"></span>
                            <a href="mailto:<?php echo esc_attr($email); ?>">
                                <?php echo esc_html($email); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($horaires = mairie_get_option('contact_horaires')) : ?>
                        <div class="header-contact-item">
                            <span class="icon-clock" aria-hidden="true"></span>
                            <span><?php echo esc_html($horaires); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Bouton menu mobile -->
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Menu', 'mairie-france'); ?>">
                    <span class="menu-toggle-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="menu-toggle-text"><?php _e('Menu', 'mairie-france'); ?></span>
                </button>
            </div>
            
            <!-- Navigation principale -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Navigation principale', 'mairie-france'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
                
                <!-- Recherche dans le menu -->
                <div class="header-search">
                    <button class="search-toggle" aria-label="<?php esc_attr_e('Rechercher', 'mairie-france'); ?>" aria-expanded="false">
                        <span class="icon-search" aria-hidden="true"></span>
                    </button>
                    <div class="search-form-wrapper" role="search">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Début du contenu -->
    <div id="content" class="site-content">
