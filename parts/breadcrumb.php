<?php
/**
 * Breadcrumb (Fil d'Ariane)
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Ne pas afficher sur la page d'accueil
if (is_front_page()) {
    return;
}
?>

<nav class="breadcrumb" aria-label="<?php esc_attr_e('Fil d\'Ariane', 'mairie-france'); ?>">
    <ol class="breadcrumb-list">
        <li class="breadcrumb-item">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <span class="icon-home" aria-hidden="true"></span>
                <?php _e('Accueil', 'mairie-france'); ?>
            </a>
        </li>
        
        <?php
        if (is_category()) :
            $category = get_category(get_query_var('cat'));
            if ($category->parent != 0) {
                $parent_cat = get_category($category->parent);
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . esc_url(get_category_link($parent_cat->term_id)) . '">' . esc_html($parent_cat->name) . '</a>';
                echo '</li>';
            }
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html($category->name) . '</li>';
            
        elseif (is_single()) :
            $category = get_the_category();
            if ($category) {
                $cat = $category[0];
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                echo '</li>';
            }
            echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
            
        elseif (is_page()) :
            if (wp_get_post_parent_id(get_the_ID())) {
                $parent_id = wp_get_post_parent_id(get_the_ID());
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a></li>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo $crumb;
                }
            }
            echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
            
        elseif (is_search()) :
            echo '<li class="breadcrumb-item active" aria-current="page">' . __('Recherche', 'mairie-france') . '</li>';
            
        elseif (is_404()) :
            echo '<li class="breadcrumb-item active" aria-current="page">' . __('Page non trouvée', 'mairie-france') . '</li>';
            
        elseif (is_archive()) :
            if (is_tax()) {
                $term = get_queried_object();
                echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html($term->name) . '</li>';
            } else {
                echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_archive_title() . '</li>';
            }
        endif;
        ?>
    </ol>
</nav>
