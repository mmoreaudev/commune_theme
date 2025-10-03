/**
 * Customizer JavaScript - Mairie France Theme
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    // ===== PREVIEW EN TEMPS RÉEL =====
    
    // Nom de la commune
    wp.customize('commune_name', function(value) {
        value.bind(function(newval) {
            $('.site-title').text(newval);
        });
    });
    
    // Slogan
    wp.customize('commune_slogan', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });
    
    // Adresse
    wp.customize('contact_address', function(value) {
        value.bind(function(newval) {
            $('.footer-address').html(newval.replace(/\n/g, '<br>'));
        });
    });
    
    // Téléphone
    wp.customize('contact_phone', function(value) {
        value.bind(function(newval) {
            $('.footer-phone a').text(newval).attr('href', 'tel:' + newval.replace(/\s/g, ''));
        });
    });
    
    // Email
    wp.customize('contact_email', function(value) {
        value.bind(function(newval) {
            $('.footer-email a').text(newval).attr('href', 'mailto:' + newval);
        });
    });
    
    // Horaires
    wp.customize('contact_hours', function(value) {
        value.bind(function(newval) {
            $('.footer-hours').html(newval.replace(/\n/g, '<br>'));
        });
    });
    
    // ===== COULEURS =====
    
    // Couleur primaire
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            $('head').find('#mairie-primary-color').remove();
            $('head').append('<style id="mairie-primary-color">' +
                ':root { --color-primary: ' + newval + '; }' +
                '</style>');
        });
    });
    
    // Couleur secondaire
    wp.customize('secondary_color', function(value) {
        value.bind(function(newval) {
            $('head').find('#mairie-secondary-color').remove();
            $('head').append('<style id="mairie-secondary-color">' +
                ':root { --color-secondary: ' + newval + '; }' +
                '</style>');
        });
    });
    
    // Couleur des liens
    wp.customize('link_color', function(value) {
        value.bind(function(newval) {
            $('head').find('#mairie-link-color').remove();
            $('head').append('<style id="mairie-link-color">' +
                ':root { --color-link: ' + newval + '; }' +
                'a { color: ' + newval + '; }' +
                '</style>');
        });
    });
    
    // Couleur du footer
    wp.customize('footer_bg_color', function(value) {
        value.bind(function(newval) {
            $('.site-footer').css('background-color', newval);
        });
    });
    
    // ===== PAGE D'ACCUEIL =====
    
    // Titre hero
    wp.customize('hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero-title').text(newval);
        });
    });
    
    // Texte hero
    wp.customize('hero_text', function(value) {
        value.bind(function(newval) {
            $('.hero-description').text(newval);
        });
    });
    
    // Texte bouton CTA
    wp.customize('hero_button_text', function(value) {
        value.bind(function(newval) {
            $('.hero-cta').text(newval);
        });
    });
    
    // Lien bouton CTA
    wp.customize('hero_button_link', function(value) {
        value.bind(function(newval) {
            $('.hero-cta').attr('href', newval);
        });
    });
    
    // Image hero
    wp.customize('hero_image', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.hero-section').css('background-image', 'url(' + newval + ')');
            } else {
                $('.hero-section').css('background-image', 'none');
            }
        });
    });
    
    // ===== FOOTER =====
    
    // Texte copyright
    wp.customize('footer_copyright', function(value) {
        value.bind(function(newval) {
            $('.footer-copyright p').html(newval);
        });
    });
    
    // ===== RÉSEAUX SOCIAUX =====
    
    var socialNetworks = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'];
    
    socialNetworks.forEach(function(network) {
        wp.customize('social_' + network, function(value) {
            value.bind(function(newval) {
                var $link = $('.social-links a[href*="' + network + '"]');
                
                if (newval) {
                    if ($link.length) {
                        $link.attr('href', newval);
                    } else {
                        $('.social-links').append(
                            '<a href="' + newval + '" target="_blank" rel="noopener noreferrer" aria-label="' + 
                            network.charAt(0).toUpperCase() + network.slice(1) + '">' +
                            '<i class="fab fa-' + network + '"></i></a>'
                        );
                    }
                } else {
                    $link.remove();
                }
            });
        });
    });
    
    // ===== CONTRÔLES PERSONNALISÉS =====
    
    // Toggle pour afficher/masquer des sections
    $('.customize-control-checkbox input[type="checkbox"]').on('change', function() {
        var controlId = $(this).attr('id');
        var isChecked = $(this).is(':checked');
        var relatedControls = $('[data-depends-on="' + controlId + '"]');
        
        if (isChecked) {
            relatedControls.slideDown(300);
        } else {
            relatedControls.slideUp(300);
        }
    }).trigger('change');
    
    // ===== VALIDATION =====
    
    // Validation email
    $('input[type="email"]').on('blur', function() {
        var $input = $(this);
        var value = $input.val();
        
        if (value && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            $input.addClass('invalid');
            $input.siblings('.description').text('Format d\'email invalide');
        } else {
            $input.removeClass('invalid');
            $input.siblings('.description').text('');
        }
    });
    
    // Validation URL
    $('input[type="url"]').on('blur', function() {
        var $input = $(this);
        var value = $input.val();
        
        if (value && !value.match(/^https?:\/\/.+/)) {
            $input.addClass('invalid');
            $input.siblings('.description').text('L\'URL doit commencer par http:// ou https://');
        } else {
            $input.removeClass('invalid');
            $input.siblings('.description').text('');
        }
    });
    
    // ===== MESSAGES D'AIDE =====
    
    // Afficher des conseils selon les valeurs
    wp.customize.bind('ready', function() {
        
        // Conseil pour les couleurs
        wp.customize('primary_color', function(value) {
            value.bind(function(newval) {
                // Vérifier le contraste
                var rgb = hexToRgb(newval);
                var luminance = (0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b) / 255;
                
                if (luminance < 0.5) {
                    wp.customize.notifications.add('primary_color_contrast', new wp.customize.Notification(
                        'primary_color_contrast',
                        {
                            type: 'warning',
                            message: 'Attention : cette couleur peut poser des problèmes de contraste pour l\'accessibilité.'
                        }
                    ));
                } else {
                    wp.customize.notifications.remove('primary_color_contrast');
                }
            });
        });
        
    });
    
    // ===== FONCTIONS UTILITAIRES =====
    
    function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }
    
})(jQuery);
