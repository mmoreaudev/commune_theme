<?php
/**
 * Template Name: Numéros Utiles
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-numeros-utiles">
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
        
        <!-- Barre de recherche et filtres -->
        <div class="numeros-filters">
            <div class="numeros-search">
                <label for="numeros-search-input" class="screen-reader-text">
                    <?php _e('Rechercher un numéro', 'mairie-france'); ?>
                </label>
                <input 
                    type="search" 
                    id="numeros-search-input" 
                    class="numeros-search-input" 
                    placeholder="<?php esc_attr_e('Rechercher un numéro, un service...', 'mairie-france'); ?>"
                    aria-label="<?php esc_attr_e('Rechercher parmi les numéros utiles', 'mairie-france'); ?>"
                />
                <button type="button" class="search-button" aria-label="<?php esc_attr_e('Lancer la recherche', 'mairie-france'); ?>">
                    <span class="icon-search" aria-hidden="true"></span>
                </button>
            </div>
            
            <div class="numeros-categories">
                <button class="filter-button active" data-category="">
                    <?php _e('Tous', 'mairie-france'); ?>
                </button>
                
                <?php
                $categories = get_terms(array(
                    'taxonomy'   => 'categorie_numero',
                    'hide_empty' => true,
                ));
                
                if ($categories && !is_wp_error($categories)) :
                    foreach ($categories as $category) :
                        ?>
                        <button class="filter-button" data-category="<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                            <span class="count">(<?php echo $category->count; ?>)</span>
                        </button>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
        
        <!-- Liste des numéros -->
        <div id="numeros-container" class="numeros-container">
            <?php
            // Récupérer toutes les catégories
            $all_categories = get_terms(array(
                'taxonomy'   => 'categorie_numero',
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));
            
            if ($all_categories && !is_wp_error($all_categories)) :
                foreach ($all_categories as $cat) :
                    ?>
                    <section class="numeros-category-section">
                        <h2 class="category-title">
                            <span class="icon-folder" aria-hidden="true"></span>
                            <?php echo esc_html($cat->name); ?>
                        </h2>
                        
                        <?php if ($cat->description) : ?>
                            <p class="category-description"><?php echo esc_html($cat->description); ?></p>
                        <?php endif; ?>
                        
                        <div class="numeros-grid">
                            <?php
                            $numeros = new WP_Query(array(
                                'post_type'      => 'numeros_utiles',
                                'posts_per_page' => -1,
                                'orderby'        => 'title',
                                'order'          => 'ASC',
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'categorie_numero',
                                        'field'    => 'term_id',
                                        'terms'    => $cat->term_id,
                                    ),
                                ),
                            ));
                            
                            if ($numeros->have_posts()) :
                                while ($numeros->have_posts()) :
                                    $numeros->the_post();
                                    
                                    $phone    = get_post_meta(get_the_ID(), '_mairie_numero_phone', true);
                                    $email    = get_post_meta(get_the_ID(), '_mairie_numero_email', true);
                                    $address  = get_post_meta(get_the_ID(), '_mairie_numero_address', true);
                                    $postal   = get_post_meta(get_the_ID(), '_mairie_numero_postal', true);
                                    $city     = get_post_meta(get_the_ID(), '_mairie_numero_city', true);
                                    $horaires = get_post_meta(get_the_ID(), '_mairie_numero_horaires', true);
                                    $website  = get_post_meta(get_the_ID(), '_mairie_numero_website', true);
                                    ?>
                                    
                                    <article class="numero-card" id="numero-<?php the_ID(); ?>">
                                        <div class="numero-header">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="numero-thumbnail">
                                                    <?php the_post_thumbnail('thumbnail'); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <h3 class="numero-title"><?php the_title(); ?></h3>
                                        </div>
                                        
                                        <div class="numero-content">
                                            <?php if (get_the_content()) : ?>
                                                <div class="numero-description">
                                                    <?php the_content(); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <ul class="numero-info">
                                                <?php if ($phone) : ?>
                                                    <li class="numero-phone">
                                                        <span class="icon-phone" aria-hidden="true"></span>
                                                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" class="phone-link">
                                                            <strong><?php echo esc_html($phone); ?></strong>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                
                                                <?php if ($email) : ?>
                                                    <li class="numero-email">
                                                        <span class="icon-email" aria-hidden="true"></span>
                                                        <a href="mailto:<?php echo esc_attr($email); ?>">
                                                            <?php echo esc_html($email); ?>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                
                                                <?php if ($address || ($postal && $city)) : ?>
                                                    <li class="numero-address">
                                                        <span class="icon-map" aria-hidden="true"></span>
                                                        <address>
                                                            <?php if ($address) echo esc_html($address) . '<br>'; ?>
                                                            <?php if ($postal && $city) echo esc_html($postal) . ' ' . esc_html($city); ?>
                                                        </address>
                                                    </li>
                                                <?php endif; ?>
                                                
                                                <?php if ($horaires) : ?>
                                                    <li class="numero-horaires">
                                                        <span class="icon-clock" aria-hidden="true"></span>
                                                        <div class="horaires-text">
                                                            <?php echo nl2br(esc_html($horaires)); ?>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                                
                                                <?php if ($website) : ?>
                                                    <li class="numero-website">
                                                        <span class="icon-link" aria-hidden="true"></span>
                                                        <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer">
                                                            <?php _e('Site web', 'mairie-france'); ?>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        
                                        <?php if ($phone) : ?>
                                            <div class="numero-actions">
                                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" class="button button-primary button-call">
                                                    <span class="icon-phone" aria-hidden="true"></span>
                                                    <?php _e('Appeler', 'mairie-france'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </article>
                                    
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                ?>
                                <p class="no-numeros"><?php _e('Aucun numéro dans cette catégorie.', 'mairie-france'); ?></p>
                                <?php
                            endif;
                            ?>
                        </div>
                    </section>
                    <?php
                endforeach;
            else :
                ?>
                <div class="no-results">
                    <p><?php _e('Aucun numéro utile n\'a encore été ajouté.', 'mairie-france'); ?></p>
                </div>
                <?php
            endif;
            ?>
        </div>
        
    </div>
</main>

<script>
// Recherche et filtrage en temps réel
jQuery(document).ready(function($) {
    var $container = $('#numeros-container');
    var $searchInput = $('#numeros-search-input');
    var $filterButtons = $('.filter-button');
    var activeCategory = '';
    
    // Fonction de filtrage
    function filterNumeros() {
        var searchTerm = $searchInput.val().toLowerCase();
        var $sections = $container.find('.numeros-category-section');
        
        $sections.each(function() {
            var $section = $(this);
            var $cards = $section.find('.numero-card');
            var hasVisibleCards = false;
            
            $cards.each(function() {
                var $card = $(this);
                var title = $card.find('.numero-title').text().toLowerCase();
                var description = $card.find('.numero-description').text().toLowerCase();
                var phone = $card.find('.numero-phone').text().toLowerCase();
                
                var matchesSearch = !searchTerm || 
                    title.indexOf(searchTerm) > -1 || 
                    description.indexOf(searchTerm) > -1 || 
                    phone.indexOf(searchTerm) > -1;
                
                if (matchesSearch) {
                    $card.show();
                    hasVisibleCards = true;
                } else {
                    $card.hide();
                }
            });
            
            // Afficher/masquer la section selon si elle a des cartes visibles
            if (hasVisibleCards) {
                $section.show();
            } else {
                $section.hide();
            }
        });
        
        // Afficher message si aucun résultat
        var hasResults = $container.find('.numero-card:visible').length > 0;
        $container.find('.no-results-message').remove();
        
        if (!hasResults) {
            $container.append('<div class="no-results-message"><p><?php _e('Aucun numéro trouvé.', 'mairie-france'); ?></p></div>');
        }
    }
    
    // Événement recherche
    $searchInput.on('input', filterNumeros);
    
    // Événement filtre catégorie
    $filterButtons.on('click', function() {
        var $button = $(this);
        var category = $button.data('category');
        
        $filterButtons.removeClass('active');
        $button.addClass('active');
        
        if (category === '') {
            // Afficher tout
            $container.find('.numeros-category-section').show();
        } else {
            // Filtrer par catégorie via AJAX pour meilleures performances
            // Pour l'instant, simple affichage client
            $container.find('.numeros-category-section').hide();
            $container.find('.numeros-category-section').each(function() {
                var $section = $(this);
                if ($section.find('[data-category="' + category + '"]').length > 0) {
                    $section.show();
                }
            });
        }
        
        filterNumeros();
    });
});
</script>

<?php
get_footer();
