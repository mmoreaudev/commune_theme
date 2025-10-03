<?php
/**
 * Template Name: Conseil Municipal
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-conseil-municipal">
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
        
        <!-- Filtres par fonction -->
        <div class="team-filters">
            <button class="filter-button active" data-filter="all">
                <?php _e('Tous', 'mairie-france'); ?>
            </button>
            <button class="filter-button" data-filter="maire">
                <?php _e('Maire', 'mairie-france'); ?>
            </button>
            <button class="filter-button" data-filter="adjoint">
                <?php _e('Adjoints', 'mairie-france'); ?>
            </button>
            <button class="filter-button" data-filter="conseiller">
                <?php _e('Conseillers', 'mairie-france'); ?>
            </button>
        </div>
        
        <!-- Intégration Our Team Members -->
        <div class="team-members-container">
            <?php
            // Vérifier si Our Team Members est actif
            if (function_exists('our_team_enhanced_init')) {
                // Afficher via shortcode Our Team Members
                echo do_shortcode('[our-team-enhanced template="grid" show_pic="yes" show_name="yes" show_designation="yes" show_bio="yes" per_row="3"]');
            } else {
                // Affichage alternatif avec CPT personnalisé
                ?>
                <p class="plugin-notice">
                    <?php _e('Le plugin "Our Team Members" n\'est pas installé. Veuillez l\'installer pour afficher les élus.', 'mairie-france'); ?>
                </p>
                
                <!-- Exemple de structure si le plugin n'est pas actif -->
                <div class="team-grid" data-filter-container>
                    <!-- Les membres seront affichés ici quand le plugin sera activé -->
                </div>
                <?php
            }
            ?>
        </div>
        
    </div>
</main>

<script>
// Filtrage des membres par fonction
jQuery(document).ready(function($) {
    $('.filter-button').on('click', function() {
        var $button = $(this);
        var filter = $button.data('filter');
        
        $('.filter-button').removeClass('active');
        $button.addClass('active');
        
        if (filter === 'all') {
            $('.team-member').show();
        } else {
            $('.team-member').hide();
            $('.team-member[data-role="' + filter + '"]').show();
        }
    });
});
</script>

<?php
get_footer();
