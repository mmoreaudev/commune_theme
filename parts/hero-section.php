<?php
/**
 * Hero Section pour la page d'accueil
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

$hero_image    = mairie_get_option('home_hero_image');
$hero_title    = mairie_get_option('home_hero_title', __('Bienvenue sur le site de votre commune', 'mairie-france'));
$hero_subtitle = mairie_get_option('home_hero_subtitle', __('Toute l\'actualité et les services de votre mairie', 'mairie-france'));
$cta_text      = mairie_get_option('home_hero_cta_text', __('Découvrir', 'mairie-france'));
$cta_url       = mairie_get_option('home_hero_cta_url', home_url('/votre-mairie'));
?>

<section class="hero-section" <?php if ($hero_image) echo 'style="background-image: url(' . esc_url($hero_image) . ');"'; ?>>
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
            <?php if ($hero_subtitle) : ?>
                <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            <?php endif; ?>
            <?php if ($cta_text && $cta_url) : ?>
                <div class="hero-cta">
                    <a href="<?php echo esc_url($cta_url); ?>" class="button button-large button-primary">
                        <?php echo esc_html($cta_text); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
