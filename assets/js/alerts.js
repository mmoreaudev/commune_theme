/**
 * @file
 * JavaScript pour la gestion des alertes de la commune
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  /**
   * Gestion des blocs d'alerte
   */
  Drupal.behaviors.communeAlerts = {
    attach: function (context, settings) {
      const alerts = $('.commune-alert', context);
      
      if (!alerts.length) return;
      
      alerts.once('commune-alert').each(function() {
        const $alert = $(this);
        const settings = drupalSettings.commune_alert || {};
        
        // Ajouter les boutons de fermeture si l'alerte est dismissible
        if (settings.dismissible && !$alert.find('.alert-close').length) {
          const closeBtn = $('<button type="button" class="alert-close" aria-label="' + 
                           Drupal.t('Fermer l\'alerte') + '">' +
                           '<span aria-hidden="true">&times;</span></button>');
          
          $alert.append(closeBtn);
          
          closeBtn.on('click', function(e) {
            e.preventDefault();
            dismissAlert($alert);
          });
        }
        
        // Vérifier si l'alerte a déjà été fermée
        const alertId = $alert.data('alert-id') || 'default';
        const dismissedAlerts = JSON.parse(sessionStorage.getItem('commune-dismissed-alerts') || '[]');
        
        if (dismissedAlerts.includes(alertId)) {
          $alert.hide();
          return;
        }
        
        // Afficher l'alerte avec animation
        $alert.addClass('alert-show');
        
        // Masquage automatique si configuré
        if (settings.auto_hide && settings.auto_hide_delay) {
          setTimeout(function() {
            if ($alert.is(':visible')) {
              dismissAlert($alert, true);
            }
          }, parseInt(settings.auto_hide_delay));
        }
        
        // Gestion de la fermeture avec Échap
        $(document).on('keydown.commune-alert', function(e) {
          if (e.key === 'Escape' && $alert.is(':visible') && settings.dismissible) {
            dismissAlert($alert);
          }
        });
      });
    }
  };
  
  /**
   * Fonction pour fermer une alerte
   */
  function dismissAlert($alert, isAuto = false) {
    const alertId = $alert.data('alert-id') || 'default';
    
    // Animation de fermeture
    $alert.addClass('alert-dismissing');
    
    setTimeout(function() {
      $alert.slideUp(300, function() {
        $alert.hide().removeClass('alert-show alert-dismissing');
        
        // Sauvegarder l'état de fermeture en session
        const dismissedAlerts = JSON.parse(sessionStorage.getItem('commune-dismissed-alerts') || '[]');
        if (!dismissedAlerts.includes(alertId)) {
          dismissedAlerts.push(alertId);
          sessionStorage.setItem('commune-dismissed-alerts', JSON.stringify(dismissedAlerts));
        }
        
        // Annoncer la fermeture pour l'accessibilité
        if (!isAuto) {
          Drupal.announce(Drupal.t('Alerte fermée'), 'polite');
        }
      });
    }, isAuto ? 0 : 150);
  }
  
  /**
   * API pour créer des alertes dynamiques
   */
  Drupal.communeAlert = {
    show: function(message, type = 'info', options = {}) {
      const defaults = {
        dismissible: true,
        autoHide: false,
        autoHideDelay: 5000,
        position: 'top',
        id: 'dynamic-' + Date.now()
      };
      
      const config = Object.assign(defaults, options);
      
      const alertHtml = 
        '<div class="commune-alert alert-' + type + ' alert-dynamic" ' +
             'data-alert-id="' + config.id + '" ' +
             'role="alert" aria-live="assertive">' +
          '<div class="alert-content">' +
            '<div class="alert-message">' + message + '</div>' +
          '</div>' +
        '</div>';
      
      const $alert = $(alertHtml);
      
      // Ajouter au DOM selon la position
      if (config.position === 'top') {
        $('body').prepend($alert);
      } else {
        $('body').append($alert);
      }
      
      // Appliquer le comportement d'alerte
      Drupal.behaviors.communeAlerts.attach($alert.get(0), {
        commune_alert: {
          dismissible: config.dismissible,
          auto_hide: config.autoHide,
          auto_hide_delay: config.autoHideDelay
        }
      });
      
      return $alert;
    },
    
    dismiss: function(alertId) {
      const $alert = $('.commune-alert[data-alert-id="' + alertId + '"]');
      if ($alert.length) {
        dismissAlert($alert);
      }
    },
    
    dismissAll: function() {
      $('.commune-alert').each(function() {
        dismissAlert($(this));
      });
    }
  };

})(jQuery, Drupal, drupalSettings);