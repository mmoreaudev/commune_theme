// Script JavaScript pour le thème commune_theme

document.addEventListener('DOMContentLoaded', function() {
  // Toggle hamburger menu
  const hamburger = document.querySelector('.hamburger');
  const navMenu = document.querySelector('.nav-menu');

  if (hamburger && navMenu) {
    hamburger.addEventListener('click', function() {
      navMenu.classList.toggle('hidden');
      hamburger.setAttribute('aria-expanded', navMenu.classList.contains('hidden') ? 'false' : 'true');
    });

    // Fermer le menu en cliquant en dehors
    document.addEventListener('click', function(event) {
      if (!hamburger.contains(event.target) && !navMenu.contains(event.target)) {
        navMenu.classList.add('hidden');
        hamburger.setAttribute('aria-expanded', 'false');
      }
    });

    // Navigation clavier
    hamburger.addEventListener('keydown', function(event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        hamburger.click();
      }
    });
  }

  // Smooth scrolling pour les ancres
  const anchors = document.querySelectorAll('a[href^="#"]');
  anchors.forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Focus management pour accessibilité
  const focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
  const modal = document.querySelector('.modal');

  if (modal) {
    const firstFocusableElement = modal.querySelectorAll(focusableElements)[0];
    const focusableContent = modal.querySelectorAll(focusableElements);
    const lastFocusableElement = focusableContent[focusableContent.length - 1];

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Tab') {
        if (e.shiftKey) {
          if (document.activeElement === firstFocusableElement) {
            lastFocusableElement.focus();
            e.preventDefault();
          }
        } else {
          if (document.activeElement === lastFocusableElement) {
            firstFocusableElement.focus();
            e.preventDefault();
          }
        }
      }
    });
  }

  // Initialisation Flowbite (carousels, etc.)
  // Flowbite s'initialise automatiquement, mais on peut ajouter des personnalisations ici si nécessaire
});