<?php
/**
 * Sidebar principale
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

// Ne rien afficher si pas de sidebar
if (!is_active_sidebar('sidebar-main')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar-main" role="complementary" aria-label="<?php esc_attr_e('Barre latérale', 'mairie-france'); ?>">
    <?php dynamic_sidebar('sidebar-main'); ?>
</aside>
