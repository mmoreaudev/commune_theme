/**
 * @file
 * Commune Theme - JavaScript d'accessibilité avancé
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  /**
   * Gestion avancée du focus et de la navigation clavier
   */
  Drupal.behaviors.communeAccessibility = {
    attach: function (context, settings) {
      var $context = $(context);

      // Gestion du focus trap dans les modales
      $context.find('.modal, .dialog').once('commune-focus-trap').each(function() {
        var $modal = $(this);
        var focusableElements = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        var firstFocusable = focusableElements.first();
        var lastFocusable = focusableElements.last();

        $modal.on('keydown', function(e) {
          if (e.key === 'Tab') {
            if (e.shiftKey) {
              if (document.activeElement === firstFocusable[0]) {
                e.preventDefault();
                lastFocusable.focus();
              }
            } else {
              if (document.activeElement === lastFocusable[0]) {
                e.preventDefault();
                firstFocusable.focus();
              }
            }
          }
        });
      });

      // Amélioration des boutons avec état pressé
      $context.find('[aria-pressed]').once('commune-toggle-button').on('click', function() {
        var $button = $(this);
        var pressed = $button.attr('aria-pressed') === 'true';
        $button.attr('aria-pressed', !pressed);
      });

      // Gestion des régions live pour les mises à jour dynamiques
      if (!$('#commune-live-region').length) {
        $('body').append('<div id="commune-live-region" aria-live="polite" aria-atomic="true" class="visually-hidden"></div>');
      }

      // Support des raccourcis clavier globaux
      $(document).on('keydown.commune-shortcuts', function(e) {
        // Alt + 1 : Aller au contenu principal
        if (e.altKey && e.key === '1') {
          e.preventDefault();
          $('#main-content').focus();
          Drupal.announceAccessibility('Navigation vers le contenu principal');
        }
        
        // Alt + 2 : Aller au menu principal
        if (e.altKey && e.key === '2') {
          e.preventDefault();
          $('.main-navigation a').first().focus();
          Drupal.announceAccessibility('Navigation vers le menu principal');
        }
        
        // Alt + 3 : Aller à la recherche
        if (e.altKey && e.key === '3') {
          e.preventDefault();
          $('input[type="search"], .search-form input').first().focus();
          Drupal.announceAccessibility('Navigation vers la recherche');
        }
      });
    }
  };

  /**
   * Amélioration des formulaires pour l'accessibilité
   */
  Drupal.behaviors.communeFormsAccessibility = {
    attach: function (context, settings) {
      // Améliorer les messages d'erreur
      $(context).find('.form-item.error').once('commune-form-error').each(function() {
        var $item = $(this);
        var $input = $item.find('input, textarea, select');
        var $error = $item.find('.form-error, .error');
        
        if ($input.length && $error.length) {
          var errorId = 'error-' + Math.random().toString(36).substr(2, 9);
          $error.attr('id', errorId);
          $input.attr('aria-describedby', errorId);
          $input.attr('aria-invalid', 'true');
        }
      });

      // Validation en temps réel accessible
      $(context).find('input[required], textarea[required]').once('commune-required-validation').on('blur', function() {
        var $input = $(this);
        var value = $input.val().trim();
        
        if (!value) {
          $input.attr('aria-invalid', 'true');
          // Créer ou mettre à jour le message d'erreur
          var errorId = $input.attr('aria-describedby') || 'error-' + Math.random().toString(36).substr(2, 9);
          var $error = $('#' + errorId);
          
          if (!$error.length) {
            $error = $('<div id="' + errorId + '" class="form-error" role="alert"></div>');
            $input.after($error);
            $input.attr('aria-describedby', errorId);
          }
          
          $error.text(Drupal.t('Ce champ est obligatoire.'));
        } else {
          $input.removeAttr('aria-invalid');
          var errorId = $input.attr('aria-describedby');
          if (errorId) {
            $('#' + errorId).remove();
            $input.removeAttr('aria-describedby');
          }
        }
      });
    }
  };

  /**
   * Fonction d'annonce dédiée à l'accessibilité
   */
  Drupal.announceAccessibility = function(message, priority) {
    priority = priority || 'polite';
    var $liveRegion = $('#commune-live-region');
    
    if ($liveRegion.length) {
      $liveRegion.attr('aria-live', priority).text(message);
      
      // Nettoyer après l'annonce
      setTimeout(function() {
        $liveRegion.empty();
      }, 1000);
    }
  };

  /**
   * Gestion des préférences d'accessibilité
   */
  Drupal.behaviors.communeAccessibilityPreferences = {
    attach: function (context, settings) {
      // Restaurer les préférences sauvegardées
      var preferences = JSON.parse(localStorage.getItem('commune-accessibility-preferences') || '{}');
      
      // Appliquer les préférences
      if (preferences.highContrast) {
        document.body.classList.add('high-contrast');
      }
      
      if (preferences.fontSize && preferences.fontSize !== 'normal') {
        document.body.classList.add('font-size-' + preferences.fontSize);
      }
      
      if (preferences.reducedMotion) {
        document.body.classList.add('reduced-motion');
      }
      
      // Sauvegarder les nouvelles préférences
      $(document).on('commune-preference-change', function(e, preference, value) {
        preferences[preference] = value;
        localStorage.setItem('commune-accessibility-preferences', JSON.stringify(preferences));
      });
    }
  };

  /**
   * Navigation au clavier améliorée pour les éléments complexes
   */
  Drupal.behaviors.communeKeyboardNavigation = {
    attach: function (context, settings) {
      // Navigation dans les carrousels avec les flèches
      $(context).find('.carousel, .slider').once('commune-carousel-nav').each(function() {
        var $carousel = $(this);
        
        $carousel.on('keydown', function(e) {
          if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            e.preventDefault();
            var direction = e.key === 'ArrowLeft' ? 'prev' : 'next';
            
            // Déclencher l'événement de navigation
            $carousel.trigger('carousel-navigate', [direction]);
            
            // Annoncer le changement
            var currentSlide = $carousel.find('.active').index() + 1;
            var totalSlides = $carousel.find('.slide').length;
            Drupal.announceAccessibility(
              Drupal.t('Diapositive @current sur @total', {
                '@current': currentSlide,
                '@total': totalSlides
              })
            );
          }
        });
      });

      // Navigation dans les tableaux avec les flèches
      $(context).find('table').once('commune-table-nav').on('keydown', 'td, th', function(e) {
        var $cell = $(this);
        var $row = $cell.parent();
        var $table = $cell.closest('table');
        var cellIndex = $cell.index();
        var rowIndex = $row.index();
        
        var $targetCell;
        
        switch (e.key) {
          case 'ArrowUp':
            e.preventDefault();
            $targetCell = $table.find('tr').eq(rowIndex - 1).find('td, th').eq(cellIndex);
            break;
          case 'ArrowDown':
            e.preventDefault();
            $targetCell = $table.find('tr').eq(rowIndex + 1).find('td, th').eq(cellIndex);
            break;
          case 'ArrowLeft':
            e.preventDefault();
            $targetCell = $cell.prev('td, th');
            break;
          case 'ArrowRight':
            e.preventDefault();
            $targetCell = $cell.next('td, th');
            break;
        }
        
        if ($targetCell && $targetCell.length) {
          $targetCell.focus();
        }
      });
    }
  };

})(jQuery, Drupal, drupalSettings);