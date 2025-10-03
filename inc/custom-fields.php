<?php
/**
 * Custom Fields (Métaboxes)
 * 
 * Gestion des champs personnalisés pour les CPT
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * Ajouter les métaboxes
 */
function mairie_add_meta_boxes() {
    // Métabox pour Numéros Utiles
    add_meta_box(
        'mairie_numero_details',
        __('Informations du numéro', 'mairie-france'),
        'mairie_numero_metabox_callback',
        'numeros_utiles',
        'normal',
        'high'
    );
    
    // Métabox pour Services
    add_meta_box(
        'mairie_service_details',
        __('Informations du service', 'mairie-france'),
        'mairie_service_metabox_callback',
        'services',
        'normal',
        'high'
    );
    
    // Métabox pour Associations
    add_meta_box(
        'mairie_association_details',
        __('Informations de l\'association', 'mairie-france'),
        'mairie_association_metabox_callback',
        'associations',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mairie_add_meta_boxes');

/**
 * Callback métabox Numéros Utiles
 */
function mairie_numero_metabox_callback($post) {
    // Nonce pour sécurité
    wp_nonce_field('mairie_numero_meta_box', 'mairie_numero_meta_box_nonce');
    
    // Récupérer les valeurs existantes
    $phone    = get_post_meta($post->ID, '_mairie_numero_phone', true);
    $email    = get_post_meta($post->ID, '_mairie_numero_email', true);
    $address  = get_post_meta($post->ID, '_mairie_numero_address', true);
    $postal   = get_post_meta($post->ID, '_mairie_numero_postal', true);
    $city     = get_post_meta($post->ID, '_mairie_numero_city', true);
    $horaires = get_post_meta($post->ID, '_mairie_numero_horaires', true);
    $website  = get_post_meta($post->ID, '_mairie_numero_website', true);
    $notes    = get_post_meta($post->ID, '_mairie_numero_notes', true);
    ?>
    
    <div class="mairie-metabox">
        <p class="mairie-metabox-description">
            <?php _e('Remplissez les informations du numéro utile. Le téléphone est obligatoire.', 'mairie-france'); ?>
        </p>
        
        <div class="mairie-field-group">
            <div class="mairie-field required">
                <label for="mairie_numero_phone">
                    <?php _e('Téléphone', 'mairie-france'); ?> <span class="required">*</span>
                </label>
                <input 
                    type="tel" 
                    id="mairie_numero_phone" 
                    name="mairie_numero_phone" 
                    value="<?php echo esc_attr($phone); ?>" 
                    placeholder="01 23 45 67 89"
                    required
                    class="widefat"
                />
                <p class="description"><?php _e('Format recommandé : 01 23 45 67 89', 'mairie-france'); ?></p>
            </div>
            
            <div class="mairie-field">
                <label for="mairie_numero_email">
                    <?php _e('Email', 'mairie-france'); ?>
                </label>
                <input 
                    type="email" 
                    id="mairie_numero_email" 
                    name="mairie_numero_email" 
                    value="<?php echo esc_attr($email); ?>" 
                    placeholder="contact@exemple.fr"
                    class="widefat"
                />
            </div>
        </div>
        
        <div class="mairie-field-group">
            <div class="mairie-field">
                <label for="mairie_numero_address">
                    <?php _e('Adresse', 'mairie-france'); ?>
                </label>
                <input 
                    type="text" 
                    id="mairie_numero_address" 
                    name="mairie_numero_address" 
                    value="<?php echo esc_attr($address); ?>" 
                    placeholder="12 rue de la République"
                    class="widefat"
                />
            </div>
        </div>
        
        <div class="mairie-field-group mairie-field-row">
            <div class="mairie-field" style="flex: 0 0 30%;">
                <label for="mairie_numero_postal">
                    <?php _e('Code postal', 'mairie-france'); ?>
                </label>
                <input 
                    type="text" 
                    id="mairie_numero_postal" 
                    name="mairie_numero_postal" 
                    value="<?php echo esc_attr($postal); ?>" 
                    placeholder="75000"
                    class="widefat"
                />
            </div>
            
            <div class="mairie-field" style="flex: 1;">
                <label for="mairie_numero_city">
                    <?php _e('Ville', 'mairie-france'); ?>
                </label>
                <input 
                    type="text" 
                    id="mairie_numero_city" 
                    name="mairie_numero_city" 
                    value="<?php echo esc_attr($city); ?>" 
                    placeholder="Paris"
                    class="widefat"
                />
            </div>
        </div>
        
        <div class="mairie-field">
            <label for="mairie_numero_horaires">
                <?php _e('Horaires', 'mairie-france'); ?>
            </label>
            <textarea 
                id="mairie_numero_horaires" 
                name="mairie_numero_horaires" 
                rows="3"
                class="widefat"
                placeholder="Lun-Ven : 9h-12h / 14h-18h&#10;Sam : 9h-12h"
            ><?php echo esc_textarea($horaires); ?></textarea>
            <p class="description"><?php _e('Un horaire par ligne', 'mairie-france'); ?></p>
        </div>
        
        <div class="mairie-field">
            <label for="mairie_numero_website">
                <?php _e('Site web', 'mairie-france'); ?>
            </label>
            <input 
                type="url" 
                id="mairie_numero_website" 
                name="mairie_numero_website" 
                value="<?php echo esc_attr($website); ?>" 
                placeholder="https://www.exemple.fr"
                class="widefat"
            />
        </div>
        
        <div class="mairie-field">
            <label for="mairie_numero_notes">
                <?php _e('Notes / Informations complémentaires', 'mairie-france'); ?>
            </label>
            <textarea 
                id="mairie_numero_notes" 
                name="mairie_numero_notes" 
                rows="4"
                class="widefat"
                placeholder="Informations complémentaires..."
            ><?php echo esc_textarea($notes); ?></textarea>
        </div>
    </div>
    
    <?php
}

/**
 * Callback métabox Services
 */
function mairie_service_metabox_callback($post) {
    wp_nonce_field('mairie_service_meta_box', 'mairie_service_meta_box_nonce');
    
    $responsable   = get_post_meta($post->ID, '_mairie_service_responsable', true);
    $phone         = get_post_meta($post->ID, '_mairie_service_phone', true);
    $email         = get_post_meta($post->ID, '_mairie_service_email', true);
    $horaires      = get_post_meta($post->ID, '_mairie_service_horaires', true);
    $localisation  = get_post_meta($post->ID, '_mairie_service_localisation', true);
    $tablepress_id = get_post_meta($post->ID, '_mairie_service_tablepress', true);
    ?>
    
    <div class="mairie-metabox">
        <div class="mairie-field">
            <label for="mairie_service_responsable">
                <?php _e('Responsable du service', 'mairie-france'); ?>
            </label>
            <input 
                type="text" 
                id="mairie_service_responsable" 
                name="mairie_service_responsable" 
                value="<?php echo esc_attr($responsable); ?>" 
                placeholder="Nom du responsable"
                class="widefat"
            />
        </div>
        
        <div class="mairie-field-group mairie-field-row">
            <div class="mairie-field">
                <label for="mairie_service_phone">
                    <?php _e('Téléphone direct', 'mairie-france'); ?>
                </label>
                <input 
                    type="tel" 
                    id="mairie_service_phone" 
                    name="mairie_service_phone" 
                    value="<?php echo esc_attr($phone); ?>" 
                    placeholder="01 23 45 67 89"
                    class="widefat"
                />
            </div>
            
            <div class="mairie-field">
                <label for="mairie_service_email">
                    <?php _e('Email du service', 'mairie-france'); ?>
                </label>
                <input 
                    type="email" 
                    id="mairie_service_email" 
                    name="mairie_service_email" 
                    value="<?php echo esc_attr($email); ?>" 
                    placeholder="service@mairie.fr"
                    class="widefat"
                />
            </div>
        </div>
        
        <div class="mairie-field">
            <label for="mairie_service_horaires">
                <?php _e('Horaires d\'ouverture', 'mairie-france'); ?>
            </label>
            <textarea 
                id="mairie_service_horaires" 
                name="mairie_service_horaires" 
                rows="3"
                class="widefat"
                placeholder="Lun-Ven : 9h-12h / 14h-18h"
            ><?php echo esc_textarea($horaires); ?></textarea>
        </div>
        
        <div class="mairie-field">
            <label for="mairie_service_localisation">
                <?php _e('Localisation dans le bâtiment', 'mairie-france'); ?>
            </label>
            <input 
                type="text" 
                id="mairie_service_localisation" 
                name="mairie_service_localisation" 
                value="<?php echo esc_attr($localisation); ?>" 
                placeholder="Bâtiment A - 1er étage - Bureau 12"
                class="widefat"
            />
        </div>
        
        <div class="mairie-field">
            <label for="mairie_service_tablepress">
                <?php _e('ID du tableau TablePress (horaires détaillés)', 'mairie-france'); ?>
            </label>
            <input 
                type="text" 
                id="mairie_service_tablepress" 
                name="mairie_service_tablepress" 
                value="<?php echo esc_attr($tablepress_id); ?>" 
                placeholder="1"
                class="widefat"
            />
            <p class="description">
                <?php _e('Entrez l\'ID du tableau TablePress contenant les horaires détaillés (optionnel)', 'mairie-france'); ?>
            </p>
        </div>
    </div>
    
    <?php
}

/**
 * Callback métabox Associations
 */
function mairie_association_metabox_callback($post) {
    wp_nonce_field('mairie_association_meta_box', 'mairie_association_meta_box_nonce');
    
    $president = get_post_meta($post->ID, '_mairie_asso_president', true);
    $phone     = get_post_meta($post->ID, '_mairie_asso_phone', true);
    $email     = get_post_meta($post->ID, '_mairie_asso_email', true);
    $address   = get_post_meta($post->ID, '_mairie_asso_address', true);
    $website   = get_post_meta($post->ID, '_mairie_asso_website', true);
    $facebook  = get_post_meta($post->ID, '_mairie_asso_facebook', true);
    ?>
    
    <div class="mairie-metabox">
        <div class="mairie-field">
            <label for="mairie_asso_president">
                <?php _e('Président(e)', 'mairie-france'); ?>
            </label>
            <input 
                type="text" 
                id="mairie_asso_president" 
                name="mairie_asso_president" 
                value="<?php echo esc_attr($president); ?>" 
                placeholder="Nom du président"
                class="widefat"
            />
        </div>
        
        <div class="mairie-field-group mairie-field-row">
            <div class="mairie-field">
                <label for="mairie_asso_phone">
                    <?php _e('Téléphone', 'mairie-france'); ?>
                </label>
                <input 
                    type="tel" 
                    id="mairie_asso_phone" 
                    name="mairie_asso_phone" 
                    value="<?php echo esc_attr($phone); ?>" 
                    placeholder="01 23 45 67 89"
                    class="widefat"
                />
            </div>
            
            <div class="mairie-field">
                <label for="mairie_asso_email">
                    <?php _e('Email', 'mairie-france'); ?>
                </label>
                <input 
                    type="email" 
                    id="mairie_asso_email" 
                    name="mairie_asso_email" 
                    value="<?php echo esc_attr($email); ?>" 
                    placeholder="contact@association.fr"
                    class="widefat"
                />
            </div>
        </div>
        
        <div class="mairie-field">
            <label for="mairie_asso_address">
                <?php _e('Adresse du siège', 'mairie-france'); ?>
            </label>
            <textarea 
                id="mairie_asso_address" 
                name="mairie_asso_address" 
                rows="2"
                class="widefat"
                placeholder="12 rue de la République, 75000 Paris"
            ><?php echo esc_textarea($address); ?></textarea>
        </div>
        
        <div class="mairie-field">
            <label for="mairie_asso_website">
                <?php _e('Site web', 'mairie-france'); ?>
            </label>
            <input 
                type="url" 
                id="mairie_asso_website" 
                name="mairie_asso_website" 
                value="<?php echo esc_attr($website); ?>" 
                placeholder="https://www.association.fr"
                class="widefat"
            />
        </div>
        
        <div class="mairie-field">
            <label for="mairie_asso_facebook">
                <?php _e('Page Facebook', 'mairie-france'); ?>
            </label>
            <input 
                type="url" 
                id="mairie_asso_facebook" 
                name="mairie_asso_facebook" 
                value="<?php echo esc_attr($facebook); ?>" 
                placeholder="https://www.facebook.com/association"
                class="widefat"
            />
        </div>
    </div>
    
    <?php
}

/**
 * Sauvegarder les métadonnées - Numéros Utiles
 */
function mairie_save_numero_meta($post_id) {
    // Vérifications de sécurité
    if (!isset($_POST['mairie_numero_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['mairie_numero_meta_box_nonce'], 'mairie_numero_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Sauvegarder les champs
    $fields = array(
        'mairie_numero_phone'    => 'sanitize_text_field',
        'mairie_numero_email'    => 'sanitize_email',
        'mairie_numero_address'  => 'sanitize_text_field',
        'mairie_numero_postal'   => 'sanitize_text_field',
        'mairie_numero_city'     => 'sanitize_text_field',
        'mairie_numero_horaires' => 'sanitize_textarea_field',
        'mairie_numero_website'  => 'esc_url_raw',
        'mairie_numero_notes'    => 'sanitize_textarea_field',
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, $sanitize_function($_POST[$field]));
        }
    }
}
add_action('save_post_numeros_utiles', 'mairie_save_numero_meta');

/**
 * Sauvegarder les métadonnées - Services
 */
function mairie_save_service_meta($post_id) {
    if (!isset($_POST['mairie_service_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['mairie_service_meta_box_nonce'], 'mairie_service_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'mairie_service_responsable'   => 'sanitize_text_field',
        'mairie_service_phone'         => 'sanitize_text_field',
        'mairie_service_email'         => 'sanitize_email',
        'mairie_service_horaires'      => 'sanitize_textarea_field',
        'mairie_service_localisation'  => 'sanitize_text_field',
        'mairie_service_tablepress'    => 'sanitize_text_field',
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, $sanitize_function($_POST[$field]));
        }
    }
}
add_action('save_post_services', 'mairie_save_service_meta');

/**
 * Sauvegarder les métadonnées - Associations
 */
function mairie_save_association_meta($post_id) {
    if (!isset($_POST['mairie_association_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['mairie_association_meta_box_nonce'], 'mairie_association_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'mairie_asso_president' => 'sanitize_text_field',
        'mairie_asso_phone'     => 'sanitize_text_field',
        'mairie_asso_email'     => 'sanitize_email',
        'mairie_asso_address'   => 'sanitize_textarea_field',
        'mairie_asso_website'   => 'esc_url_raw',
        'mairie_asso_facebook'  => 'esc_url_raw',
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, $sanitize_function($_POST[$field]));
        }
    }
}
add_action('save_post_associations', 'mairie_save_association_meta');
