/**
 * Admin JavaScript - Mairie France Theme
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // ===== MEDIA UPLOADER POUR MÉTABOXES =====
        var mediaUploader;
        
        $('.mairie-upload-button').on('click', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $input = $button.siblings('.mairie-upload-input');
            var $preview = $button.siblings('.mairie-upload-preview');
            
            // Si le media uploader existe déjà, l'ouvrir
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            // Créer le media uploader
            mediaUploader = wp.media({
                title: 'Sélectionner une image',
                button: {
                    text: 'Utiliser cette image'
                },
                multiple: false
            });
            
            // Quand une image est sélectionnée
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                
                $input.val(attachment.url);
                
                if ($preview.length) {
                    $preview.html('<img src="' + attachment.url + '" style="max-width: 200px;">');
                }
            });
            
            mediaUploader.open();
        });
        
        // Bouton supprimer image
        $('.mairie-remove-image').on('click', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $input = $button.siblings('.mairie-upload-input');
            var $preview = $button.siblings('.mairie-upload-preview');
            
            $input.val('');
            $preview.empty();
        });
        
        // ===== VALIDATION FORMULAIRES =====
        $('form.mairie-admin-form').on('submit', function(e) {
            var $form = $(this);
            var isValid = true;
            
            // Vérifier les champs requis
            $form.find('[required]').each(function() {
                var $field = $(this);
                
                if (!$field.val()) {
                    isValid = false;
                    $field.addClass('error');
                    
                    if (!$field.siblings('.error-message').length) {
                        $field.after('<span class="error-message">Ce champ est requis</span>');
                    }
                } else {
                    $field.removeClass('error');
                    $field.siblings('.error-message').remove();
                }
            });
            
            // Validation téléphone
            $form.find('input[type="tel"]').each(function() {
                var $field = $(this);
                var value = $field.val();
                
                if (value && !value.match(/^[0-9\s\.\-\+\(\)]+$/)) {
                    isValid = false;
                    $field.addClass('error');
                    
                    if (!$field.siblings('.error-message').length) {
                        $field.after('<span class="error-message">Format de téléphone invalide</span>');
                    }
                }
            });
            
            // Validation email
            $form.find('input[type="email"]').each(function() {
                var $field = $(this);
                var value = $field.val();
                
                if (value && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    isValid = false;
                    $field.addClass('error');
                    
                    if (!$field.siblings('.error-message').length) {
                        $field.after('<span class="error-message">Format d\'email invalide</span>');
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll vers la première erreur
                var $firstError = $form.find('.error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 100
                    }, 300);
                    $firstError.focus();
                }
            }
        });
        
        // ===== CONFIRMATION SUPPRESSION =====
        $('.delete-item').on('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
        
        // ===== DRAG & DROP POUR RÉORGANISER =====
        if ($('.sortable-list').length && $.fn.sortable) {
            $('.sortable-list').sortable({
                handle: '.drag-handle',
                placeholder: 'sortable-placeholder',
                update: function(event, ui) {
                    // Sauvegarder l'ordre via AJAX
                    var order = $(this).sortable('toArray');
                    
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'mairie_save_order',
                            order: order,
                            nonce: mairieAdmin.nonce
                        },
                        success: function(response) {
                            if (response.success) {
                                showNotification('Ordre sauvegardé', 'success');
                            }
                        }
                    });
                }
            });
        }
        
        // ===== ONGLETS DANS L'ADMIN =====
        $('.mairie-admin-tabs .tab-button').on('click', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var tab = $button.data('tab');
            var $container = $button.closest('.mairie-admin-tabs');
            
            $container.find('.tab-button').removeClass('active');
            $button.addClass('active');
            
            $container.find('.tab-content').removeClass('active');
            $container.find('#' + tab).addClass('active');
        });
        
        // ===== COPIER DANS LE PRESSE-PAPIER =====
        $('.copy-to-clipboard').on('click', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var text = $button.data('copy') || $button.siblings('input').val();
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    showNotification('Copié dans le presse-papier', 'success');
                });
            } else {
                // Fallback pour navigateurs plus anciens
                var $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(text).select();
                document.execCommand('copy');
                $temp.remove();
                showNotification('Copié dans le presse-papier', 'success');
            }
        });
        
        // ===== NOTIFICATIONS =====
        function showNotification(message, type) {
            type = type || 'info';
            
            var $notification = $('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
            $('.wrap > h1').after($notification);
            
            setTimeout(function() {
                $notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
        
        // ===== AIDE CONTEXTUELLE =====
        $('.mairie-help-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).next('.mairie-help-content').slideToggle(300);
        });
        
        // ===== AUTO-SAVE =====
        var autoSaveTimer;
        var hasChanged = false;
        
        $('.mairie-admin-form :input').on('change', function() {
            hasChanged = true;
            
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function() {
                if (hasChanged) {
                    autoSave();
                }
            }, 5000);
        });
        
        function autoSave() {
            var $form = $('.mairie-admin-form');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: $form.serialize() + '&action=mairie_autosave',
                success: function(response) {
                    if (response.success) {
                        showNotification('Brouillon enregistré', 'success');
                        hasChanged = false;
                    }
                }
            });
        }
        
        // ===== AVERTISSEMENT CHANGEMENTS NON SAUVEGARDÉS =====
        $(window).on('beforeunload', function() {
            if (hasChanged) {
                return 'Vous avez des modifications non sauvegardées. Voulez-vous vraiment quitter cette page ?';
            }
        });
        
        // Désactiver l'avertissement lors de la soumission
        $('form').on('submit', function() {
            hasChanged = false;
        });
        
    });
    
})(jQuery);
