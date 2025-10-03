/**
 * Navigation JavaScript - Mairie France Theme
 * Gestion du menu mobile et de la navigation avec Tailwind CSS
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // ===== MENU TOGGLE MOBILE =====
        var $menuToggle = $('.menu-toggle');
        var $mainNav = $('.main-navigation');
        var $body = $('body');
        
        $menuToggle.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var isOpen = $(this).attr('aria-expanded') === 'true';
            
            // Toggle état
            $(this).attr('aria-expanded', !isOpen);
            $(this).toggleClass('is-active');
            $mainNav.toggleClass('is-open');
            
            // Empêcher scroll du body quand menu ouvert
            if (!isOpen) {
                $body.addClass('overflow-hidden lg:overflow-auto');
            } else {
                $body.removeClass('overflow-hidden');
            }
        });
        
        // ===== SOUS-MENUS MOBILE =====
        $('.submenu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $toggle = $(this);
            var $parent = $toggle.closest('.menu-item-has-children');
            var $submenu = $parent.find('> .sub-menu');
            var isExpanded = $toggle.attr('aria-expanded') === 'true';
            
            // Toggle ce sous-menu
            $toggle.attr('aria-expanded', !isExpanded);
            $toggle.find('i').toggleClass('rotate-180');
            $submenu.toggleClass('hidden');
            $submenu.slideToggle(300);
        });
        
        // ===== FERMER MENU EN CLIQUANT DEHORS =====
        $(document).on('click touchstart', function(e) {
            if ($mainNav.hasClass('is-open')) {
                if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
                    $menuToggle.click();
                }
            }
        });
        
        // ===== FERMER MENU AVEC ESCAPE =====
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $mainNav.hasClass('is-open')) { // Escape
                $menuToggle.click();
                $menuToggle.focus();
            }
        });
        
        // ===== NAVIGATION CLAVIER (flèches) =====
        $('.primary-menu a, .submenu-toggle').on('keydown', function(e) {
            var $this = $(this);
            var $parent = $this.parent('li');
            
            // Flèche bas - naviguer vers l'élément suivant
            if (e.keyCode === 40) {
                e.preventDefault();
                var $next = $parent.next('li').find('> a, > .submenu-toggle').first();
                if ($next.length) {
                    $next.focus();
                }
            }
            
            // Flèche haut - naviguer vers l'élément précédent
            if (e.keyCode === 38) {
                e.preventDefault();
                var $prev = $parent.prev('li').find('> a, > .submenu-toggle').first();
                if ($prev.length) {
                    $prev.focus();
                } else {
                    // Remonter au parent
                    var $parentMenu = $parent.closest('.sub-menu');
                    if ($parentMenu.length) {
                        $parentMenu.siblings('a').focus();
                    }
                }
            }
        });
        
        // ===== FERMER SOUS-MENUS QUAND ON QUITTE LE GROUPE =====
        $('.menu-item-has-children').on('mouseleave', function() {
            if ($(window).width() >= 1024) { // Desktop uniquement
                var $submenu = $(this).find('> .sub-menu');
                $submenu.removeClass('block').addClass('hidden');
            }
        });
        
        // ===== RESPONSIVE : RÉINITIALISER AU REDIMENSIONNEMENT =====
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if ($(window).width() >= 1024) {
                    // Mode desktop : fermer le menu mobile si ouvert
                    if ($mainNav.hasClass('is-open')) {
                        $menuToggle.attr('aria-expanded', 'false');
                        $menuToggle.removeClass('is-active');
                        $mainNav.removeClass('is-open');
                        $body.removeClass('overflow-hidden');
                    }
                    
                    // Fermer tous les sous-menus mobiles
                    $('.sub-menu').removeClass('hidden');
                    $('.submenu-toggle').attr('aria-expanded', 'false');
                    $('.submenu-toggle i').removeClass('rotate-180');
                }
            }, 250);
        });
        
    });
    
})(jQuery);
