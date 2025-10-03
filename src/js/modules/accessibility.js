/**
 * @file
 * Module d'accessibilité - Thème Commune
 * Améliorations RGAA et fonctionnalités d'accessibilité
 */

export function setupAccessibility() {
  setupFontSizeControls();
  setupContrastToggle();
  setupSkipLinks();
  setupFocusManagement();
  setupAriaEnhancements();
  setupMotionPreferences();
}

/**
 * Contrôles de taille de police
 */
function setupFontSizeControls() {
  const controls = document.querySelectorAll('.font-size-toggle, .font-btn');
  if (!controls.length) return;

  const fontSizes = {
    small: 0.875,
    normal: 1,
    large: 1.125,
    xlarge: 1.25
  };

  let currentSize = localStorage.getItem('commune-font-size') || 'normal';
  applyFontSize(currentSize);

  controls.forEach(control => {
    control.addEventListener('click', (e) => {
      e.preventDefault();
      
      if (control.classList.contains('font-size-toggle')) {
        // Cycle à travers les tailles
        const sizes = Object.keys(fontSizes);
        const currentIndex = sizes.indexOf(currentSize);
        const nextIndex = (currentIndex + 1) % sizes.length;
        currentSize = sizes[nextIndex];
      } else {
        // Bouton spécifique
        currentSize = control.dataset.size || 'normal';
      }
      
      applyFontSize(currentSize);
      updateFontSizeIndicators();
      
      // Annoncer le changement
      announceChange(`Taille de police : ${currentSize}`);
    });
  });

  function applyFontSize(size) {
    const multiplier = fontSizes[size] || 1;
    document.documentElement.style.fontSize = `${multiplier}rem`;
    localStorage.setItem('commune-font-size', size);
  }

  function updateFontSizeIndicators() {
    controls.forEach(control => {
      if (control.dataset.size) {
        control.classList.toggle('font-btn--active', control.dataset.size === currentSize);
      }
    });
  }

  updateFontSizeIndicators();
}

/**
 * Basculeur de contraste élevé
 */
function setupContrastToggle() {
  const toggle = document.querySelector('.contrast-toggle');
  if (!toggle) return;

  let isHighContrast = localStorage.getItem('commune-high-contrast') === 'true';
  applyContrast(isHighContrast);

  toggle.addEventListener('click', (e) => {
    e.preventDefault();
    isHighContrast = !isHighContrast;
    applyContrast(isHighContrast);
    
    announceChange(isHighContrast ? 
      'Contraste élevé activé' : 
      'Contraste élevé désactivé'
    );
  });

  function applyContrast(enable) {
    document.documentElement.classList.toggle('high-contrast', enable);
    localStorage.setItem('commune-high-contrast', enable);
    toggle.setAttribute('aria-pressed', enable);
  }
}

/**
 * Liens d'évitement améliorés
 */
function setupSkipLinks() {
  const skipLinks = document.querySelectorAll('.skip-link');
  
  skipLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('href').substring(1);
      const target = document.getElementById(targetId);
      
      if (target) {
        // Rendre l'élément focusable temporairement
        const originalTabIndex = target.tabIndex;
        target.tabIndex = -1;
        target.focus();
        
        // Restaurer après focus
        setTimeout(() => {
          if (originalTabIndex >= 0) {
            target.tabIndex = originalTabIndex;
          } else {
            target.removeAttribute('tabindex');
          }
        }, 100);
        
        // Scroll vers l'élément
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

/**
 * Gestion avancée du focus
 */
function setupFocusManagement() {
  // Focus visible uniquement pour la navigation clavier
  let isKeyboardUser = false;
  
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Tab') {
      isKeyboardUser = true;
      document.body.classList.add('keyboard-navigation');
    }
  });
  
  document.addEventListener('mousedown', () => {
    isKeyboardUser = false;
    document.body.classList.remove('keyboard-navigation');
  });

  // Focus sur les éléments dynamiques
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        if (node.nodeType === Node.ELEMENT_NODE) {
          // Si un modal/dialog est ajouté, focus sur le premier élément focusable
          if (node.matches('[role="dialog"], .modal')) {
            const firstFocusable = node.querySelector(
              'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            firstFocusable?.focus();
          }
        }
      });
    });
  });
  
  observer.observe(document.body, { childList: true, subtree: true });

  // Indicateur de focus personnalisé
  document.addEventListener('focusin', (e) => {
    if (isKeyboardUser && e.target.matches('a, button, input, select, textarea')) {
      createFocusIndicator(e.target);
    }
  });

  document.addEventListener('focusout', () => {
    removeFocusIndicator();
  });
}

/**
 * Améliorations ARIA
 */
function setupAriaEnhancements() {
  // Mise à jour automatique d'aria-current pour la navigation
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('nav a[href]');
  
  navLinks.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.setAttribute('aria-current', 'page');
    }
  });

  // ARIA pour les listes d'articles
  const articleLists = document.querySelectorAll('.news-grid, .events-grid, .cards-grid');
  articleLists.forEach(list => {
    if (!list.getAttribute('role')) {
      list.setAttribute('role', 'feed');
      list.setAttribute('aria-label', 'Liste d\'articles');
    }
  });

  // ARIA pour les boutons avec icônes
  const iconButtons = document.querySelectorAll('button[aria-label] svg, button[aria-label] .icon');
  iconButtons.forEach(icon => {
    icon.setAttribute('aria-hidden', 'true');
  });

  // Amélioration des messages d'état
  const alerts = document.querySelectorAll('.alert, .message');
  alerts.forEach(alert => {
    if (!alert.getAttribute('role')) {
      const type = alert.classList.contains('error') ? 'alert' : 'status';
      alert.setAttribute('role', type);
      alert.setAttribute('aria-live', 'polite');
    }
  });
}

/**
 * Respect des préférences de mouvement
 */
function setupMotionPreferences() {
  const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  
  function handleMotionPreference(mediaQuery) {
    if (mediaQuery.matches) {
      document.documentElement.classList.add('reduce-motion');
      
      // Désactiver les animations CSS
      const style = document.createElement('style');
      style.textContent = `
        *, *::before, *::after {
          animation-duration: 0.01ms !important;
          animation-iteration-count: 1 !important;
          transition-duration: 0.01ms !important;
        }
      `;
      document.head.appendChild(style);
    } else {
      document.documentElement.classList.remove('reduce-motion');
    }
  }
  
  handleMotionPreference(mediaQuery);
  mediaQuery.addEventListener('change', handleMotionPreference);
}

/**
 * Utilitaires d'accessibilité
 */

// Annonce de changements via screen reader
function announceChange(message) {
  const announcer = getOrCreateAnnouncer();
  announcer.textContent = '';
  setTimeout(() => {
    announcer.textContent = message;
  }, 100);
}

// Créer/récupérer l'élément d'annonce
function getOrCreateAnnouncer() {
  let announcer = document.getElementById('a11y-announcer');
  if (!announcer) {
    announcer = document.createElement('div');
    announcer.id = 'a11y-announcer';
    announcer.setAttribute('aria-live', 'polite');
    announcer.setAttribute('aria-atomic', 'true');
    announcer.className = 'sr-only';
    document.body.appendChild(announcer);
  }
  return announcer;
}

// Indicateur de focus personnalisé
function createFocusIndicator(element) {
  removeFocusIndicator();
  
  const indicator = document.createElement('div');
  indicator.className = 'focus-indicator';
  indicator.id = 'focus-indicator';
  
  const rect = element.getBoundingClientRect();
  indicator.style.cssText = `
    position: absolute;
    top: ${rect.top + window.scrollY - 2}px;
    left: ${rect.left + window.scrollX - 2}px;
    width: ${rect.width + 4}px;
    height: ${rect.height + 4}px;
    border: 2px solid var(--color-primary);
    border-radius: 4px;
    pointer-events: none;
    z-index: 10000;
    transition: all 0.15s ease;
  `;
  
  document.body.appendChild(indicator);
}

function removeFocusIndicator() {
  const indicator = document.getElementById('focus-indicator');
  indicator?.remove();
}

// Export des utilitaires pour usage externe
export const a11yUtils = {
  announceChange,
  trapFocus: (element) => {
    const focusableElements = element.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    const firstFocusable = focusableElements[0];
    const lastFocusable = focusableElements[focusableElements.length - 1];

    const handleTabKey = (e) => {
      if (e.key !== 'Tab') return;

      if (e.shiftKey && document.activeElement === firstFocusable) {
        e.preventDefault();
        lastFocusable.focus();
      } else if (!e.shiftKey && document.activeElement === lastFocusable) {
        e.preventDefault();
        firstFocusable.focus();
      }
    };

    element.addEventListener('keydown', handleTabKey);
    return () => element.removeEventListener('keydown', handleTabKey);
  }
};