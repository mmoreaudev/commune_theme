/**
 * @file
 * Module de navigation - Thème Commune
 * Gestion du menu principal, menu mobile et navigation
 */

export function setupNavigation() {
  setupMobileMenu();
  setupMainNavigation();
  setupMegaMenu();
  setupBreadcrumbs();
}

/**
 * Menu mobile
 */
function setupMobileMenu() {
  const toggle = document.querySelector('.mobile-menu-toggle');
  const menu = document.querySelector('.mobile-menu');
  const overlay = document.querySelector('.mobile-overlay');
  
  if (!toggle || !menu) return;

  let isOpen = false;

  const openMenu = () => {
    isOpen = true;
    menu.classList.add('mobile-menu--open');
    overlay?.classList.add('mobile-overlay--visible');
    toggle.setAttribute('aria-expanded', 'true');
    toggle.setAttribute('aria-label', 'Fermer le menu');
    
    // Piéger le focus dans le menu
    trapFocus(menu);
    
    // Empêcher le scroll du body
    document.body.style.overflow = 'hidden';
    
    // Focus sur le premier lien
    const firstLink = menu.querySelector('a, button');
    firstLink?.focus();
  };

  const closeMenu = () => {
    isOpen = false;
    menu.classList.remove('mobile-menu--open');
    overlay?.classList.remove('mobile-overlay--visible');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Ouvrir le menu');
    
    // Restaurer le scroll
    document.body.style.overflow = '';
    
    // Rendre le focus au bouton
    toggle.focus();
  };

  // Événements du bouton toggle
  toggle.addEventListener('click', () => {
    isOpen ? closeMenu() : openMenu();
  });

  // Fermeture via overlay
  overlay?.addEventListener('click', closeMenu);

  // Fermeture via Escape
  document.addEventListener('theme:escape', closeMenu);

  // Fermeture via redimensionnement
  window.addEventListener('resize', () => {
    if (window.innerWidth > 768 && isOpen) {
      closeMenu();
    }
  });

  // Sous-menus mobile
  const subMenuToggles = menu?.querySelectorAll('.menu-item--has-children > a');
  subMenuToggles?.forEach(toggle => {
    const item = toggle.parentElement;
    const subMenu = item.querySelector('.menu-item__submenu');
    
    if (!subMenu) return;

    // Créer un bouton pour les sous-menus
    const button = document.createElement('button');
    button.className = 'submenu-toggle';
    button.setAttribute('aria-expanded', 'false');
    button.setAttribute('aria-label', 'Ouvrir le sous-menu');
    button.innerHTML = '<span class="submenu-toggle__icon">+</span>';
    
    item.appendChild(button);

    button.addEventListener('click', (e) => {
      e.preventDefault();
      const isExpanded = button.getAttribute('aria-expanded') === 'true';
      
      button.setAttribute('aria-expanded', !isExpanded);
      button.setAttribute('aria-label', isExpanded ? 'Ouvrir le sous-menu' : 'Fermer le sous-menu');
      subMenu.classList.toggle('menu-item__submenu--open');
      button.querySelector('.submenu-toggle__icon').textContent = isExpanded ? '+' : '−';
    });
  });
}

/**
 * Navigation principale desktop
 */
function setupMainNavigation() {
  const nav = document.querySelector('.main-navigation');
  if (!nav) return;

  // Gestion des sous-menus au hover/focus
  const menuItems = nav.querySelectorAll('.menu-item--has-children');
  
  menuItems.forEach(item => {
    const link = item.querySelector('a');
    const subMenu = item.querySelector('.menu-item__submenu');
    
    if (!link || !subMenu) return;

    let hoverTimeout;

    // Événements hover
    item.addEventListener('mouseenter', () => {
      clearTimeout(hoverTimeout);
      showSubMenu(item, subMenu);
    });

    item.addEventListener('mouseleave', () => {
      hoverTimeout = setTimeout(() => {
        hideSubMenu(item, subMenu);
      }, 100);
    });

    // Événements focus
    link.addEventListener('focus', () => {
      showSubMenu(item, subMenu);
    });

    // Focus des sous-éléments
    const subLinks = subMenu.querySelectorAll('a');
    const lastSubLink = subLinks[subLinks.length - 1];
    
    lastSubLink?.addEventListener('blur', (e) => {
      // Si le focus sort du sous-menu, on le ferme
      if (!item.contains(e.relatedTarget)) {
        hideSubMenu(item, subMenu);
      }
    });
  });

  function showSubMenu(item, subMenu) {
    item.classList.add('menu-item--open');
    subMenu.classList.add('menu-item__submenu--visible');
    subMenu.setAttribute('aria-hidden', 'false');
  }

  function hideSubMenu(item, subMenu) {
    item.classList.remove('menu-item--open');
    subMenu.classList.remove('menu-item__submenu--visible');
    subMenu.setAttribute('aria-hidden', 'true');
  }
}

/**
 * Mega menu (si présent)
 */
function setupMegaMenu() {
  const megaMenus = document.querySelectorAll('.mega-menu');
  
  megaMenus.forEach(menu => {
    const trigger = menu.querySelector('.mega-menu__trigger');
    const content = menu.querySelector('.mega-menu__content');
    
    if (!trigger || !content) return;

    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const isOpen = content.classList.contains('mega-menu__content--open');
      
      // Fermer tous les autres mega menus
      document.querySelectorAll('.mega-menu__content--open').forEach(otherContent => {
        otherContent.classList.remove('mega-menu__content--open');
      });
      
      if (!isOpen) {
        content.classList.add('mega-menu__content--open');
        trigger.setAttribute('aria-expanded', 'true');
      } else {
        trigger.setAttribute('aria-expanded', 'false');
      }
    });

    // Fermeture via clic extérieur
    document.addEventListener('click', (e) => {
      if (!menu.contains(e.target)) {
        content.classList.remove('mega-menu__content--open');
        trigger.setAttribute('aria-expanded', 'false');
      }
    });
  });
}

/**
 * Fil d'Ariane amélioré
 */
function setupBreadcrumbs() {
  const breadcrumbs = document.querySelector('.breadcrumb');
  if (!breadcrumbs) return;

  // Ajout d'un indicateur de page courante
  const links = breadcrumbs.querySelectorAll('a');
  const lastLink = links[links.length - 1];
  
  if (lastLink) {
    lastLink.setAttribute('aria-current', 'page');
  }

  // Responsive : masquer les éléments intermédiaires sur mobile
  if (window.innerWidth < 768 && links.length > 3) {
    const items = breadcrumbs.querySelectorAll('.breadcrumb__item');
    
    items.forEach((item, index) => {
      if (index > 0 && index < items.length - 2) {
        item.style.display = 'none';
      }
    });

    // Ajouter un indicateur "..."
    if (items.length > 3) {
      const ellipsis = document.createElement('span');
      ellipsis.className = 'breadcrumb__ellipsis';
      ellipsis.textContent = '...';
      ellipsis.setAttribute('aria-hidden', 'true');
      
      items[1].parentNode.insertBefore(ellipsis, items[items.length - 2]);
    }
  }
}

/**
 * Piège à focus pour l'accessibilité
 */
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
  
  // Retourner une fonction de nettoyage
  return () => {
    element.removeEventListener('keydown', handleTabKey);
  };
}