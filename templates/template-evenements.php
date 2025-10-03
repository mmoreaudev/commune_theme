<?php
/**
 * Template Name: Événements
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-evenements">
    <div class="container">
        <?php mairie_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>
        
        <?php
        // Vérifier si The Events Calendar est actif
        if (class_exists('Tribe__Events__Main')) :
            ?>
            
            <!-- Affichage calendrier The Events Calendar -->
            <div class="events-calendar-container">
                <?php echo tribe_events_before_html(); ?>
                <?php tribe_events(); ?>
                <?php echo tribe_events_after_html(); ?>
            </div>
            
            <?php
        else :
            ?>
            <div class="plugin-notice">
                <p><?php _e('Le plugin "The Events Calendar" n\'est pas installé. Veuillez l\'installer pour afficher les événements.', 'mairie-france'); ?></p>
            </div>
            <?php
        endif;
        ?>
        
    </div>
</main>

<?php
get_footer();
