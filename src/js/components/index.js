/**
 * @file
 * Index des composants JavaScript
 */

export function setupComponents() {
  setupCards();
  setupModals();
  setupCarousel();
  setupTabs();
  setupAccordion();
  setupSearch();
}

/**
 * Cartes interactives
 */
function setupCards() {
  const cards = document.querySelectorAll('.commune-card, .news-card, .event-card');
  
  cards.forEach(card => {
    // Rendre toute la carte cliquable
    const link = card.querySelector('a[href]');
    if (link && !card.dataset.clickable) {
      card.style.cursor = 'pointer';
      card.dataset.clickable = 'true';
      
      card.addEventListener('click', (e) => {
        // Éviter la double action si on clique directement sur un lien
        if (e.target.tagName === 'A' || e.target.closest('a')) return;
        
        link.click();
      });
      
      card.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          link.click();
        }
      });
      
      // Rendre focusable
      card.tabIndex = 0;
    }
  });
}

/**
 * Modales accessibles
 */
function setupModals() {
  const modalTriggers = document.querySelectorAll('[data-modal]');
  const modals = document.querySelectorAll('.modal');
  
  modalTriggers.forEach(trigger => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const modalId = trigger.dataset.modal;
      const modal = document.getElementById(modalId);
      if (modal) openModal(modal);
    });
  });
  
  modals.forEach(modal => {
    const closeButtons = modal.querySelectorAll('.modal__close, [data-modal-close]');
    closeButtons.forEach(btn => {
      btn.addEventListener('click', () => closeModal(modal));
    });
    
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal(modal);
    });
  });
  
  document.addEventListener('theme:escape', () => {
    const openModal = document.querySelector('.modal.modal--open');
    if (openModal) closeModal(openModal);
  });
}

/**
 * Carrousel/Slider
 */
function setupCarousel() {
  const carousels = document.querySelectorAll('.carousel');
  
  carousels.forEach(carousel => {
    new CarouselComponent(carousel);
  });
}

/**
 * Onglets accessibles
 */
function setupTabs() {
  const tabGroups = document.querySelectorAll('.tabs');
  
  tabGroups.forEach(group => {
    new TabsComponent(group);
  });
}

/**
 * Accordéons
 */
function setupAccordion() {
  const accordions = document.querySelectorAll('.accordion');
  
  accordions.forEach(accordion => {
    new AccordionComponent(accordion);
  });
}

/**
 * Recherche
 */
function setupSearch() {
  const searchToggle = document.querySelector('.search-toggle');
  const searchForm = document.querySelector('.search-form');
  
  if (searchToggle && searchForm) {
    searchToggle.addEventListener('click', () => {
      searchForm.classList.toggle('search-form--open');
      const input = searchForm.querySelector('input[type="search"]');
      if (input) input.focus();
    });
  }
}

// Classes de composants
class CarouselComponent {
  constructor(element) {
    this.carousel = element;
    this.slides = element.querySelectorAll('.carousel__slide');
    this.prevBtn = element.querySelector('.carousel__prev');
    this.nextBtn = element.querySelector('.carousel__next');
    this.indicators = element.querySelectorAll('.carousel__indicator');
    
    this.currentSlide = 0;
    this.autoplay = element.dataset.autoplay === 'true';
    this.autoplayDelay = parseInt(element.dataset.autoplayDelay) || 5000;
    
    this.init();
  }
  
  init() {
    this.setupEvents();
    this.updateSlide();
    
    if (this.autoplay) {
      this.startAutoplay();
    }
  }
  
  setupEvents() {
    this.prevBtn?.addEventListener('click', () => this.previousSlide());
    this.nextBtn?.addEventListener('click', () => this.nextSlide());
    
    this.indicators.forEach((indicator, index) => {
      indicator.addEventListener('click', () => this.goToSlide(index));
    });
    
    // Pause sur hover
    this.carousel.addEventListener('mouseenter', () => this.stopAutoplay());
    this.carousel.addEventListener('mouseleave', () => {
      if (this.autoplay) this.startAutoplay();
    });
    
    // Navigation clavier
    this.carousel.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') this.previousSlide();
      if (e.key === 'ArrowRight') this.nextSlide();
    });
  }
  
  nextSlide() {
    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
    this.updateSlide();
  }
  
  previousSlide() {
    this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1;
    this.updateSlide();
  }
  
  goToSlide(index) {
    this.currentSlide = index;
    this.updateSlide();
  }
  
  updateSlide() {
    this.slides.forEach((slide, index) => {
      slide.classList.toggle('carousel__slide--active', index === this.currentSlide);
      slide.setAttribute('aria-hidden', index !== this.currentSlide);
    });
    
    this.indicators.forEach((indicator, index) => {
      indicator.classList.toggle('carousel__indicator--active', index === this.currentSlide);
    });
  }
  
  startAutoplay() {
    this.autoplayTimer = setInterval(() => this.nextSlide(), this.autoplayDelay);
  }
  
  stopAutoplay() {
    clearInterval(this.autoplayTimer);
  }
}

class TabsComponent {
  constructor(element) {
    this.tabs = element;
    this.tabList = element.querySelector('.tabs__list');
    this.tabButtons = element.querySelectorAll('.tabs__button');
    this.tabPanels = element.querySelectorAll('.tabs__panel');
    
    this.init();
  }
  
  init() {
    this.setupEvents();
    this.activateTab(0);
  }
  
  setupEvents() {
    this.tabButtons.forEach((button, index) => {
      button.addEventListener('click', () => this.activateTab(index));
      
      button.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
          e.preventDefault();
          const prevIndex = index === 0 ? this.tabButtons.length - 1 : index - 1;
          this.activateTab(prevIndex);
          this.tabButtons[prevIndex].focus();
        }
        
        if (e.key === 'ArrowRight') {
          e.preventDefault();
          const nextIndex = (index + 1) % this.tabButtons.length;
          this.activateTab(nextIndex);
          this.tabButtons[nextIndex].focus();
        }
      });
    });
  }
  
  activateTab(index) {
    this.tabButtons.forEach((button, i) => {
      button.classList.toggle('tabs__button--active', i === index);
      button.setAttribute('aria-selected', i === index);
      button.tabIndex = i === index ? 0 : -1;
    });
    
    this.tabPanels.forEach((panel, i) => {
      panel.classList.toggle('tabs__panel--active', i === index);
      panel.setAttribute('aria-hidden', i !== index);
    });
  }
}

class AccordionComponent {
  constructor(element) {
    this.accordion = element;
    this.items = element.querySelectorAll('.accordion__item');
    
    this.init();
  }
  
  init() {
    this.items.forEach(item => {
      const button = item.querySelector('.accordion__button');
      const panel = item.querySelector('.accordion__panel');
      
      if (!button || !panel) return;
      
      button.addEventListener('click', () => {
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        
        // Si c'est un accordéon exclusif, fermer les autres
        if (!this.accordion.dataset.multiple) {
          this.items.forEach(otherItem => {
            if (otherItem !== item) {
              this.closeItem(otherItem);
            }
          });
        }
        
        if (isExpanded) {
          this.closeItem(item);
        } else {
          this.openItem(item);
        }
      });
    });
  }
  
  openItem(item) {
    const button = item.querySelector('.accordion__button');
    const panel = item.querySelector('.accordion__panel');
    
    button.setAttribute('aria-expanded', 'true');
    panel.classList.add('accordion__panel--open');
    item.classList.add('accordion__item--open');
  }
  
  closeItem(item) {
    const button = item.querySelector('.accordion__button');
    const panel = item.querySelector('.accordion__panel');
    
    button.setAttribute('aria-expanded', 'false');
    panel.classList.remove('accordion__panel--open');
    item.classList.remove('accordion__item--open');
  }
}

// Utilitaires pour modales
function openModal(modal) {
  modal.classList.add('modal--open');
  modal.setAttribute('aria-hidden', 'false');
  
  // Focus sur le premier élément focusable
  const firstFocusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
  firstFocusable?.focus();
  
  // Piège à focus
  window.currentModalTrap = trapFocus(modal);
  
  // Empêcher le scroll du body
  document.body.style.overflow = 'hidden';
}

function closeModal(modal) {
  modal.classList.remove('modal--open');
  modal.setAttribute('aria-hidden', 'true');
  
  // Nettoyer le piège à focus
  if (window.currentModalTrap) {
    window.currentModalTrap();
    window.currentModalTrap = null;
  }
  
  // Restaurer le scroll du body
  document.body.style.overflow = '';
  
  // Rendre le focus au déclencheur
  const trigger = document.querySelector(`[data-modal="${modal.id}"]`);
  trigger?.focus();
}

function trapFocus(element) {
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