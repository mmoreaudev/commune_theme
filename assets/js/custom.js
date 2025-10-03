/**
 * JavaScript personnalisé pour le thème Commune CDN
 * Utilise Alpine.js chargé via CDN
 */

document.addEventListener('DOMContentLoaded', function() {
  
  // Configuration globale
  const CommuneTheme = {
    
    // Accessibilité
    accessibility: {
      init() {
        this.setupFocusManagement();
        this.setupSkipLinks();
      },
      
      setupFocusManagement() {
        let hadKeyboardEvent = true;
        
        function handleFirstTab(e) {
          if (e.keyCode === 9) {
            document.body.classList.add('user-is-tabbing');
          }
        }
        
        function handleMouseDownOnce() {
          document.body.classList.remove('user-is-tabbing');
        }
        
        document.addEventListener('keydown', handleFirstTab);
        document.addEventListener('mousedown', handleMouseDownOnce);
      },
      
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
      }
    },
    
    // Navigation
    navigation: {
      init() {
        this.setupActiveStates();
      },
      
      setupActiveStates() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
          if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
          }
        });
      }
    },
    
    // Utilitaires
    utils: {
      debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
          const later = () => {
            clearTimeout(timeout);
            func(...args);
          };
          clearTimeout(timeout);
          timeout = setTimeout(later, wait);
        };
      }
    },
    
    // Initialisation
    init() {
      console.log('🏛️ Thème Commune CDN initialisé');
      this.accessibility.init();
      this.navigation.init();
    }
  };
  
  // Démarrage
  CommuneTheme.init();
});

// Composants Alpine.js
document.addEventListener('alpine:init', () => {
  
  // Store global
  Alpine.store('commune', {
    mobileMenuOpen: false,
    searchOpen: false,
    
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
    },
    
    closeMobileMenu() {
      this.mobileMenuOpen = false;
    }
  });
  
});

// Composants réutilisables
window.dropdown = function() {
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

window.modal = function() {
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