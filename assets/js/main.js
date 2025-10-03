/**
 * Main JavaScript - Mairie France Theme
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    // Au chargement du DOM
    $(document).ready(function() {
        
        // ===== MENU MOBILE =====
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('is-active');
            $('.main-navigation').toggleClass('is-open');
            $(this).attr('aria-expanded', $('.main-navigation').hasClass('is-open'));
        });
        
        // ===== SOUS-MENUS =====
        $('.submenu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $toggle = $(this);
            var $submenu = $toggle.siblings('.sub-menu');
            var isExpanded = $toggle.attr('aria-expanded') === 'true';
            
            // Fermer les autres sous-menus
            $('.submenu-toggle').not($toggle).attr('aria-expanded', 'false');
            $('.sub-menu').not($submenu).slideUp(300);
            
            // Toggle ce sous-menu
            $toggle.attr('aria-expanded', !isExpanded);
            $submenu.slideToggle(300);
        });
        
        // ===== RECHERCHE HEADER =====
        $('.search-toggle').on('click', function() {
            $(this).toggleClass('is-active');
            $('.search-form-wrapper').toggleClass('is-open');
            $(this).attr('aria-expanded', $('.search-form-wrapper').hasClass('is-open'));
            
            if ($('.search-form-wrapper').hasClass('is-open')) {
                $('.search-form-wrapper input[type="search"]').focus();
            }
        });
        
        // ===== BOUTON RETOUR EN HAUT =====
        var $backToTop = $('#back-to-top');
        
        if ($backToTop.length) {
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    $backToTop.addClass('is-visible');
                } else {
                    $backToTop.removeClass('is-visible');
                }
            });
            
            $backToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({scrollTop: 0}, 600);
                // Remettre le focus sur le skip link pour accessibilité
                $('.skip-link').focus();
            });
        }
        
        // ===== ACCORDÉONS =====
        $('.accordion-button').on('click', function() {
            var $button = $(this);
            var $item = $button.closest('.accordion-item');
            var $collapse = $button.next('.accordion-collapse');
            var isExpanded = $button.attr('aria-expanded') === 'true';
            
            // Option : fermer les autres accordéons (comportement exclusif)
            // Commentez ces lignes pour permettre plusieurs accordéons ouverts
            $('.accordion-button').not($button).attr('aria-expanded', 'false');
            $('.accordion-collapse').not($collapse).removeClass('show').slideUp(300);
            
            // Toggle cet accordéon
            $button.attr('aria-expanded', !isExpanded);
            $collapse.toggleClass('show').slideToggle(300);
        });
        
        // ===== ONGLETS =====
        $('.tab-button').on('click', function() {
            var $button = $(this);
            var tab = $button.data('tab');
            var $container = $button.closest('.tabs-navigation');
            
            // Mettre à jour les boutons
            $container.find('.tab-button').removeClass('active').attr('aria-selected', 'false');
            $button.addClass('active').attr('aria-selected', 'true');
            
            // Mettre à jour les panneaux
            $('.tab-pane').removeClass('active').attr('hidden', true);
            $('#tab-' + tab).addClass('active').removeAttr('hidden');
        });
        
        // Support clavier pour les onglets
        $('.tab-button').on('keydown', function(e) {
            var $button = $(this);
            var $buttons = $('.tab-button');
            var index = $buttons.index($button);
            
            // Flèche gauche/haut
            if (e.keyCode === 37 || e.keyCode === 38) {
                e.preventDefault();
                var $prev = $buttons.eq(index - 1).length ? $buttons.eq(index - 1) : $buttons.last();
                $prev.focus().click();
            }
            
            // Flèche droite/bas
            if (e.keyCode === 39 || e.keyCode === 40) {
                e.preventDefault();
                var $next = $buttons.eq(index + 1).length ? $buttons.eq(index + 1) : $buttons.first();
                $next.focus().click();
            }
            
            // Home
            if (e.keyCode === 36) {
                e.preventDefault();
                $buttons.first().focus().click();
            }
            
            // End
            if (e.keyCode === 35) {
                e.preventDefault();
                $buttons.last().focus().click();
            }
        });
        
        // ===== LAZY LOADING IMAGES =====
        if ('loading' in HTMLImageElement.prototype) {
            // Le navigateur supporte lazy loading natif
            var images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(function(img) {
                img.src = img.dataset.src || img.src;
            });
        } else {
            // Fallback pour navigateurs plus anciens
            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
            document.body.appendChild(script);
        }
        
        // ===== SMOOTH SCROLL POUR ANCRES =====
        $('a[href^="#"]:not([href="#"])').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 600, function() {
                    // Mettre le focus sur la cible pour accessibilité
                    target.attr('tabindex', '-1').focus();
                });
            }
        });
        
        // ===== MODALES =====
        $('.modal-trigger').on('click', function(e) {
            e.preventDefault();
            var modalId = $(this).data('modal');
            var $modal = $('#' + modalId);
            
            if ($modal.length) {
                $modal.addClass('is-open');
                $modal.attr('aria-hidden', 'false');
                
                // Piéger le focus dans la modale
                trapFocus($modal[0]);
                
                // Focus sur le premier élément focusable
                $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').first().focus();
            }
        });
        
        $('.modal-close, .modal-overlay').on('click', function(e) {
            e.preventDefault();
            var $modal = $(this).closest('.modal');
            closeModal($modal);
        });
        
        // Fermer modale avec Escape
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // Escape
                $('.modal.is-open').each(function() {
                    closeModal($(this));
                });
            }
        });
        
        function closeModal($modal) {
            $modal.removeClass('is-open');
            $modal.attr('aria-hidden', 'true');
            
            // Retourner le focus à l'élément déclencheur
            var triggerElement = $modal.data('trigger');
            if (triggerElement) {
                $(triggerElement).focus();
            }
        }
        
        function trapFocus(element) {
            var focusableElements = element.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            var firstFocusable = focusableElements[0];
            var lastFocusable = focusableElements[focusableElements.length - 1];
            
            element.addEventListener('keydown', function(e) {
                var isTabPressed = e.key === 'Tab';
                
                if (!isTabPressed) return;
                
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        lastFocusable.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        firstFocusable.focus();
                        e.preventDefault();
                    }
                }
            });
        }
        
        // ===== NOTIFICATIONS AUTO-DISMISS =====
        $('.notification.auto-dismiss').each(function() {
            var $notification = $(this);
            setTimeout(function() {
                $notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        });
        
        $('.notification-close').on('click', function() {
            $(this).closest('.notification').fadeOut(300, function() {
                $(this).remove();
            });
        });
        
        // ===== TOOLTIPS =====
        $('[data-tooltip]').each(function() {
            var $element = $(this);
            var tooltipText = $element.data('tooltip');
            
            $element.on('mouseenter focus', function() {
                var $tooltip = $('<div class="tooltip" role="tooltip">' + tooltipText + '</div>');
                $('body').append($tooltip);
                
                var offset = $element.offset();
                $tooltip.css({
                    top: offset.top - $tooltip.outerHeight() - 10,
                    left: offset.left + ($element.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
                });
                
                $tooltip.fadeIn(200);
            });
            
            $element.on('mouseleave blur', function() {
                $('.tooltip').fadeOut(200, function() {
                    $(this).remove();
                });
            });
        });
        
        // ===== ANIMATIONS AU SCROLL =====
        if ('IntersectionObserver' in window) {
            var observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.animate-on-scroll').forEach(function(element) {
                observer.observe(element);
            });
        }
        
    });
    
})(jQuery);
