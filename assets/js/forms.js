/**
 * @file
 * JavaScript pour les formulaires de la commune
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  /**
   * Amélioration des formulaires
   */
  Drupal.behaviors.communeForms = {
    attach: function (context, settings) {
      // Améliorer l'accessibilité des champs obligatoires
      $(context).find('input[required], textarea[required], select[required]')
        .once('commune-required')
        .each(function() {
          var $field = $(this);
          var $label = $field.closest('.form-item').find('label');
          
          if ($label.length && !$label.find('.form-required').length) {
            $label.append(' <span class="form-required" aria-label="(obligatoire)">*</span>');
          }
        });

      // Validation en temps réel
      $(context).find('.form-item input, .form-item textarea, .form-item select')
        .once('commune-form-validation')
        .on('blur', function() {
          var $field = $(this);
          var $item = $field.closest('.form-item');
          
          if ($field.prop('required') && !$field.val().trim()) {
            $item.addClass('has-error');
            $field.attr('aria-invalid', 'true');
          } else {
            $item.removeClass('has-error');
            $field.removeAttr('aria-invalid');
          }
        });
    }
  };

})(jQuery, Drupal, drupalSettings);