/**
 * JavaScript principal pour le thème Commune
 * Utilise Alpine.js chargé via CDN pour les interactions
 */

document.addEventListener('DOMContentLoaded', function() {
  
  // ==========================================================================
  // CONFIGURATION GLOBALE
  // ==========================================================================
  
  const CommuneTheme = {
    
    // Configuration
    config: {
      breakpoints: {
        sm: 640,
        md: 768,
        lg: 1024,
        xl: 1280
      },
      animations: {
        fast: 150,
        normal: 250,
        slow: 350
      }
    },
    
    // ==========================================================================
    // ACCESSIBILITÉ
    // ==========================================================================
    
    accessibility: {
      init() {
        this.setupFocusManagement();
        this.setupSkipLinks();
        this.setupKeyboardNavigation();
      },
      
      // Gestion du focus pour navigation clavier
      setupFocusManagement() {
        let hadKeyboardEvent = true;
        let keyboardThrottleTimeout;
        
        function handleFirstTab(e) {
          if (e.keyCode === 9) {
            document.body.classList.add('user-is-tabbing');
            hadKeyboardEvent = true;
          }
        }
        
        function handleMouseDownOnce() {
          document.body.classList.remove('user-is-tabbing');
          hadKeyboardEvent = false;
        }
        
        document.addEventListener('keydown', handleFirstTab);
        document.addEventListener('mousedown', handleMouseDownOnce);
      },
      
      // Liens d'évitement
      setupSkipLinks() {
        const skipLinks = document.querySelectorAll('.skip-link');
        skipLinks.forEach(link => {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
              target.focus();
              target.scrollIntoView({ behavior: 'smooth' });
            }
          });
        });
      },
      
      // Navigation clavier
      setupKeyboardNavigation() {
        // Échap pour fermer les modales/menus
        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape') {
            // Fermer les menus ouverts
            const openMenus = document.querySelectorAll('[x-data]');
            openMenus.forEach(menu => {
              if (menu._x_dataStack) {
                // Utiliser Alpine.js pour fermer
                Alpine.store('mobileMenu', false);
              }
            });
          }
        });
      }
    },
    
    // ==========================================================================
    // NAVIGATION
    // ==========================================================================
    
    navigation: {
      init() {
        this.setupMobileMenu();
        this.setupActiveStates();
      },
      
      setupMobileMenu() {
        // Délégué à Alpine.js via les composants
        console.log('Navigation mobile gérée par Alpine.js');
      },
      
      setupActiveStates() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.commune-nav__link');
        
        navLinks.forEach(link => {
          if (link.getAttribute('href') === currentPath) {
            link.classList.add('commune-nav__link--active');
          }
        });
      }
    },
    
    // ==========================================================================
    // COMPOSANTS UTILITAIRES
    // ==========================================================================
    
    utils: {
      
      // Debounce pour optimiser les événements
      debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
          const later = () => {
            timeout = null;
            if (!immediate) func(...args);
          };
          const callNow = immediate && !timeout;
          clearTimeout(timeout);
          timeout = setTimeout(later, wait);
          if (callNow) func(...args);
        };
      },
      
      // Intersection Observer pour animations
      setupScrollAnimations() {
        const observerOptions = {
          threshold: 0.1,
          rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('animate-in');
            }
          });
        }, observerOptions);
        
        // Observer les éléments avec la classe animate-on-scroll
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
          observer.observe(el);
        });
      },
      
      // Lazy loading des images
      setupLazyLoading() {
        if ('IntersectionObserver' in window) {
          const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
              }
            });
          });
          
          document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
          });
        }
      }
    },
    
    // ==========================================================================
    // INITIALISATION
    // ==========================================================================
    
    init() {
      console.log('🏛️ Thème Commune initialisé');
      
      this.accessibility.init();
      this.navigation.init();
      this.utils.setupScrollAnimations();
      this.utils.setupLazyLoading();
      
      // Optimisations après chargement complet
      window.addEventListener('load', () => {
        this.onPageLoad();
      });
    },
    
    onPageLoad() {
      // Optimisations post-chargement
      console.log('📄 Page complètement chargée');
      
      // Masquer le loader si présent
      const loader = document.querySelector('.page-loader');
      if (loader) {
        loader.classList.add('hidden');
      }
    }
  };
  
  // ==========================================================================
  // COMPOSANTS ALPINE.JS
  // ==========================================================================
  
  // Données globales pour Alpine.js
  window.Alpine = window.Alpine || {};
  
  // Store pour le menu mobile
  document.addEventListener('alpine:init', () => {
    Alpine.store('mobileMenu', false);
    
    Alpine.store('commune', {
      mobileMenuOpen: false,
      searchOpen: false,
      
      toggleMobileMenu() {
        this.mobileMenuOpen = !this.mobileMenuOpen;
      },
      
      closeMobileMenu() {
        this.mobileMenuOpen = false;
      },
      
      toggleSearch() {
        this.searchOpen = !this.searchOpen;
      }
    });
  });
  
  // ==========================================================================
  // DÉMARRAGE
  // ==========================================================================
  
  CommuneTheme.init();
  
});

// ==========================================================================
// COMPOSANTS ALPINE.JS RÉUTILISABLES
// ==========================================================================

// Composant dropdown
window.dropdownComponent = function() {
  return {
    open: false,
    toggle() {
      this.open = !this.open;
    },
    close() {
      this.open = false;
    }
  };
};

// Composant modal
window.modalComponent = function() {
  return {
    open: false,
    show() {
      this.open = true;
      document.body.style.overflow = 'hidden';
    },
    hide() {
      this.open = false;
      document.body.style.overflow = '';
    }
  };
};

// Composant carousel/slider
window.carouselComponent = function(totalSlides = 3) {
  return {
    currentSlide: 0,
    totalSlides: totalSlides,
    
    next() {
      this.currentSlide = this.currentSlide === this.totalSlides - 1 ? 0 : this.currentSlide + 1;
    },
    
    prev() {
      this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
    },
    
    goToSlide(index) {
      this.currentSlide = index;
    }
  };
};

// Composant tabs
window.tabsComponent = function(defaultTab = 0) {
  return {
    activeTab: defaultTab,
    
    setActiveTab(index) {
      this.activeTab = index;
    }
  };
};