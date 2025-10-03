/**
 * Header JavaScript - Fonctionnalités modernes pour l'en-tête
 */

(function (Drupal, drupalSettings, once) {
  'use strict';

  /**
   * Gestion du menu mobile
   */
  Drupal.behaviors.headerMobileMenu = {
    attach: function (context, settings) {
      once('mobile-menu', '.mobile-menu-toggle', context).forEach(function (toggle) {
        const nav = document.querySelector('.main-navigation');
        const overlay = document.querySelector('.mobile-overlay');
        
        toggle.addEventListener('click', function () {
          const isExpanded = this.getAttribute('aria-expanded') === 'true';
          
          // Toggle état
          this.setAttribute('aria-expanded', !isExpanded);
          nav.classList.toggle('active');
          overlay.classList.toggle('active');
          
          // Empêcher le scroll du body
          document.body.style.overflow = !isExpanded ? 'hidden' : '';
          
          // Focus management
          if (!isExpanded) {
            // Focus sur le premier lien du menu
            const firstLink = nav.querySelector('a');
            if (firstLink) {
              setTimeout(() => firstLink.focus(), 100);
            }
          }
        });
        
        // Fermer avec Échap
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape' && nav.classList.contains('active')) {
            toggle.click();
            toggle.focus();
          }
        });
        
        // Fermer en cliquant sur l'overlay
        if (overlay) {
          overlay.addEventListener('click', function () {
            if (nav.classList.contains('active')) {
              toggle.click();
            }
          });
        }
      });
    }
  };

  /**
   * Gestion des sous-menus mobiles
   */
  Drupal.behaviors.mobileSubmenus = {
    attach: function (context, settings) {
      once('mobile-submenu', '.main-navigation .menu-item--expanded > a', context).forEach(function (link) {
        const parent = link.parentElement;
        const submenu = parent.querySelector('ul');
        
        if (submenu) {
          parent.classList.add('has-children');
          
          link.addEventListener('click', function (e) {
            e.preventDefault();
            
            const isOpen = parent.classList.contains('open');
            
            // Fermer les autres sous-menus
            document.querySelectorAll('.main-navigation .has-children.open').forEach(function (item) {
              if (item !== parent) {
                item.classList.remove('open');
              }
            });
            
            // Toggle ce sous-menu
            parent.classList.toggle('open');
            
            // Mettre à jour l'accessibilité
            this.setAttribute('aria-expanded', parent.classList.contains('open'));
          });
        }
      });
    }
  };

  /**
   * Outils d'accessibilité - Taille de police
   */
  Drupal.behaviors.fontSizeControls = {
    attach: function (context, settings) {
      once('font-controls', '.font-size-controls', context).forEach(function (controls) {
        const buttons = controls.querySelectorAll('.font-btn');
        
        // Charger la taille sauvegardée
        const savedSize = localStorage.getItem('font-size') || 'normal';
        document.body.className = document.body.className.replace(/font-size-\w+/g, '');
        if (savedSize !== 'normal') {
          document.body.classList.add('font-size-' + savedSize);
        }
        
        // Mettre à jour les boutons
        buttons.forEach(btn => btn.classList.remove('active'));
        const activeBtn = controls.querySelector(`[data-size="${savedSize}"]`);
        if (activeBtn) activeBtn.classList.add('active');
        
        buttons.forEach(function (button) {
          button.addEventListener('click', function () {
            const size = this.dataset.size;
            
            // Supprimer les classes précédentes
            document.body.className = document.body.className.replace(/font-size-\w+/g, '');
            
            // Ajouter la nouvelle classe
            if (size !== 'normal') {
              document.body.classList.add('font-size-' + size);
            }
            
            // Sauvegarder la préférence
            localStorage.setItem('font-size', size);
            
            // Mettre à jour l'état des boutons
            buttons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Feedback accessible
            this.focus();
            announceToScreenReader('Taille de police changée : ' + size);
          });
        });
      });
    }
  };

  /**
   * Toggle contraste élevé
   */
  Drupal.behaviors.contrastToggle = {
    attach: function (context, settings) {
      once('contrast-toggle', '.contrast-toggle', context).forEach(function (toggle) {
        // Charger l'état sauvegardé
        const highContrast = localStorage.getItem('high-contrast') === 'true';
        if (highContrast) {
          document.body.classList.add('high-contrast');
          toggle.setAttribute('aria-pressed', 'true');
        }
        
        toggle.addEventListener('click', function () {
          const isActive = document.body.classList.contains('high-contrast');
          
          document.body.classList.toggle('high-contrast');
          this.setAttribute('aria-pressed', !isActive);
          
          // Sauvegarder la préférence
          localStorage.setItem('high-contrast', !isActive);
          
          // Feedback accessible
          announceToScreenReader(
            !isActive ? 'Contraste élevé activé' : 'Contraste élevé désactivé'
          );
        });
      });
    }
  };

  /**
   * Widget de recherche
   */
  Drupal.behaviors.searchWidget = {
    attach: function (context, settings) {
      once('search-toggle', '.search-toggle', context).forEach(function (toggle) {
        let searchForm = document.querySelector('.mobile-search');
        
        // Créer le formulaire de recherche s'il n'existe pas
        if (!searchForm) {
          searchForm = createMobileSearchForm();
          document.body.appendChild(searchForm);
        }
        
        toggle.addEventListener('click', function () {
          const isActive = searchForm.classList.contains('active');
          
          searchForm.classList.toggle('active');
          
          if (!isActive) {
            const input = searchForm.querySelector('input[type="search"]');
            if (input) {
              setTimeout(() => input.focus(), 100);
            }
          }
        });
        
        // Fermer avec Échap
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape' && searchForm.classList.contains('active')) {
            searchForm.classList.remove('active');
            toggle.focus();
          }
        });
      });
    }
  };

  /**
   * Créer le formulaire de recherche mobile
   */
  function createMobileSearchForm() {
    const form = document.createElement('div');
    form.className = 'mobile-search';
    form.innerHTML = `
      <form class="mobile-search-form" action="/search" method="get">
        <input type="search" name="search" placeholder="Rechercher..." required>
        <button type="submit" class="mobile-search-submit" aria-label="Lancer la recherche">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/>
          </svg>
        </button>
        <button type="button" class="mobile-search-close" aria-label="Fermer la recherche">
          ×
        </button>
      </form>
    `;
    
    // Ajouter l'événement de fermeture
    form.querySelector('.mobile-search-close').addEventListener('click', function () {
      form.classList.remove('active');
    });
    
    return form;
  }

  /**
   * Sticky header
   */
  Drupal.behaviors.stickyHeader = {
    attach: function (context, settings) {
      once('sticky-header', '.site-header', context).forEach(function (header) {
        let lastScrollY = window.scrollY;
        let ticking = false;
        
        function updateHeader() {
          const scrollY = window.scrollY;
          
          if (scrollY > 100) {
            header.classList.add('scrolled');
          } else {
            header.classList.remove('scrolled');
          }
          
          // Auto-hide sur mobile
          if (window.innerWidth <= 768) {
            if (scrollY > lastScrollY && scrollY > 200) {
              header.classList.add('hidden');
            } else {
              header.classList.remove('hidden');
            }
          }
          
          lastScrollY = scrollY;
          ticking = false;
        }
        
        function requestTick() {
          if (!ticking) {
            requestAnimationFrame(updateHeader);
            ticking = true;
          }
        }
        
        window.addEventListener('scroll', requestTick, { passive: true });
        
        // Reset on resize
        window.addEventListener('resize', function () {
          header.classList.remove('hidden');
        });
      });
    }
  };

  /**
   * Utilitaire pour les annonces aux lecteurs d'écran
   */
  function announceToScreenReader(message) {
    let announcer = document.getElementById('screen-reader-announcer');
    
    if (!announcer) {
      announcer = document.createElement('div');
      announcer.id = 'screen-reader-announcer';
      announcer.setAttribute('aria-live', 'polite');
      announcer.setAttribute('aria-atomic', 'true');
      announcer.className = 'visually-hidden';
      document.body.appendChild(announcer);
    }
    
    announcer.textContent = message;
    
    // Nettoyer après un délai
    setTimeout(() => {
      announcer.textContent = '';
    }, 1000);
  }

})(Drupal, drupalSettings, once);