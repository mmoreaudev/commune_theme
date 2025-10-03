/**
 * @file
 * JavaScript principal du thème Commune Moderne
 * Gestion des interactions et fonctionnalités accessibles
 */

import Alpine from 'alpinejs';
import { setupAccessibility } from './modules/accessibility.js';
import { setupNavigation } from './modules/navigation.js';
import { setupForms } from './modules/forms.js';
import { setupComponents } from './components/index.js';

// Configuration Alpine.js
window.Alpine = Alpine;

// Initialisation du thème
class CommuneTheme {
  constructor() {
    this.isReady = false;
    this.config = {
      breakpoints: {
        sm: 640,
        md: 768,
        lg: 1024,
        xl: 1280
      },
      animations: {
        duration: 300,
        easing: 'ease-in-out'
      }
    };
    
    this.init();
  }

  /**
   * Initialisation principale
   */
  init() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.setup());
    } else {
      this.setup();
    }
  }

  /**
   * Configuration des modules
   */
  setup() {
    console.log('🏛️ Initialisation du thème Commune Moderne');
    
    // Modules principaux
    setupAccessibility();
    setupNavigation();
    setupForms();
    setupComponents();
    
    // Utilitaires
    this.setupScrollToTop();
    this.setupLazyLoading();
    this.setupResizeHandler();
    this.setupKeyboardNavigation();
    
    // Alpine.js
    Alpine.start();
    
    this.isReady = true;
    this.emit('theme:ready');
    console.log('✅ Thème initialisé avec succès');
  }

  /**
   * Bouton retour en haut
   */
  setupScrollToTop() {
    const backToTop = document.getElementById('back-to-top');
    if (!backToTop) return;

    const toggleVisibility = () => {
      const scrolled = window.pageYOffset;
      const threshold = window.innerHeight * 0.5;
      
      backToTop.classList.toggle('back-to-top--visible', scrolled > threshold);
    };

    // Affichage conditionnel
    window.addEventListener('scroll', this.throttle(toggleVisibility, 100));

    // Action de retour
    backToTop.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  /**
   * Lazy loading des images
   */
  setupLazyLoading() {
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy-loading');
            img.classList.add('lazy-loaded');
            observer.unobserve(img);
          }
        });
      });

      document.querySelectorAll('img[data-src]').forEach(img => {
        img.classList.add('lazy-loading');
        imageObserver.observe(img);
      });
    }
  }

  /**
   * Gestion du redimensionnement
   */
  setupResizeHandler() {
    let resizeTimer;
    
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        this.emit('theme:resize', {
          width: window.innerWidth,
          height: window.innerHeight
        });
      }, 150);
    });
  }

  /**
   * Navigation au clavier
   */
  setupKeyboardNavigation() {
    let isTabbing = false;
    
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Tab') {
        if (!isTabbing) {
          document.body.classList.add('user-is-tabbing');
          isTabbing = true;
        }
      }
      
      if (e.key === 'Escape') {
        this.emit('theme:escape');
      }
    });

    document.addEventListener('mousedown', () => {
      if (isTabbing) {
        document.body.classList.remove('user-is-tabbing');
        isTabbing = false;
      }
    });
  }

  /**
   * Utilitaire throttle
   */
  throttle(func, limit) {
    let inThrottle;
    return function() {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }

  /**
   * Système d'événements
   */
  emit(eventName, data = {}) {
    const event = new CustomEvent(eventName, {
      detail: data,
      bubbles: true
    });
    document.dispatchEvent(event);
  }

  /**
   * Détection des fonctionnalités
   */
  static supports = {
    intersectionObserver: 'IntersectionObserver' in window,
    resizeObserver: 'ResizeObserver' in window,
    customElements: 'customElements' in window,
    webp: () => {
      const canvas = document.createElement('canvas');
      return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
    }
  };

  /**
   * Utilitaires pour les composants
   */
  static utils = {
    // Génération d'ID unique
    uniqueId: (prefix = 'commune') => {
      return `${prefix}-${Math.random().toString(36).substr(2, 9)}`;
    },
    
    // Debounce
    debounce: (func, wait) => {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    },
    
    // Récupération de données depuis les attributs data-*
    getData: (element, key) => {
      return element.dataset[key] || element.getAttribute(`data-${key}`);
    },
    
    // Animation smooth pour les éléments
    smoothScroll: (target, offset = 0) => {
      const element = typeof target === 'string' ? document.querySelector(target) : target;
      if (!element) return;
      
      const elementPosition = element.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - offset;
      
      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      });
    }
  };
}

// Initialisation globale
const communeTheme = new CommuneTheme();

// Export pour utilisation dans d'autres scripts
window.CommuneTheme = CommuneTheme;
window.communeTheme = communeTheme;

export default CommuneTheme;