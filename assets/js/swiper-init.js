/**
 * @file
 * Initialisation de Swiper pour les carrousels
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  /**
   * Initialisation des carrousels Swiper
   */
  Drupal.behaviors.communeSwiper = {
    attach: function (context, settings) {
      $('.swiper-container', context).once('commune-swiper').each(function() {
        // Placeholder - à remplacer quand Swiper.js sera chargé
        console.log('Swiper container found:', this);
        
        // Navigation basique avec les flèches du clavier
        $(this).on('keydown', function(e) {
          if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            e.preventDefault();
            // Logique de navigation basique
            console.log('Navigation:', e.key);
          }
        });
      });
    }
  };

})(jQuery, Drupal, drupalSettings);