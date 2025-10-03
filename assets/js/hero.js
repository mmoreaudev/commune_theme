/**
 * Hero Section JavaScript - Animations et interactions modernes
 */

(function (Drupal, drupalSettings, once) {
  'use strict';

  /**
   * Animation des statistiques du hero
   */
  Drupal.behaviors.heroStats = {
    attach: function (context, settings) {
      once('hero-stats', '.hero-stats', context).forEach(function (statsContainer) {
        const stats = statsContainer.querySelectorAll('.hero-stat');
        
        // Observer pour déclencher l'animation au scroll
        const observer = new IntersectionObserver(function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              animateStats(stats);
              observer.unobserve(entry.target);
            }
          });
        }, {
          threshold: 0.5
        });
        
        observer.observe(statsContainer);
      });
    }
  };

  /**
   * Animation des chiffres statistiques
   */
  function animateStats(stats) {
    stats.forEach(function (stat, index) {
      const number = stat.querySelector('.hero-stat-number');
      if (!number) return;
      
      const finalValue = parseInt(number.textContent) || 0;
      const duration = 2000; // 2 secondes
      const increment = finalValue / (duration / 16); // 60fps
      let current = 0;
      
      // Délai d'animation basé sur l'index
      setTimeout(function () {
        const timer = setInterval(function () {
          current += increment;
          
          if (current >= finalValue) {
            current = finalValue;
            clearInterval(timer);
          }
          
          number.textContent = Math.floor(current).toLocaleString();
        }, 16);
      }, index * 200);
    });
  }

  /**
   * Parallax léger pour le hero
   */
  Drupal.behaviors.heroParallax = {
    attach: function (context, settings) {
      once('hero-parallax', '.hero-section', context).forEach(function (hero) {
        const heroImage = hero.querySelector('.hero-image');
        if (!heroImage) return;
        
        let ticking = false;
        
        function updateParallax() {
          const scrolled = window.pageYOffset;
          const rate = scrolled * -0.3;
          
          heroImage.style.transform = `translateY(${rate}px)`;
          ticking = false;
        }
        
        function requestTick() {
          if (!ticking && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            requestAnimationFrame(updateParallax);
            ticking = true;
          }
        }
        
        window.addEventListener('scroll', requestTick, { passive: true });
      });
    }
  };

  /**
   * Typewriter effect pour le titre du hero
   */
  Drupal.behaviors.heroTypewriter = {
    attach: function (context, settings) {
      once('hero-typewriter', '.hero-title[data-typewriter]', context).forEach(function (title) {
        const text = title.textContent;
        const speed = parseInt(title.dataset.speed) || 100;
        
        title.textContent = '';
        title.style.borderRight = '2px solid';
        title.style.animation = 'blink 1s infinite';
        
        let i = 0;
        const timer = setInterval(function () {
          if (i < text.length) {
            title.textContent += text.charAt(i);
            i++;
          } else {
            clearInterval(timer);
            // Supprimer le curseur après l'animation
            setTimeout(function () {
              title.style.borderRight = 'none';
              title.style.animation = 'none';
            }, 1000);
          }
        }, speed);
      });
    }
  };

  /**
   * Scroll vers le contenu
   */
  Drupal.behaviors.heroScroll = {
    attach: function (context, settings) {
      once('hero-scroll', '.hero-scroll', context).forEach(function (scrollBtn) {
        scrollBtn.addEventListener('click', function (e) {
          e.preventDefault();
          
          const target = document.querySelector('.main-content') || 
                        document.querySelector('#main-content');
          
          if (target) {
            const headerHeight = document.querySelector('.site-header').offsetHeight || 0;
            const targetPosition = target.offsetTop - headerHeight - 20;
            
            window.scrollTo({
              top: targetPosition,
              behavior: 'smooth'
            });
          }
        });
      });
    }
  };

  /**
   * Hero slider (si multiple heroes)
   */
  Drupal.behaviors.heroSlider = {
    attach: function (context, settings) {
      once('hero-slider', '.hero-slider', context).forEach(function (slider) {
        const slides = slider.querySelectorAll('.hero-slide');
        const dots = slider.querySelectorAll('.hero-dot');
        const prevBtn = slider.querySelector('.hero-prev');
        const nextBtn = slider.querySelector('.hero-next');
        
        if (slides.length <= 1) return;
        
        let currentSlide = 0;
        const slideCount = slides.length;
        let autoplayTimer;
        const autoplayDelay = parseInt(slider.dataset.autoplay) || 5000;
        
        // Initialiser
        showSlide(currentSlide);
        
        // Navigation par boutons
        if (prevBtn) {
          prevBtn.addEventListener('click', function () {
            previousSlide();
          });
        }
        
        if (nextBtn) {
          nextBtn.addEventListener('click', function () {
            nextSlide();
          });
        }
        
        // Navigation par dots
        dots.forEach(function (dot, index) {
          dot.addEventListener('click', function () {
            goToSlide(index);
          });
        });
        
        // Navigation clavier
        slider.addEventListener('keydown', function (e) {
          switch (e.key) {
            case 'ArrowLeft':
              e.preventDefault();
              previousSlide();
              break;
            case 'ArrowRight':
              e.preventDefault();
              nextSlide();
              break;
          }
        });
        
        // Autoplay
        if (autoplayDelay > 0) {
          startAutoplay();
          
          // Pause au hover
          slider.addEventListener('mouseenter', stopAutoplay);
          slider.addEventListener('mouseleave', startAutoplay);
          
          // Pause au focus
          slider.addEventListener('focusin', stopAutoplay);
          slider.addEventListener('focusout', startAutoplay);
        }
        
        function showSlide(index) {
          slides.forEach(function (slide, i) {
            slide.classList.toggle('active', i === index);
            slide.setAttribute('aria-hidden', i !== index);
          });
          
          dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === index);
            dot.setAttribute('aria-current', i === index ? 'true' : 'false');
          });
          
          currentSlide = index;
        }
        
        function nextSlide() {
          const next = (currentSlide + 1) % slideCount;
          goToSlide(next);
        }
        
        function previousSlide() {
          const prev = (currentSlide - 1 + slideCount) % slideCount;
          goToSlide(prev);
        }
        
        function goToSlide(index) {
          showSlide(index);
          restartAutoplay();
        }
        
        function startAutoplay() {
          if (autoplayDelay > 0) {
            autoplayTimer = setInterval(nextSlide, autoplayDelay);
          }
        }
        
        function stopAutoplay() {
          clearInterval(autoplayTimer);
        }
        
        function restartAutoplay() {
          stopAutoplay();
          startAutoplay();
        }
      });
    }
  };

  /**
   * Animation des boutons CTA
   */
  Drupal.behaviors.heroCTA = {
    attach: function (context, settings) {
      once('hero-cta', '.hero-btn', context).forEach(function (btn) {
        // Effet de ripple au clic
        btn.addEventListener('click', function (e) {
          const ripple = document.createElement('span');
          const rect = this.getBoundingClientRect();
          const size = Math.max(rect.width, rect.height);
          const x = e.clientX - rect.left - size / 2;
          const y = e.clientY - rect.top - size / 2;
          
          ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
            z-index: 1;
          `;
          
          this.style.position = 'relative';
          this.style.overflow = 'hidden';
          this.appendChild(ripple);
          
          setTimeout(() => {
            ripple.remove();
          }, 600);
        });
      });
    }
  };

  /**
   * Badge flottant animé
   */
  Drupal.behaviors.heroBadge = {
    attach: function (context, settings) {
      once('hero-badge', '.hero-badge', context).forEach(function (badge) {
        // Animation de flottement
        let direction = 1;
        let position = 0;
        
        setInterval(function () {
          if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            position += direction * 0.5;
            
            if (position > 5 || position < -5) {
              direction *= -1;
            }
            
            badge.style.transform = `translateY(${position}px)`;
          }
        }, 50);
      });
    }
  };

})(Drupal, drupalSettings, once);

// Styles CSS pour les animations (à ajouter si nécessaire)
if (!document.querySelector('#hero-animations-styles')) {
  const styles = document.createElement('style');
  styles.id = 'hero-animations-styles';
  styles.textContent = `
    @keyframes blink {
      0%, 50% { border-color: transparent; }
      51%, 100% { border-color: currentColor; }
    }
    
    @keyframes ripple {
      0% { transform: scale(0); opacity: 1; }
      100% { transform: scale(2); opacity: 0; }
    }
    
    .hero-slide {
      transition: opacity 0.6s ease-in-out;
    }
    
    .hero-slide:not(.active) {
      opacity: 0;
    }
    
    .hero-stat {
      transition: transform 0.3s ease-out;
    }
    
    .hero-stat:hover {
      transform: translateY(-2px);
    }
  `;
  document.head.appendChild(styles);
}