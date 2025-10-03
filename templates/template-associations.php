<?php
/**
 * Template Name: Associations
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-associations">
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
        
        <!-- Filtres catégories -->
        <div class="associations-filters">
            <button class="filter-button active" data-category="">
                <?php _e('Toutes', 'mairie-france'); ?>
            </button>
            
            <?php
            $categories = get_terms(array(
                'taxonomy'   => 'categorie_association',
                'hide_empty' => true,
            ));
            
            if ($categories && !is_wp_error($categories)) :
                foreach ($categories as $category) :
                    ?>
                    <button class="filter-button" data-category="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </button>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
        
        <!-- Liste des associations -->
        <div class="associations-grid">
            <?php
            $associations = new WP_Query(array(
                'post_type'      => 'associations',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ));
            
            if ($associations->have_posts()) :
                while ($associations->have_posts()) :
                    $associations->the_post();
                    
                    $president = get_post_meta(get_the_ID(), '_mairie_asso_president', true);
                    $phone     = get_post_meta(get_the_ID(), '_mairie_asso_phone', true);
                    $email     = get_post_meta(get_the_ID(), '_mairie_asso_email', true);
                    $website   = get_post_meta(get_the_ID(), '_mairie_asso_website', true);
                    $facebook  = get_post_meta(get_the_ID(), '_mairie_asso_facebook', true);
                    
                    $terms = get_the_terms(get_the_ID(), 'categorie_association');
                    $category_class = '';
                    if ($terms && !is_wp_error($terms)) {
                        $category_class = $terms[0]->slug;
                    }
                    ?>
                    
                    <article class="association-card" data-category="<?php echo esc_attr($category_class); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="association-logo">
                                <?php the_post_thumbnail('mairie-thumbnail'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="association-content">
                            <h2 class="association-title"><?php the_title(); ?></h2>
                            
                            <?php if ($terms && !is_wp_error($terms)) : ?>
                                <div class="association-category">
                                    <?php echo esc_html($terms[0]->name); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (has_excerpt()) : ?>
                                <div class="association-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <ul class="association-meta">
                                <?php if ($president) : ?>
                                    <li>
                                        <strong><?php _e('Président(e):', 'mairie-france'); ?></strong>
                                        <?php echo esc_html($president); ?>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if ($phone) : ?>
                                    <li>
                                        <span class="icon-phone" aria-hidden="true"></span>
                                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                                            <?php echo esc_html($phone); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if ($email) : ?>
                                    <li>
                                        <span class="icon-email" aria-hidden="true"></span>
                                        <a href="mailto:<?php echo esc_attr($email); ?>">
                                            <?php echo esc_html($email); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            
                            <div class="association-actions">
                                <a href="<?php the_permalink(); ?>" class="button button-outline">
                                    <?php _e('En savoir plus', 'mairie-france'); ?>
                                </a>
                                
                                <?php if ($website) : ?>
                                    <a href="<?php echo esc_url($website); ?>" class="button button-outline" target="_blank" rel="noopener noreferrer">
                                        <span class="icon-link" aria-hidden="true"></span>
                                        <?php _e('Site web', 'mairie-france'); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($facebook) : ?>
                                    <a href="<?php echo esc_url($facebook); ?>" class="button button-outline" target="_blank" rel="noopener noreferrer">
                                        <span class="icon-facebook" aria-hidden="true"></span>
                                        Facebook
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p><?php _e('Aucune association n\'a encore été ajoutée.', 'mairie-france'); ?></p>
                <?php
            endif;
            ?>
        </div>
        
    </div>
</main>

<script>
// Filtrage associations
jQuery(document).ready(function($) {
    $('.associations-filters .filter-button').on('click', function() {
        var $button = $(this);
        var category = $button.data('category');
        
        $('.filter-button').removeClass('active');
        $button.addClass('active');
        
        if (category === '') {
            $('.association-card').show();
        } else {
            $('.association-card').hide();
            $('.association-card[data-category="' + category + '"]').show();
        }
    });
});
</script>

<?php
get_footer();
