/**
 * @file
 * Script principal moderne pour le thème Commune.
 * 
 * Fonctionnalités principales et utilitaires communs
 */

(function (Drupal, drupalSettings, once) {
  'use strict';

  /**
   * Comportement principal du thème
   */
  Drupal.behaviors.communeTheme = {
    attach: function (context, settings) {
      // Initialisation du thème
      console.log('🏛️ Commune Theme - Version moderne initialisée');
      
      // Initialiser les animations au scroll
      initScrollAnimations(context);
      
      // Initialiser le bouton retour en haut
      initBackToTop(context);
      
      if ($menuToggle.length && $menuWrapper.length) {
        // Initialiser l'état ARIA
        $menuToggle.attr('aria-expanded', 'false');
        $menuWrapper.attr('aria-hidden', 'true');
        
        $menuToggle.on('click.commune', function(e) {
          e.preventDefault();
          
          const isOpen = $menuToggle.attr('aria-expanded') === 'true';
          const newState = !isOpen;
          
          $menuToggle.attr('aria-expanded', newState);
          $menuWrapper.attr('aria-hidden', !newState);
          $menuWrapper.toggleClass('is-open', newState);
          
          // Focus sur le premier lien lors de l'ouverture
          if (newState) {
            $menuWrapper.find('a').first().focus();
          }
        });
        
        // Fermer avec Échap
        $(document).on('keydown.commune', function(e) {
          if (e.key === 'Escape' && $menuWrapper.hasClass('is-open')) {
            $menuToggle.click().focus();
          }
        });
        
        // Fermer lors du clic en dehors
        $(document).on('click.commune', function(e) {
          if (!$(e.target).closest('.main-navigation').length && $menuWrapper.hasClass('is-open')) {
            $menuToggle.click();
          }
        });
        
        // Gérer le redimensionnement
        $(window).on('resize.commune', function() {
          if (window.innerWidth >= 992 && $menuWrapper.hasClass('is-open')) {
            $menuToggle.attr('aria-expanded', 'false');
            $menuWrapper.attr('aria-hidden', 'true').removeClass('is-open');
          }
        });
      }
    }
  };

  /**
   * Contrôles de taille de police pour l'accessibilité
   */
  Drupal.behaviors.communeFontSize = {
    attach: function (context, settings) {
      const $fontBtns = $('.font-size-btn', context);
      
      if ($fontBtns.length) {
        // Récupérer la taille sauvegardée
        const savedSize = localStorage.getItem('commune-font-size') || 'normal';
        document.body.className = document.body.className.replace(/font-size-\w+/g, '');
        
        if (savedSize !== 'normal') {
          document.body.classList.add('font-size-' + savedSize);
        }
        
        // Marquer le bouton actif
        $fontBtns.removeClass('active')
          .filter('[data-size="' + savedSize + '"]')
          .addClass('active');
        
        $fontBtns.on('click.commune', function(e) {
          e.preventDefault();
          
          const size = $(this).data('size');
          
          // Retirer les classes existantes
          document.body.className = document.body.className.replace(/font-size-\w+/g, '');
          
          // Ajouter la nouvelle classe si pas normale
          if (size !== 'normal') {
            document.body.classList.add('font-size-' + size);
          }
          
          // Sauvegarder la préférence
          localStorage.setItem('commune-font-size', size);
          
          // Marquer le bouton actif
          $fontBtns.removeClass('active');
          $(this).addClass('active');
          
          // Notifier le changement pour l'accessibilité
          const message = Drupal.t('Taille de police changée : @size', {'@size': size});
          Drupal.announce(message);
        });
      }
    }
  };

  /**
   * Mode contraste élevé
   */
  Drupal.behaviors.communeContrast = {
    attach: function (context, settings) {
      const $contrastToggle = $('.contrast-toggle', context);
      
      if ($contrastToggle.length) {
        // Récupérer l'état sauvegardé
        const highContrast = localStorage.getItem('commune-high-contrast') === 'true';
        
        if (highContrast) {
          document.body.classList.add('high-contrast');
          $contrastToggle.attr('aria-pressed', 'true');
        } else {
          $contrastToggle.attr('aria-pressed', 'false');
        }
        
        $contrastToggle.on('click.commune', function(e) {
          e.preventDefault();
          
          const isActive = document.body.classList.contains('high-contrast');
          const newState = !isActive;
          
          document.body.classList.toggle('high-contrast', newState);
          $(this).attr('aria-pressed', newState);
          
          // Sauvegarder la préférence
          localStorage.setItem('commune-high-contrast', newState);
          
          // Notifier le changement
          const message = newState 
            ? Drupal.t('Mode contraste élevé activé')
            : Drupal.t('Mode contraste élevé désactivé');
          Drupal.announce(message);
        });
      }
    }
  };

  /**
   * Amélioration des liens externes pour l'accessibilité
   */
  Drupal.behaviors.communeExternalLinks = {
    attach: function (context, settings) {
      $('a[href^="http"]:not([href*="' + location.hostname + '"])', context)
        .once('commune-external')
        .each(function() {
          const $link = $(this);
          
          // Ajouter les attributs de sécurité
          $link.attr({
            'target': '_blank',
            'rel': 'noopener noreferrer'
          });
          
          // Ajouter une indication visuelle et textuelle
          if (!$link.find('.external-indicator').length) {
            const indicator = '<span class="external-indicator" aria-hidden="true">↗</span>';
            const srText = '<span class="visually-hidden"> (' + Drupal.t('ouvre dans un nouvel onglet') + ')</span>';
            $link.append(indicator + srText);
          }
        });
    }
  };

  /**
   * Amélioration des tables pour la responsivité et l'accessibilité
   */
  Drupal.behaviors.communeTables = {
    attach: function (context, settings) {
      $('table', context)
        .once('commune-table')
        .each(function() {
          const $table = $(this);
          
          // Ajouter un wrapper responsive si pas présent
          if (!$table.parent('.table-responsive').length) {
            $table.wrap('<div class="table-responsive" role="region" tabindex="0" aria-label="' + Drupal.t('Tableau scrollable') + '"></div>');
          }
          
          // Améliorer l'accessibilité avec des descriptions
          if (!$table.attr('summary') && !$table.find('caption').length) {
            const headers = $table.find('th').length;
            const rows = $table.find('tr').length - 1; // Exclure l'en-tête
            
            if (headers > 0 && rows > 0) {
              const caption = $('<caption class="visually-hidden">')
                .text(Drupal.t('Tableau avec @headers colonnes et @rows lignes', {
                  '@headers': headers,
                  '@rows': rows
                }));
              $table.prepend(caption);
            }
          }
        });
    }
  };

  /**
   * Lazy loading des images pour les performances
   */
  Drupal.behaviors.communeLazyImages = {
    attach: function (context, settings) {
      // Utiliser l'API Intersection Observer si disponible
      if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              const img = entry.target;
              
              if (img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                img.classList.remove('lazy');
                observer.unobserve(img);
              }
            }
          });
        });
        
        $('img[data-src]', context)
          .once('commune-lazy')
          .each(function() {
            imageObserver.observe(this);
          });
      } else {
        // Fallback pour les navigateurs sans support
        $('img[data-src]', context)
          .once('commune-lazy')
          .each(function() {
            const $img = $(this);
            $img.attr('src', $img.data('src')).removeAttr('data-src');
          });
      }
    }
  };

  /**
   * Gestion du focus au retour en arrière
   */
  Drupal.behaviors.communeFocusManagement = {
    attach: function (context, settings) {
      // Sauvegarder l'élément qui avait le focus avant navigation
      $(document).on('click', 'a[href^="/"]:not([href^="//"]):not([target="_blank"])', function() {
        sessionStorage.setItem('commune-focus-element', this.href);
      });
      
      // Restaurer le focus lors du retour
      $(document).ready(function() {
        const referrer = document.referrer;
        const currentUrl = window.location.href;
        const savedFocus = sessionStorage.getItem('commune-focus-element');
        
        if (referrer && savedFocus === currentUrl) {
          // Focus sur le contenu principal lors du retour
          const $mainContent = $('#main-content');
          if ($mainContent.length) {
            $mainContent.attr('tabindex', '-1').focus();
          }
          sessionStorage.removeItem('commune-focus-element');
        }
      });
    }
  };

  /**
   * Annonces ARIA pour les changements dynamiques
   */
  Drupal.announce = Drupal.announce || function(message, priority) {
    priority = priority || 'polite';
    
    const $announcer = $('#commune-announcer');
    let $element;
    
    if ($announcer.length) {
      $element = $announcer;
    } else {
      $element = $('<div id="commune-announcer" aria-live="polite" aria-atomic="true" class="visually-hidden"></div>')
        .appendTo('body');
    }
    
    $element.attr('aria-live', priority).text(message);
    
    // Nettoyer après annonce
    setTimeout(function() {
      $element.empty();
    }, 1000);
  };

  /**
   * Smooth scroll pour les ancres avec gestion de l'accessibilité
   */
  Drupal.behaviors.communeSmoothScroll = {
    attach: function (context, settings) {
      $('a[href^="#"]', context)
        .once('commune-smooth')
        .on('click', function(e) {
          const href = $(this).attr('href');
          const $target = $(href);
          
          if ($target.length && href !== '#') {
            e.preventDefault();
            
            // Respecter les préférences de mouvement réduit
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const duration = prefersReduced ? 0 : 500;
            
            $('html, body').animate({
              scrollTop: $target.offset().top - 20
            }, duration, function() {
              // Gérer le focus pour l'accessibilité
              $target.attr('tabindex', '-1').focus();
              
              // Annoncer la navigation
              const targetText = $target.find('h1, h2, h3, h4, h5, h6').first().text() 
                || $target.text().substring(0, 50) + '...';
              
              if (targetText) {
                Drupal.announce(Drupal.t('Navigation vers : @target', {'@target': targetText}));
              }
            });
          }
        });
    }
  };

  /**
   * Détection des préférences utilisateur système
   */
  Drupal.behaviors.communeSystemPreferences = {
    attach: function (context, settings) {
      // Appliquer automatiquement le mode sombre si préféré par l'utilisateur
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        // Option pour un futur mode sombre
        document.body.classList.add('prefers-dark');
      }
      
      // Écouter les changements de préférences
      if (window.matchMedia) {
        const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
        darkModeQuery.addListener(function(e) {
          document.body.classList.toggle('prefers-dark', e.matches);
        });
        
        const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
        reducedMotionQuery.addListener(function(e) {
          document.body.classList.toggle('prefers-reduced-motion', e.matches);
        });
      }
    }
  };

  /**
   * Nettoyage des event listeners lors du détachement
   */
  $(document).on('drupalViewportOffsetChange', function() {
    // Nettoyer les event listeners globaux si nécessaire
    $(document).off('.commune');
    $(window).off('.commune');
  });

})(jQuery, Drupal, drupalSettings);