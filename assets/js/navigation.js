/**
 * Navigation JavaScript - Mairie France Theme
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // ===== MENU TOGGLE =====
        var $menuToggle = $('.menu-toggle');
        var $mainNav = $('.main-navigation');
        
        $menuToggle.on('click', function() {
            var isOpen = $(this).attr('aria-expanded') === 'true';
            
            $(this).attr('aria-expanded', !isOpen);
            $mainNav.toggleClass('is-open');
            
            // Animation icône hamburger
            $(this).find('.menu-toggle-icon').toggleClass('is-active');
            
            // Empêcher scroll du body quand menu ouvert
            if (!isOpen) {
                $('body').addClass('menu-open');
            } else {
                $('body').removeClass('menu-open');
            }
        });
        
        // ===== SOUS-MENUS =====
        var $menuItems = $('.primary-menu .menu-item-has-children');
        
        // Click sur le toggle
        $('.submenu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $toggle = $(this);
            var $parent = $toggle.parent('.menu-item-has-children');
            var $submenu = $parent.find('> .sub-menu');
            var isExpanded = $toggle.attr('aria-expanded') === 'true';
            
            // Fermer les autres sous-menus au même niveau
            $parent.siblings('.menu-item-has-children').each(function() {
                $(this).find('> .submenu-toggle').attr('aria-expanded', 'false');
                $(this).find('> .sub-menu').slideUp(300);
                $(this).removeClass('is-open');
            });
            
            // Toggle ce sous-menu
            $toggle.attr('aria-expanded', !isExpanded);
            $submenu.slideToggle(300);
            $parent.toggleClass('is-open');
        });
        
        // ===== NAVIGATION CLAVIER =====
        $('.primary-menu a, .primary-menu button').on('keydown', function(e) {
            var $this = $(this);
            var $parent = $this.parent('li');
            
            // Flèche gauche
            if (e.keyCode === 37) {
                e.preventDefault();
                var $prevItem = $parent.prev('li');
                if ($prevItem.length) {
                    $prevItem.find('> a, > button').first().focus();
                } else {
                    $parent.parent('ul').parent('li').find('> a, > button').first().focus();
                }
            }
            
            // Flèche droite
            if (e.keyCode === 39) {
                e.preventDefault();
                var $nextItem = $parent.next('li');
                if ($nextItem.length) {
                    $nextItem.find('> a, > button').first().focus();
                } else {
                    $parent.parent('ul').find('> li').first().find('> a, > button').first().focus();
                }
            }
            
            // Flèche bas - ouvrir sous-menu
            if (e.keyCode === 40) {
                if ($parent.hasClass('menu-item-has-children')) {
                    e.preventDefault();
                    var $submenu = $parent.find('> .sub-menu');
                    var $toggle = $parent.find('> .submenu-toggle');
                    
                    if ($toggle.attr('aria-expanded') !== 'true') {
                        $toggle.click();
                    }
                    
                    $submenu.find('> li').first().find('> a, > button').first().focus();
                }
            }
            
            // Flèche haut - fermer sous-menu
            if (e.keyCode === 38) {
                e.preventDefault();
                var $parentMenu = $parent.parent('.sub-menu');
                if ($parentMenu.length) {
                    $parentMenu.parent('li').find('> a, > button').first().focus();
                }
            }
            
            // Escape - fermer sous-menu
            if (e.keyCode === 27) {
                var $submenuToggle = $parent.parent('.sub-menu').siblings('.submenu-toggle');
                if ($submenuToggle.length) {
                    $submenuToggle.attr('aria-expanded', 'false').click();
                    $submenuToggle.focus();
                }
                
                // Fermer aussi le menu mobile
                if ($mainNav.hasClass('is-open')) {
                    $menuToggle.click();
                }
            }
        });
        
        // ===== FERMER MENU EN CLIQUANT DEHORS =====
        $(document).on('click', function(e) {
            if ($mainNav.hasClass('is-open')) {
                if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
                    $menuToggle.click();
                }
            }
            
            // Fermer sous-menus
            if (!$(e.target).closest('.menu-item-has-children').length) {
                $('.submenu-toggle').attr('aria-expanded', 'false');
                $('.sub-menu').slideUp(300);
                $('.menu-item-has-children').removeClass('is-open');
            }
        });
        
        // ===== MENU STICKY =====
        var $header = $('.site-header');
        var headerOffset = $header.offset().top;
        var isSticky = false;
        
        $(window).on('scroll', function() {
            var scrollTop = $(window).scrollTop();
            
            if (scrollTop > headerOffset && !isSticky) {
                $header.addClass('is-sticky');
                isSticky = true;
            } else if (scrollTop <= headerOffset && isSticky) {
                $header.removeClass('is-sticky');
                isSticky = false;
            }
        });
        
        // ===== MEGA MENU (si utilisé) =====
        $('.menu-item.mega-menu').hover(
            function() {
                $(this).find('.mega-menu-content').stop(true, true).fadeIn(200);
            },
            function() {
                $(this).find('.mega-menu-content').stop(true, true).fadeOut(200);
            }
        );
        
        // ===== ACTIVE MENU ITEM =====
        // Marquer l'élément de menu actif selon l'URL
        var currentPath = window.location.pathname;
        $('.primary-menu a').each(function() {
            var $link = $(this);
            var linkPath = $link.attr('href');
            
            if (linkPath && (currentPath === linkPath || currentPath.indexOf(linkPath) === 0)) {
                $link.parent('li').addClass('current-menu-item');
                
                // Marquer aussi les parents
                $link.parents('.menu-item-has-children').addClass('current-menu-ancestor');
            }
        });
        
    });
    
})(jQuery);
