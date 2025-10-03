/**
 * Sidebar JavaScript - Fonctionnalités interactives pour la barre latérale
 */

(function (Drupal, drupalSettings, once) {
  'use strict';

  /**
   * Widget horaires avec indicateur temps réel
   */
  Drupal.behaviors.sidebarHours = {
    attach: function (context, settings) {
      once('sidebar-hours', '.hours-widget', context).forEach(function (widget) {
        const hoursList = widget.querySelector('.hours-list');
        if (!hoursList) return;
        
        updateCurrentDay();
        
        // Mettre à jour toutes les minutes
        setInterval(updateCurrentDay, 60000);
        
        function updateCurrentDay() {
          const now = new Date();
          const currentDay = now.getDay(); // 0 = Dimanche, 1 = Lundi, etc.
          const currentHour = now.getHours();
          const currentMinute = now.getMinutes();
          
          // Mapping des jours
          const dayMapping = {
            1: 'lundi',
            2: 'mardi', 
            3: 'mercredi',
            4: 'jeudi',
            5: 'vendredi',
            6: 'samedi',
            0: 'dimanche'
          };
          
          const todayName = dayMapping[currentDay];
          
          // Supprimer les classes précédentes
          hoursList.querySelectorAll('.hours-item').forEach(item => {
            item.classList.remove('hours-item--today', 'hours-item--open', 'hours-item--closed');
          });
          
          // Marquer le jour actuel
          const todayItem = hoursList.querySelector(`[data-day="${todayName}"]`);
          if (todayItem) {
            todayItem.classList.add('hours-item--today');
            
            // Vérifier si ouvert maintenant
            const timeText = todayItem.querySelector('.hours-time').textContent;
            const isOpen = checkIfOpen(timeText, currentHour, currentMinute);
            
            todayItem.classList.add(isOpen ? 'hours-item--open' : 'hours-item--closed');
            
            // Ajouter un indicateur de statut
            addStatusIndicator(todayItem, isOpen);
          }
        }
        
        function checkIfOpen(timeText, hour, minute) {
          if (timeText.toLowerCase().includes('fermé')) return false;
          
          // Parser les heures (format: "09h00 - 17h30")
          const timeMatch = timeText.match(/(\d{1,2})h(\d{2})\s*-\s*(\d{1,2})h(\d{2})/);
          if (!timeMatch) return false;
          
          const openHour = parseInt(timeMatch[1]);
          const openMinute = parseInt(timeMatch[2]);
          const closeHour = parseInt(timeMatch[3]);
          const closeMinute = parseInt(timeMatch[4]);
          
          const currentMinutes = hour * 60 + minute;
          const openMinutes = openHour * 60 + openMinute;
          const closeMinutes = closeHour * 60 + closeMinute;
          
          return currentMinutes >= openMinutes && currentMinutes < closeMinutes;
        }
        
        function addStatusIndicator(item, isOpen) {
          let indicator = item.querySelector('.status-indicator');
          if (!indicator) {
            indicator = document.createElement('span');
            indicator.className = 'status-indicator';
            item.appendChild(indicator);
          }
          
          indicator.textContent = isOpen ? '● Ouvert' : '● Fermé';
          indicator.className = `status-indicator ${isOpen ? 'open' : 'closed'}`;
        }
      });
    }
  };

  /**
   * Widget contact avec fonctionnalités interactives
   */
  Drupal.behaviors.sidebarContact = {
    attach: function (context, settings) {
      once('sidebar-contact', '.contact-widget', context).forEach(function (widget) {
        const phoneLinks = widget.querySelectorAll('a[href^="tel:"]');
        const emailLinks = widget.querySelectorAll('a[href^="mailto:"]');
        
        // Ajouter des icônes aux liens téléphone
        phoneLinks.forEach(function (link) {
          if (!link.querySelector('svg')) {
            const icon = createIcon('phone');
            link.insertBefore(icon, link.firstChild);
          }
          
          // Analytics tracking
          link.addEventListener('click', function () {
            trackEvent('contact', 'phone_click', link.href);
          });
        });
        
        // Ajouter des icônes aux liens email
        emailLinks.forEach(function (link) {
          if (!link.querySelector('svg')) {
            const icon = createIcon('email');
            link.insertBefore(icon, link.firstChild);
          }
          
          // Analytics tracking
          link.addEventListener('click', function () {
            trackEvent('contact', 'email_click', link.href);
          });
        });
      });
    }
  };

  /**
   * Widget actualités sidebar avec lazy loading
   */
  Drupal.behaviors.sidebarNews = {
    attach: function (context, settings) {
      once('sidebar-news', '.sidebar-news-widget', context).forEach(function (widget) {
        const newsItems = widget.querySelectorAll('.news-item');
        
        // Formater les dates
        newsItems.forEach(function (item) {
          const dateElement = item.querySelector('.sidebar-news-date');
          if (dateElement && dateElement.dataset.date) {
            const date = new Date(dateElement.dataset.date);
            const day = date.getDate().toString().padStart(2, '0');
            const month = date.toLocaleDateString('fr-FR', { month: 'short' });
            
            dateElement.innerHTML = `<span class="day">${day}</span><span class="month">${month}</span>`;
          }
        });
        
        // Lazy loading des images si présentes
        const images = widget.querySelectorAll('img[data-src]');
        if (images.length > 0) {
          const imageObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
              if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
              }
            });
          });
          
          images.forEach(img => imageObserver.observe(img));
        }
      });
    }
  };

  /**
   * Widget liens rapides avec keyboard navigation
   */
  Drupal.behaviors.quickLinks = {
    attach: function (context, settings) {
      once('quick-links', '.quick-links-widget', context).forEach(function (widget) {
        const links = widget.querySelectorAll('a');
        
        links.forEach(function (link, index) {
          // Ajouter des icônes basées sur le contenu
          addIconToLink(link);
          
          // Navigation clavier améliorée
          link.addEventListener('keydown', function (e) {
            let targetIndex;
            
            switch (e.key) {
              case 'ArrowDown':
                e.preventDefault();
                targetIndex = (index + 1) % links.length;
                links[targetIndex].focus();
                break;
              case 'ArrowUp':
                e.preventDefault();
                targetIndex = (index - 1 + links.length) % links.length;
                links[targetIndex].focus();
                break;
              case 'Home':
                e.preventDefault();
                links[0].focus();
                break;
              case 'End':
                e.preventDefault();
                links[links.length - 1].focus();
                break;
            }
          });
          
          // Analytics tracking
          link.addEventListener('click', function () {
            trackEvent('sidebar', 'quick_link_click', this.textContent.trim());
          });
        });
      });
    }
  };

  /**
   * Widget météo avec auto-refresh
   */
  Drupal.behaviors.weatherWidget = {
    attach: function (context, settings) {
      once('weather-widget', '.weather-widget', context).forEach(function (widget) {
        if (widget.dataset.autoRefresh === 'true') {
          const refreshInterval = parseInt(widget.dataset.refreshInterval) || 300000; // 5 minutes
          
          setInterval(function () {
            refreshWeatherData(widget);
          }, refreshInterval);
        }
        
        // Ajouter un bouton de rafraîchissement manuel
        const refreshBtn = document.createElement('button');
        refreshBtn.className = 'weather-refresh';
        refreshBtn.innerHTML = '↻';
        refreshBtn.setAttribute('aria-label', 'Actualiser la météo');
        refreshBtn.addEventListener('click', function () {
          refreshWeatherData(widget);
        });
        
        widget.appendChild(refreshBtn);
      });
    }
  };

  /**
   * Alerte widget avec dismissible
   */
  Drupal.behaviors.alertWidget = {
    attach: function (context, settings) {
      once('alert-widget', '.alert-widget', context).forEach(function (widget) {
        const alertId = widget.dataset.alertId;
        
        // Vérifier si l'alerte a été fermée
        if (alertId && localStorage.getItem(`alert-dismissed-${alertId}`)) {
          widget.style.display = 'none';
          return;
        }
        
        // Ajouter un bouton de fermeture
        const closeBtn = document.createElement('button');
        closeBtn.className = 'alert-close';
        closeBtn.innerHTML = '×';
        closeBtn.setAttribute('aria-label', 'Fermer l\'alerte');
        closeBtn.addEventListener('click', function () {
          widget.style.display = 'none';
          if (alertId) {
            localStorage.setItem(`alert-dismissed-${alertId}`, 'true');
          }
          trackEvent('sidebar', 'alert_dismissed', alertId);
        });
        
        widget.appendChild(closeBtn);
      });
    }
  };

  /**
   * Sidebar sticky avec scroll spy
   */
  Drupal.behaviors.sidebarSticky = {
    attach: function (context, settings) {
      once('sidebar-sticky', '.sidebar-first', context).forEach(function (sidebar) {
        let ticking = false;
        
        function updateSidebar() {
          const scrollY = window.scrollY;
          const viewportHeight = window.innerHeight;
          const sidebarHeight = sidebar.offsetHeight;
          
          // Ajuster la position si le contenu est plus grand que la viewport
          if (sidebarHeight > viewportHeight) {
            sidebar.style.maxHeight = `${viewportHeight - 120}px`;
          }
          
          ticking = false;
        }
        
        function requestTick() {
          if (!ticking) {
            requestAnimationFrame(updateSidebar);
            ticking = true;
          }
        }
        
        window.addEventListener('scroll', requestTick, { passive: true });
        window.addEventListener('resize', requestTick);
        
        // Initial call
        updateSidebar();
      });
    }
  };

  /**
   * Fonctions utilitaires
   */
  function createIcon(type) {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', '16');
    svg.setAttribute('height', '16');
    svg.setAttribute('viewBox', '0 0 24 24');
    svg.setAttribute('fill', 'currentColor');
    
    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    
    switch (type) {
      case 'phone':
        path.setAttribute('d', 'M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z');
        break;
      case 'email':
        path.setAttribute('d', 'M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z');
        break;
      default:
        path.setAttribute('d', 'M12,2L2,7L12,12L22,7L12,2M2,17L12,22L22,17M2,12L12,17L22,12');
    }
    
    svg.appendChild(path);
    return svg;
  }
  
  function addIconToLink(link) {
    const text = link.textContent.toLowerCase();
    let iconType = 'default';
    
    if (text.includes('téléphone') || text.includes('tel')) iconType = 'phone';
    else if (text.includes('email') || text.includes('contact')) iconType = 'email';
    else if (text.includes('horaire')) iconType = 'clock';
    else if (text.includes('plan') || text.includes('adresse')) iconType = 'map';
    
    if (!link.querySelector('svg')) {
      const icon = createIcon(iconType);
      link.insertBefore(icon, link.firstChild);
    }
  }
  
  function refreshWeatherData(widget) {
    if (widget.dataset.weatherUrl) {
      widget.classList.add('loading');
      
      fetch(widget.dataset.weatherUrl)
        .then(response => response.json())
        .then(data => {
          updateWeatherDisplay(widget, data);
          widget.classList.remove('loading');
        })
        .catch(error => {
          console.error('Erreur de chargement météo:', error);
          widget.classList.remove('loading');
        });
    }
  }
  
  function updateWeatherDisplay(widget, data) {
    const temp = widget.querySelector('.weather-temp');
    const description = widget.querySelector('.weather-description');
    const icon = widget.querySelector('.weather-icon');
    
    if (temp && data.temperature) {
      temp.textContent = `${data.temperature}°C`;
    }
    
    if (description && data.description) {
      description.textContent = data.description;
    }
    
    if (icon && data.icon) {
      icon.src = data.icon;
    }
  }
  
  function trackEvent(category, action, label) {
    // Google Analytics 4
    if (typeof gtag !== 'undefined') {
      gtag('event', action, {
        event_category: category,
        event_label: label
      });
    }
    
    // Matomo
    if (typeof _paq !== 'undefined') {
      _paq.push(['trackEvent', category, action, label]);
    }
  }

})(Drupal, drupalSettings, once);

// Styles CSS additionnels pour les widgets
if (!document.querySelector('#sidebar-styles')) {
  const styles = document.createElement('style');
  styles.id = 'sidebar-styles';
  styles.textContent = `
    .status-indicator {
      font-size: 0.75rem;
      font-weight: 600;
      margin-left: auto;
    }
    
    .status-indicator.open {
      color: #10b981;
    }
    
    .status-indicator.closed {
      color: #ef4444;
    }
    
    .weather-refresh {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-radius: 50%;
      width: 24px;
      height: 24px;
      color: white;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .weather-refresh:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: rotate(180deg);
    }
    
    .alert-close {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      background: none;
      border: none;
      color: white;
      font-size: 1.25rem;
      cursor: pointer;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .sidebar-news-date .day {
      display: block;
      font-size: 1rem;
      font-weight: 700;
    }
    
    .sidebar-news-date .month {
      display: block;
      font-size: 0.625rem;
      text-transform: uppercase;
      opacity: 0.9;
    }
    
    .weather-widget.loading::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 20px;
      height: 20px;
      margin: -10px 0 0 -10px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top-color: white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  `;
  document.head.appendChild(styles);
}