// Simple interactions for Morton Theme
(function(){
  'use strict';

  // Mobile menu toggle
  const btn = document.getElementById('morton-menu-toggle');
  const mobile = document.getElementById('mobile-menu');
  if (btn && mobile) {
    btn.addEventListener('click', function(){
      const expanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', String(!expanded));
      mobile.classList.toggle('hidden');
    });
  }

  // Initialize Flowbite components if available
  if (window.Flowbite) {
    try {
      // Flowbite auto-inits data attributes (carousel, modal), nothing else needed.
    } catch (e) {
      console.error('Flowbite init error', e);
    }
  }

  // Keyboard accessibility for skip to content
  document.addEventListener('keyup', function(e){
    if (e.key === 'Escape') {
      if (mobile && !mobile.classList.contains('hidden')) {
        mobile.classList.add('hidden');
        if (btn) btn.setAttribute('aria-expanded', 'false');
      }
    }
  });

})();
