<?php
/**
 * Widgets personnalisés
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

// Sécurité
if (!defined('ABSPATH')) exit;

/**
 * Enregistrement des widgets
 */
function mairie_register_widgets() {
    register_widget('Mairie_Widget_Liens_Pratiques');
    register_widget('Mairie_Widget_Numeros_Urgence');
    register_widget('Mairie_Widget_Horaires_Mairie');
    register_widget('Mairie_Widget_Actualite_Une');
    register_widget('Mairie_Widget_Prochain_Evenement');
    register_widget('Mairie_Widget_Acces_Rapides');
}
add_action('widgets_init', 'mairie_register_widgets');

/**
 * Widget Liens Pratiques
 */
class Mairie_Widget_Liens_Pratiques extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mairie_liens_pratiques',
            __('Mairie - Liens Pratiques', 'mairie-france'),
            array('description' => __('Affiche une liste de liens pratiques avec icônes', 'mairie-france'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $liens = !empty($instance['liens']) ? $instance['liens'] : array();
        
        if (!empty($liens)) {
            echo '<ul class="widget-liens-pratiques">';
            foreach ($liens as $lien) {
                if (!empty($lien['url']) && !empty($lien['text'])) {
                    $icon = !empty($lien['icon']) ? $lien['icon'] : 'link';
                    $target = !empty($lien['new_tab']) ? ' target="_blank" rel="noopener noreferrer"' : '';
                    
                    echo '<li>';
                    echo '<a href="' . esc_url($lien['url']) . '"' . $target . '>';
                    echo '<span class="icon-' . esc_attr($icon) . '" aria-hidden="true"></span>';
                    echo '<span>' . esc_html($lien['text']) . '</span>';
                    echo '</a>';
                    echo '</li>';
                }
            }
            echo '</ul>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Liens Pratiques', 'mairie-france');
        $liens = !empty($instance['liens']) ? $instance['liens'] : array(
            array('text' => '', 'url' => '', 'icon' => 'link', 'new_tab' => false)
        );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Titre:', 'mairie-france'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        
        <div class="mairie-widget-liens">
            <p><strong><?php _e('Liens :', 'mairie-france'); ?></strong></p>
            <?php foreach ($liens as $index => $lien) : ?>
                <div class="mairie-widget-lien-item" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                    <p>
                        <label><?php _e('Texte:', 'mairie-france'); ?></label>
                        <input class="widefat" type="text" 
                               name="<?php echo esc_attr($this->get_field_name('liens')); ?>[<?php echo $index; ?>][text]" 
                               value="<?php echo esc_attr($lien['text']); ?>">
                    </p>
                    <p>
                        <label><?php _e('URL:', 'mairie-france'); ?></label>
                        <input class="widefat" type="url" 
                               name="<?php echo esc_attr($this->get_field_name('liens')); ?>[<?php echo $index; ?>][url]" 
                               value="<?php echo esc_attr($lien['url']); ?>">
                    </p>
                    <p>
                        <label><?php _e('Icône:', 'mairie-france'); ?></label>
                        <select class="widefat" name="<?php echo esc_attr($this->get_field_name('liens')); ?>[<?php echo $index; ?>][icon]">
                            <option value="link" <?php selected($lien['icon'], 'link'); ?>>Lien</option>
                            <option value="file" <?php selected($lien['icon'], 'file'); ?>>Document</option>
                            <option value="user" <?php selected($lien['icon'], 'user'); ?>>Utilisateur</option>
                            <option value="calendar" <?php selected($lien['icon'], 'calendar'); ?>>Calendrier</option>
                            <option value="map" <?php selected($lien['icon'], 'map'); ?>>Carte</option>
                        </select>
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" 
                                   name="<?php echo esc_attr($this->get_field_name('liens')); ?>[<?php echo $index; ?>][new_tab]" 
                                   value="1" <?php checked(!empty($lien['new_tab'])); ?>>
                            <?php _e('Ouvrir dans un nouvel onglet', 'mairie-france'); ?>
                        </label>
                    </p>
                </div>
            <?php endforeach; ?>
            <p>
                <em><?php _e('Utilisez le Customizer pour une interface plus complète', 'mairie-france'); ?></em>
            </p>
        </div>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['liens'] = !empty($new_instance['liens']) ? $new_instance['liens'] : array();
        return $instance;
    }
}

/**
 * Widget Numéros d'Urgence
 */
class Mairie_Widget_Numeros_Urgence extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mairie_numeros_urgence',
            __('Mairie - Numéros d\'Urgence', 'mairie-france'),
            array('description' => __('Affiche les numéros d\'urgence importants', 'mairie-france'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Numéros par défaut
        $numeros_defaut = array(
            array('nom' => 'SAMU', 'numero' => '15', 'classe' => 'samu'),
            array('nom' => 'Police / Gendarmerie', 'numero' => '17', 'classe' => 'police'),
            array('nom' => 'Pompiers', 'numero' => '18', 'classe' => 'pompiers'),
            array('nom' => 'Urgence Européenne', 'numero' => '112', 'classe' => 'europe'),
        );
        
        // Numéros personnalisés
        $numeros_custom = !empty($instance['numeros']) ? $instance['numeros'] : array();
        
        // Fusionner
        $tous_numeros = array_merge($numeros_defaut, $numeros_custom);
        
        echo '<ul class="widget-numeros-urgence">';
        foreach ($tous_numeros as $numero) {
            $classe = !empty($numero['classe']) ? ' urgence-' . esc_attr($numero['classe']) : '';
            $tel_clean = str_replace(' ', '', $numero['numero']);
            
            echo '<li class="numero-urgence' . $classe . '">';
            echo '<span class="numero-nom">' . esc_html($numero['nom']) . '</span>';
            echo '<a href="tel:' . esc_attr($tel_clean) . '" class="numero-tel">';
            echo '<span class="icon-phone" aria-hidden="true"></span>';
            echo '<strong>' . esc_html($numero['numero']) . '</strong>';
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Numéros d\'Urgence', 'mairie-france');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Titre:', 'mairie-france'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <em><?php _e('Les numéros d\'urgence standards (15, 17, 18, 112) sont affichés automatiquement.', 'mairie-france'); ?></em>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Widget Horaires Mairie
 */
class Mairie_Widget_Horaires_Mairie extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mairie_horaires',
            __('Mairie - Horaires d\'Ouverture', 'mairie-france'),
            array('description' => __('Affiche les horaires avec statut ouvert/fermé', 'mairie-france'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Statut ouvert/fermé
        $is_open = $this->check_if_open($instance);
        
        echo '<div class="widget-horaires-mairie">';
        
        echo '<div class="horaires-statut ' . ($is_open ? 'ouvert' : 'ferme') . '">';
        echo '<span class="statut-icon" aria-hidden="true"></span>';
        echo '<strong>' . ($is_open ? __('Ouvert', 'mairie-france') : __('Fermé', 'mairie-france')) . '</strong>';
        echo '</div>';
        
        echo '<div class="horaires-liste">';
        for ($i = 1; $i <= 7; $i++) {
            $jour_key = 'jour_' . $i;
            if (!empty($instance[$jour_key . '_enabled'])) {
                $jour_nom = $this->get_jour_name($i);
                $horaire = !empty($instance[$jour_key]) ? $instance[$jour_key] : '';
                
                echo '<div class="horaire-ligne">';
                echo '<span class="horaire-jour">' . esc_html($jour_nom) . '</span>';
                echo '<span class="horaire-heures">' . esc_html($horaire) . '</span>';
                echo '</div>';
            }
        }
        echo '</div>';
        
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    private function get_jour_name($num) {
        $jours = array(
            1 => __('Lundi', 'mairie-france'),
            2 => __('Mardi', 'mairie-france'),
            3 => __('Mercredi', 'mairie-france'),
            4 => __('Jeudi', 'mairie-france'),
            5 => __('Vendredi', 'mairie-france'),
            6 => __('Samedi', 'mairie-france'),
            7 => __('Dimanche', 'mairie-france'),
        );
        return $jours[$num];
    }
    
    private function check_if_open($instance) {
        $current_day = date('N'); // 1 (lundi) à 7 (dimanche)
        $current_time = date('H:i');
        
        $jour_key = 'jour_' . $current_day;
        
        if (empty($instance[$jour_key . '_enabled'])) {
            return false; // Fermé ce jour
        }
        
        // Logique simplifiée - à améliorer pour parsing heures
        return true; // Pour l'instant toujours ouvert si le jour est activé
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Horaires d\'Ouverture', 'mairie-france');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Titre:', 'mairie-france'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        
        <?php for ($i = 1; $i <= 7; $i++) : 
            $jour_key = 'jour_' . $i;
            $enabled = !empty($instance[$jour_key . '_enabled']);
            $horaire = !empty($instance[$jour_key]) ? $instance[$jour_key] : '9h-12h / 14h-17h';
        ?>
            <p>
                <label>
                    <input type="checkbox" 
                           name="<?php echo esc_attr($this->get_field_name($jour_key . '_enabled')); ?>" 
                           value="1" <?php checked($enabled); ?>>
                    <strong><?php echo $this->get_jour_name($i); ?></strong>
                </label>
                <input class="widefat" type="text" 
                       name="<?php echo esc_attr($this->get_field_name($jour_key)); ?>" 
                       value="<?php echo esc_attr($horaire); ?>"
                       placeholder="9h-12h / 14h-17h">
            </p>
        <?php endfor; ?>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        
        for ($i = 1; $i <= 7; $i++) {
            $jour_key = 'jour_' . $i;
            $instance[$jour_key . '_enabled'] = !empty($new_instance[$jour_key . '_enabled']);
            $instance[$jour_key] = !empty($new_instance[$jour_key]) ? sanitize_text_field($new_instance[$jour_key]) : '';
        }
        
        return $instance;
    }
}

/**
 * Widget Actualité à la Une
 */
class Mairie_Widget_Actualite_Une extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mairie_actualite_une',
            __('Mairie - Actualité à la Une', 'mairie-france'),
            array('description' => __('Affiche un article mis en avant', 'mairie-france'))
        );
    }
    
    public function widget($args, $instance) {
        $post_id = !empty($instance['post_id']) ? $instance['post_id'] : 0;
        
        // Si pas de post sélectionné, prendre le plus récent
        if (!$post_id) {
            $recent = wp_get_recent_posts(array('numberposts' => 1));
            if ($recent) {
                $post_id = $recent[0]['ID'];
            }
        }
        
        if (!$post_id) {
            return;
        }
        
        $post = get_post($post_id);
        if (!$post) {
            return;
        }
        
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        ?>
        <article class="widget-actualite-une">
            <?php if (has_post_thumbnail($post_id)) : ?>
                <div class="actualite-thumbnail">
                    <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                        <?php echo get_the_post_thumbnail($post_id, 'mairie-thumbnail'); ?>
                    </a>
                </div>
            <?php endif; ?>
            
            <div class="actualite-content">
                <h3 class="actualite-title">
                    <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                        <?php echo esc_html(get_the_title($post_id)); ?>
                    </a>
                </h3>
                
                <div class="actualite-meta">
                    <time datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>">
                        <?php echo get_the_date('', $post_id); ?>
                    </time>
                </div>
                
                <div class="actualite-excerpt">
                    <?php echo wp_trim_words(get_the_excerpt($post_id), 15); ?>
                </div>
                
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="actualite-link">
                    <?php _e('Lire la suite', 'mairie-france'); ?> &raquo;
                </a>
            </div>
        </article>
        <?php
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('À la Une', 'mairie-france');
        $post_id = !empty($instance['post_id']) ? $instance['post_id'] : 0;
        
        // Récupérer les articles récents
        $recent_posts = wp_get_recent_posts(array('numberposts' => 20));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Titre:', 'mairie-france'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_id')); ?>">
                <?php _e('Article à afficher:', 'mairie-france'); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_id')); ?>" 
                    name="<?php echo esc_attr($this->get_field_name('post_id')); ?>">
                <option value="0"><?php _e('Plus récent', 'mairie-france'); ?></option>
                <?php foreach ($recent_posts as $post) : ?>
                    <option value="<?php echo esc_attr($post['ID']); ?>" <?php selected($post_id, $post['ID']); ?>>
                        <?php echo esc_html($post['post_title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['post_id'] = !empty($new_instance['post_id']) ? absint($new_instance['post_id']) : 0;
        return $instance;
    }
}

/**
 * Widget Prochain Événement
 */
class Mairie_Widget_Prochain_Evenement extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mairie_prochain_event',
            __('Mairie - Prochain Événement', 'mairie-france'),
            array('description' => __('Affiche le prochain événement (The Events Calendar)', 'mairie-france'))
        );
    }
    
    public function widget($args, $instance) {
        // Vérifier si The Events Calendar est actif
        if (!class_exists('Tribe__Events__Main')) {
            return;
        }
        
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Récupérer le prochain événement
        $events = tribe_get_events(array(
            'posts_per_page' => 1,
            'start_date'     => 'now',
            'order'          => 'ASC',
        ));
        
        if ($events) :
            $event = $events[0];
            ?>
            <div class="widget-prochain-evenement">
                <?php if (has_post_thumbnail($event->ID)) : ?>
                    <div class="evenement-thumbnail">
                        <a href="<?php echo esc_url(get_permalink($event->ID)); ?>">
                            <?php echo get_the_post_thumbnail($event->ID, 'mairie-thumbnail'); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="evenement-content">
                    <div class="evenement-date">
                        <span class="icon-calendar" aria-hidden="true"></span>
                        <?php echo tribe_get_start_date($event->ID, false, 'd F Y'); ?>
                    </div>
                    
                    <h3 class="evenement-title">
                        <a href="<?php echo esc_url(get_permalink($event->ID)); ?>">
                            <?php echo esc_html(get_the_title($event->ID)); ?>
                        </a>
                    </h3>
                    
                    <?php if ($venue = tribe_get_venue($event->ID)) : ?>
                        <div class="evenement-lieu">
                            <span class="icon-map" aria-hidden="true"></span>
                            <?php echo esc_html($venue); ?>
                        </div>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url(home_url('/evenements')); ?>" class="button button-small">
                        <?php _e('Voir l\'agenda', 'mairie-france'); ?>
                    </a>
                </div>
            </div>
            <?php
        else :
            ?>
            <p><?php _e('Aucun événement à venir pour le moment.', 'mairie-france'); ?></p>
            <?php
        endif;
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Prochain Événement', 'mairie-france');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Titre:', 'mairie-france'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php if (!class_exists('Tribe__Events__Main')) : ?>
            <p style="color: #d63638;">
                <strong><?php _e('Attention :', 'mairie-france'); ?></strong>
                <?php _e('The Events Calendar n\'est pas installé ou activé.', 'mairie-france'); ?>
            </p>
        <?php endif; ?>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Widget Accès Rapides
 */
class Mairie_Widget_Acces_Rapides extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mairie_acces_rapides',
            __('Mairie - Accès Rapides', 'mairie-france'),
            array('description' => __('Blocs de boutons personnalisables avec icônes', 'mairie-france'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $boutons = !empty($instance['boutons']) ? $instance['boutons'] : array();
        
        if (!empty($boutons)) {
            echo '<div class="widget-acces-rapides">';
            foreach ($boutons as $bouton) {
                if (!empty($bouton['url']) && !empty($bouton['text'])) {
                    $icon = !empty($bouton['icon']) ? $bouton['icon'] : 'link';
                    $color = !empty($bouton['color']) ? $bouton['color'] : 'primary';
                    $target = !empty($bouton['new_tab']) ? ' target="_blank" rel="noopener noreferrer"' : '';
                    
                    echo '<a href="' . esc_url($bouton['url']) . '" class="acces-rapide acces-rapide-' . esc_attr($color) . '"' . $target . '>';
                    echo '<span class="icon-' . esc_attr($icon) . '" aria-hidden="true"></span>';
                    echo '<span>' . esc_html($bouton['text']) . '</span>';
                    echo '</a>';
                }
            }
            echo '</div>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Accès Rapides', 'mairie-france');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Titre:', 'mairie-france'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <em><?php _e('Configurez les boutons dans l\'interface ci-dessous. Vous pouvez ajouter jusqu\'à 6 boutons.', 'mairie-france'); ?></em>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['boutons'] = !empty($new_instance['boutons']) ? $new_instance['boutons'] : array();
        return $instance;
    }
}
