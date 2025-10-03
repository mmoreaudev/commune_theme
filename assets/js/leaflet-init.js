/**
 * @file
 * Initialisation de Leaflet pour les cartes
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  /**
   * Initialisation des cartes Leaflet
   */
  Drupal.behaviors.communeLeaflet = {
    attach: function (context, settings) {
      $('.leaflet-map', context).once('commune-leaflet').each(function() {
        var $map = $(this);
        
        // Placeholder - à remplacer quand Leaflet.js sera chargé
        console.log('Leaflet map container found:', this);
        
        // Message temporaire
        $map.html('<div style="padding: 2rem; text-align: center; background: #f0f0f0; border: 1px solid #ccc;">Carte interactive - Leaflet.js requis</div>');
        
        // Accessibilité
        $map.attr({
          'role': 'img',
          'aria-label': 'Carte interactive de la commune'
        });
      });
    }
  };

})(jQuery, Drupal, drupalSettings);