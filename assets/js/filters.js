/**
 * Filters JavaScript - Mairie France Theme
 * Gestion des filtres AJAX pour numéros utiles, événements, etc.
 * 
 * @package Mairie_France
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // ===== FILTRES NUMÉROS UTILES =====
        
        // Recherche
        $('#numeros-search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            filterNumeros(searchTerm, $('#numeros-filter').val());
        });
        
        // Filtre par catégorie
        $('#numeros-filter').on('change', function() {
            var category = $(this).val();
            filterNumeros($('#numeros-search').val().toLowerCase(), category);
        });
        
        function filterNumeros(searchTerm, category) {
            $('.numero-item').each(function() {
                var $item = $(this);
                var title = $item.find('.numero-title').text().toLowerCase();
                var content = $item.text().toLowerCase();
                var itemCategory = $item.data('category');
                
                var matchesSearch = !searchTerm || content.indexOf(searchTerm) > -1;
                var matchesCategory = !category || category === 'all' || itemCategory === category;
                
                if (matchesSearch && matchesCategory) {
                    $item.fadeIn(300);
                } else {
                    $item.fadeOut(300);
                }
            });
            
            updateResultsCount();
        }
        
        function updateResultsCount() {
            var visible = $('.numero-item:visible').length;
            var total = $('.numero-item').length;
            
            $('#results-count').text(visible + ' résultat' + (visible > 1 ? 's' : '') + ' sur ' + total);
        }
        
        // ===== FILTRES ÉVÉNEMENTS =====
        
        $('#events-filter').on('change', function() {
            var category = $(this).val();
            
            $('.event-card').each(function() {
                var $card = $(this);
                var cardCategory = $card.data('category');
                
                if (!category || category === 'all' || cardCategory === category) {
                    $card.fadeIn(300);
                } else {
                    $card.fadeOut(300);
                }
            });
        });
        
        // Filtre par date
        $('#events-date-filter').on('change', function() {
            var filter = $(this).val();
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            
            $('.event-card').each(function() {
                var $card = $(this);
                var eventDate = new Date($card.data('date'));
                var show = false;
                
                switch(filter) {
                    case 'upcoming':
                        show = eventDate >= today;
                        break;
                    case 'past':
                        show = eventDate < today;
                        break;
                    case 'this-month':
                        var thisMonth = today.getMonth();
                        var thisYear = today.getFullYear();
                        show = eventDate.getMonth() === thisMonth && eventDate.getFullYear() === thisYear;
                        break;
                    default:
                        show = true;
                }
                
                if (show) {
                    $card.fadeIn(300);
                } else {
                    $card.fadeOut(300);
                }
            });
        });
        
        // ===== FILTRES ASSOCIATIONS =====
        
        $('#associations-search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            
            $('.association-card').each(function() {
                var $card = $(this);
                var content = $card.text().toLowerCase();
                
                if (!searchTerm || content.indexOf(searchTerm) > -1) {
                    $card.fadeIn(300);
                } else {
                    $card.fadeOut(300);
                }
            });
        });
        
        $('#associations-category-filter').on('change', function() {
            var category = $(this).val();
            
            $('.association-card').each(function() {
                var $card = $(this);
                var cardCategory = $card.data('category');
                
                if (!category || category === 'all' || cardCategory === category) {
                    $card.fadeIn(300);
                } else {
                    $card.fadeOut(300);
                }
            });
        });
        
        // ===== FILTRES ACTUALITÉS =====
        
        $('#news-filter').on('change', function() {
            var category = $(this).val();
            
            if (!category || category === 'all') {
                $('.article-card').fadeIn(300);
                return;
            }
            
            // Charger via AJAX
            $.ajax({
                url: mairieAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'filter_news',
                    category: category,
                    nonce: mairieAjax.nonce
                },
                beforeSend: function() {
                    $('.articles-grid').addClass('loading');
                },
                success: function(response) {
                    if (response.success) {
                        $('.articles-grid').html(response.data.html);
                    }
                },
                complete: function() {
                    $('.articles-grid').removeClass('loading');
                }
            });
        });
        
        // ===== PAGINATION AJAX =====
        
        $(document).on('click', '.load-more', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var page = parseInt($button.data('page')) || 1;
            var postType = $button.data('post-type') || 'post';
            var category = $button.data('category') || '';
            
            $.ajax({
                url: mairieAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    post_type: postType,
                    category: category,
                    page: page + 1,
                    nonce: mairieAjax.nonce
                },
                beforeSend: function() {
                    $button.addClass('loading').text('Chargement...');
                },
                success: function(response) {
                    if (response.success) {
                        $('.articles-grid, .events-grid').append(response.data.html);
                        $button.data('page', page + 1);
                        
                        if (!response.data.has_more) {
                            $button.fadeOut();
                        }
                    }
                },
                complete: function() {
                    $button.removeClass('loading').text('Charger plus');
                }
            });
        });
        
        // ===== TRI =====
        
        $('.sort-select').on('change', function() {
            var sortBy = $(this).val();
            var $container = $(this).data('container') || '.articles-grid';
            var $items = $($container).children();
            
            $items.sort(function(a, b) {
                var aVal, bVal;
                
                switch(sortBy) {
                    case 'date-asc':
                        aVal = new Date($(a).data('date'));
                        bVal = new Date($(b).data('date'));
                        return aVal - bVal;
                        
                    case 'date-desc':
                        aVal = new Date($(a).data('date'));
                        bVal = new Date($(b).data('date'));
                        return bVal - aVal;
                        
                    case 'title-asc':
                        aVal = $(a).find('.title, h2, h3').first().text();
                        bVal = $(b).find('.title, h2, h3').first().text();
                        return aVal.localeCompare(bVal);
                        
                    case 'title-desc':
                        aVal = $(a).find('.title, h2, h3').first().text();
                        bVal = $(b).find('.title, h2, h3').first().text();
                        return bVal.localeCompare(aVal);
                        
                    default:
                        return 0;
                }
            });
            
            $($container).html($items);
        });
        
        // ===== RESET FILTRES =====
        
        $('.reset-filters').on('click', function(e) {
            e.preventDefault();
            
            // Reset tous les champs
            $('input[type="search"], input[type="text"]').val('');
            $('select').prop('selectedIndex', 0);
            
            // Afficher tous les éléments
            $('.article-card, .event-card, .association-card, .numero-item').fadeIn(300);
            
            updateResultsCount();
        });
        
        // ===== FAVORIS (localStorage) =====
        
        $('.favorite-toggle').on('click', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var itemId = $button.data('id');
            var favorites = JSON.parse(localStorage.getItem('mairie_favorites') || '[]');
            
            if (favorites.includes(itemId)) {
                // Retirer des favoris
                favorites = favorites.filter(function(id) { return id !== itemId; });
                $button.removeClass('is-favorite');
            } else {
                // Ajouter aux favoris
                favorites.push(itemId);
                $button.addClass('is-favorite');
            }
            
            localStorage.setItem('mairie_favorites', JSON.stringify(favorites));
        });
        
        // Marquer les favoris au chargement
        var favorites = JSON.parse(localStorage.getItem('mairie_favorites') || '[]');
        favorites.forEach(function(itemId) {
            $('.favorite-toggle[data-id="' + itemId + '"]').addClass('is-favorite');
        });
        
    });
    
})(jQuery);
