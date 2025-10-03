<?php
/**
 * Template Name: Publications
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-publications">
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
        
        <!-- Onglets Publications -->
        <div class="publications-tabs">
            <div class="tabs-navigation" role="tablist">
                <button class="tab-button active" data-tab="bulletins" role="tab" aria-selected="true" aria-controls="tab-bulletins">
                    <?php _e('Bulletins Municipaux', 'mairie-france'); ?>
                </button>
                <button class="tab-button" data-tab="magazines" role="tab" aria-selected="false" aria-controls="tab-magazines">
                    <?php _e('Magazines', 'mairie-france'); ?>
                </button>
                <button class="tab-button" data-tab="deliberations" role="tab" aria-selected="false" aria-controls="tab-deliberations">
                    <?php _e('Délibérations', 'mairie-france'); ?>
                </button>
            </div>
            
            <!-- Filtres année/mois -->
            <div class="publications-filters">
                <select id="filter-year" class="filter-select">
                    <option value=""><?php _e('Toutes les années', 'mairie-france'); ?></option>
                    <?php
                    $current_year = date('Y');
                    for ($year = $current_year; $year >= $current_year - 10; $year--) {
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    }
                    ?>
                </select>
                
                <select id="filter-month" class="filter-select">
                    <option value=""><?php _e('Tous les mois', 'mairie-france'); ?></option>
                    <?php
                    global $wp_locale;
                    for ($i = 1; $i <= 12; $i++) {
                        echo '<option value="' . sprintf('%02d', $i) . '">' . $wp_locale->get_month($i) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <!-- Contenu des onglets -->
            <div class="tabs-content">
                
                <!-- Bulletins Municipaux -->
                <div id="tab-bulletins" class="tab-pane active" role="tabpanel">
                    <?php
                    if (function_exists('wpdm_init')) {
                        // Intégration Download Manager
                        // Afficher les fichiers avec la catégorie "Bulletins"
                        echo do_shortcode('[wpdm_packages category="bulletins" items_per_page="12" toolbar="0" template="link-template-default"]');
                    } else {
                        echo '<p>' . __('Le plugin Download Manager n\'est pas installé.', 'mairie-france') . '</p>';
                    }
                    ?>
                </div>
                
                <!-- Magazines -->
                <div id="tab-magazines" class="tab-pane" role="tabpanel" hidden>
                    <?php
                    if (function_exists('wpdm_init')) {
                        echo do_shortcode('[wpdm_packages category="magazines" items_per_page="12" toolbar="0" template="link-template-default"]');
                    } else {
                        echo '<p>' . __('Le plugin Download Manager n\'est pas installé.', 'mairie-france') . '</p>';
                    }
                    ?>
                </div>
                
                <!-- Délibérations -->
                <div id="tab-deliberations" class="tab-pane" role="tabpanel" hidden>
                    <?php
                    if (function_exists('wpdm_init')) {
                        echo do_shortcode('[wpdm_packages category="deliberations" items_per_page="12" toolbar="0" template="link-template-default"]');
                    } else {
                        echo '<p>' . __('Le plugin Download Manager n\'est pas installé.', 'mairie-france') . '</p>';
                    }
                    ?>
                </div>
                
            </div>
        </div>
        
    </div>
</main>

<script>
// Gestion des onglets
jQuery(document).ready(function($) {
    $('.tab-button').on('click', function() {
        var $button = $(this);
        var tab = $button.data('tab');
        
        // Mettre à jour les boutons
        $('.tab-button').removeClass('active').attr('aria-selected', 'false');
        $button.addClass('active').attr('aria-selected', 'true');
        
        // Mettre à jour les panneaux
        $('.tab-pane').removeClass('active').attr('hidden', true);
        $('#tab-' + tab).addClass('active').removeAttr('hidden');
    });
    
    // Filtrage par année/mois
    $('#filter-year, #filter-month').on('change', function() {
        var year = $('#filter-year').val();
        var month = $('#filter-month').val();
        
        // Filtrer les éléments (nécessite adaptation selon Download Manager)
        // Cette partie peut être améliorée avec AJAX
    });
});
</script>

<?php
get_footer();
