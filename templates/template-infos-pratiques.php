<?php
/**
 * Template Name: Infos Pratiques
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-infos-pratiques">
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
        
        <!-- Horaires des services (TablePress) -->
        <section class="infos-section">
            <h2><?php _e('Horaires des Services', 'mairie-france'); ?></h2>
            
            <?php
            // Afficher un tableau TablePress
            $tablepress_id = get_post_meta(get_the_ID(), '_mairie_tablepress_horaires', true);
            
            if ($tablepress_id && class_exists('TablePress')) {
                echo do_shortcode('[table id="' . $tablepress_id . '" responsive="scroll" /]');
            } else {
                ?>
                <p><?php _e('Les horaires détaillés seront bientôt disponibles.', 'mairie-france'); ?></p>
                <?php
            }
            ?>
        </section>
        
        <!-- Démarches administratives (Accordion) -->
        <section class="infos-section">
            <h2><?php _e('Démarches Administratives', 'mairie-france'); ?></h2>
            
            <div class="accordion" id="demarches-accordion">
                
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#demarche-1" aria-expanded="false">
                            <?php _e('Carte d\'identité', 'mairie-france'); ?>
                        </button>
                    </h3>
                    <div id="demarche-1" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p><?php _e('Pour faire ou renouveler votre carte d\'identité, vous devez...', 'mairie-france'); ?></p>
                            <ul>
                                <li><?php _e('Prendre rendez-vous en mairie', 'mairie-france'); ?></li>
                                <li><?php _e('Apporter les documents requis', 'mairie-france'); ?></li>
                                <li><?php _e('Payer les frais de traitement', 'mairie-france'); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#demarche-2" aria-expanded="false">
                            <?php _e('Passeport', 'mairie-france'); ?>
                        </button>
                    </h3>
                    <div id="demarche-2" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p><?php _e('Pour faire ou renouveler votre passeport...', 'mairie-france'); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#demarche-3" aria-expanded="false">
                            <?php _e('Acte de naissance', 'mairie-france'); ?>
                        </button>
                    </h3>
                    <div id="demarche-3" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p><?php _e('Pour obtenir un acte de naissance...', 'mairie-france'); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#demarche-4" aria-expanded="false">
                            <?php _e('Inscription scolaire', 'mairie-france'); ?>
                        </button>
                    </h3>
                    <div id="demarche-4" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p><?php _e('Pour inscrire votre enfant à l\'école...', 'mairie-france'); ?></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        
        <!-- FAQ -->
        <section class="infos-section">
            <h2><?php _e('Questions Fréquentes', 'mairie-france'); ?></h2>
            
            <div class="accordion" id="faq-accordion">
                
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#faq-1" aria-expanded="false">
                            <?php _e('Quels sont les horaires de la mairie ?', 'mairie-france'); ?>
                        </button>
                    </h3>
                    <div id="faq-1" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <?php
                            $horaires = mairie_get_option('contact_horaires_full');
                            if ($horaires) {
                                echo wpautop(wp_kses_post($horaires));
                            } else {
                                echo '<p>' . __('Consultez notre page Contact pour les horaires.', 'mairie-france') . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#faq-2" aria-expanded="false">
                            <?php _e('Comment prendre rendez-vous en mairie ?', 'mairie-france'); ?>
                        </button>
                    </h3>
                    <div id="faq-2" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p><?php _e('Vous pouvez prendre rendez-vous par téléphone ou via notre formulaire de contact.', 'mairie-france'); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#faq-3" aria-expanded="false">
                            <?php _e('Où trouver les délibérations du conseil municipal ?', 'mairie-france'); ?>
                        </button>
                    </h3>
                    <div id="faq-3" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p><?php printf(__('Consultez la page <a href="%s">Publications</a> pour accéder aux délibérations.', 'mairie-france'), home_url('/publications')); ?></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        
    </div>
</main>

<script>
// Gestion des accordéons
jQuery(document).ready(function($) {
    $('.accordion-button').on('click', function() {
        var $button = $(this);
        var target = $button.data('target');
        var $collapse = $(target);
        var isExpanded = $button.attr('aria-expanded') === 'true';
        
        // Fermer les autres
        $('.accordion-collapse').not($collapse).removeClass('show').slideUp();
        $('.accordion-button').not($button).attr('aria-expanded', 'false').removeClass('active');
        
        // Toggle celui-ci
        $collapse.toggleClass('show').slideToggle();
        $button.attr('aria-expanded', !isExpanded).toggleClass('active');
    });
});
</script>

<?php
get_footer();
