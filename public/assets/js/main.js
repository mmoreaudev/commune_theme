// JavaScript principal pour le CMS Mairie
class MairieCMS {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeModules();
        this.setupAccessibility();
    }

    bindEvents() {
        // Navigation mobile
        this.initMobileMenu();
        
        // Formulaires
        this.initForms();
        
        // Modales
        this.initModals();
        
        // Notifications
        this.initNotifications();
        
        // Tables triables
        this.initSortableTables();
        
        // Confirmation d'actions
        this.initConfirmations();
        
        // Upload de fichiers
        this.initFileUploads();
    }

    initMobileMenu() {
        const menuToggle = document.querySelector('[data-mobile-menu-toggle]');
        const mobileMenu = document.querySelector('[data-mobile-menu]');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
                
                menuToggle.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
                
                // Animation
                if (!isExpanded) {
                    mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
                } else {
                    mobileMenu.style.maxHeight = '0';
                }
            });
        }
    }

    initForms() {
        // Validation en temps réel
        const forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(form => {
            const inputs = form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                input.addEventListener('blur', () => this.validateField(input));
                input.addEventListener('input', () => this.clearFieldError(input));
            });

            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });
        });

        // Auto-sauvegarde pour les formulaires longs
        const autoSaveForms = document.querySelectorAll('[data-autosave]');
        autoSaveForms.forEach(form => {
            const formId = form.getAttribute('data-autosave');
            this.initAutoSave(form, formId);
        });
    }

    validateField(field) {
        const rules = this.getValidationRules(field);
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required
        if (rules.required && !value) {
            isValid = false;
            errorMessage = 'Ce champ est obligatoire';
        }

        // Email
        if (rules.email && value && !this.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Email invalide';
        }

        // Min length
        if (rules.minLength && value && value.length < rules.minLength) {
            isValid = false;
            errorMessage = `Minimum ${rules.minLength} caractères`;
        }

        // Max length
        if (rules.maxLength && value && value.length > rules.maxLength) {
            isValid = false;
            errorMessage = `Maximum ${rules.maxLength} caractères`;
        }

        // Pattern
        if (rules.pattern && value && !new RegExp(rules.pattern).test(value)) {
            isValid = false;
            errorMessage = 'Format invalide';
        }

        this.showFieldError(field, isValid ? null : errorMessage);
        return isValid;
    }

    validateForm(form) {
        const fields = form.querySelectorAll('input, textarea, select');
        let isValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    getValidationRules(field) {
        return {
            required: field.hasAttribute('required'),
            email: field.type === 'email',
            minLength: field.getAttribute('minlength'),
            maxLength: field.getAttribute('maxlength'),
            pattern: field.getAttribute('pattern')
        };
    }

    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    showFieldError(field, message) {
        const errorElement = field.parentNode.querySelector('.form-error');
        
        if (message) {
            field.classList.add('error');
            if (errorElement) {
                errorElement.textContent = message;
            } else {
                const error = document.createElement('div');
                error.className = 'form-error';
                error.textContent = message;
                field.parentNode.appendChild(error);
            }
        } else {
            field.classList.remove('error');
            if (errorElement) {
                errorElement.remove();
            }
        }
    }

    clearFieldError(field) {
        field.classList.remove('error');
        const errorElement = field.parentNode.querySelector('.form-error');
        if (errorElement) {
            errorElement.remove();
        }
    }

    initAutoSave(form, formId) {
        const inputs = form.querySelectorAll('input, textarea, select');
        let saveTimeout;

        // Charger les données sauvegardées
        this.loadAutoSaveData(form, formId);

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    this.saveFormData(form, formId);
                }, 1000);
            });
        });

        // Nettoyer lors de la soumission réussie
        form.addEventListener('submit', () => {
            setTimeout(() => {
                localStorage.removeItem(`autosave_${formId}`);
            }, 1000);
        });
    }

    saveFormData(form, formId) {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        localStorage.setItem(`autosave_${formId}`, JSON.stringify(data));
        this.showNotification('Brouillon sauvegardé', 'info', 2000);
    }

    loadAutoSaveData(form, formId) {
        const savedData = localStorage.getItem(`autosave_${formId}`);
        
        if (savedData) {
            const data = JSON.parse(savedData);
            
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field && field.type !== 'file') {
                    field.value = data[key];
                }
            });

            this.showNotification('Brouillon restauré', 'info', 3000);
        }
    }

    initModals() {
        // Ouvrir les modales
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-modal-target]');
            if (trigger) {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal-target');
                this.openModal(modalId);
            }
        });

        // Fermer les modales
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-modal-close]') || 
                e.target.closest('[data-modal-close]') ||
                e.target.matches('.modal-backdrop')) {
                this.closeModal();
            }
        });

        // Fermer avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal();
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            
            // Focus sur le premier élément focusable
            const focusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusable) {
                focusable.focus();
            }

            // Empêcher le scroll du body
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal() {
        const openModal = document.querySelector('.modal:not(.hidden)');
        if (openModal) {
            openModal.classList.add('hidden');
            openModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    }

    initNotifications() {
        // Auto-fermeture des notifications
        const notifications = document.querySelectorAll('.alert[data-auto-close]');
        notifications.forEach(notification => {
            const delay = parseInt(notification.getAttribute('data-auto-close')) || 5000;
            setTimeout(() => {
                this.closeNotification(notification);
            }, delay);
        });

        // Boutons de fermeture
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-notification-close]')) {
                const notification = e.target.closest('.alert');
                this.closeNotification(notification);
            }
        });
    }

    showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} fixed top-4 right-4 z-50 max-w-sm`;
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span>${message}</span>
                <button type="button" data-notification-close class="ml-2 text-sm">×</button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animation d'entrée
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        }, 100);

        // Auto-fermeture
        if (duration > 0) {
            setTimeout(() => {
                this.closeNotification(notification);
            }, duration);
        }
    }

    closeNotification(notification) {
        if (notification) {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }

    initSortableTables() {
        const tables = document.querySelectorAll('table[data-sortable]');
        
        tables.forEach(table => {
            const headers = table.querySelectorAll('th[data-sort]');
            
            headers.forEach(header => {
                header.style.cursor = 'pointer';
                header.innerHTML += ' <span class="sort-indicator">↕</span>';
                
                header.addEventListener('click', () => {
                    this.sortTable(table, header);
                });
            });
        });
    }

    sortTable(table, header) {
        const columnIndex = Array.from(header.parentNode.children).indexOf(header);
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const sortType = header.getAttribute('data-sort');
        
        // Déterminer la direction du tri
        let ascending = true;
        if (header.classList.contains('sort-asc')) {
            ascending = false;
        }

        // Nettoyer les indicateurs précédents
        table.querySelectorAll('th').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
            const indicator = th.querySelector('.sort-indicator');
            if (indicator) {
                indicator.textContent = '↕';
            }
        });

        // Trier les lignes
        rows.sort((a, b) => {
            const aValue = a.children[columnIndex].textContent.trim();
            const bValue = b.children[columnIndex].textContent.trim();
            
            let comparison = 0;
            
            if (sortType === 'number') {
                comparison = parseFloat(aValue) - parseFloat(bValue);
            } else if (sortType === 'date') {
                comparison = new Date(aValue) - new Date(bValue);
            } else {
                comparison = aValue.localeCompare(bValue);
            }
            
            return ascending ? comparison : -comparison;
        });

        // Réorganiser le DOM
        rows.forEach(row => tbody.appendChild(row));

        // Mettre à jour l'indicateur
        header.classList.add(ascending ? 'sort-asc' : 'sort-desc');
        const indicator = header.querySelector('.sort-indicator');
        if (indicator) {
            indicator.textContent = ascending ? '↑' : '↓';
        }
    }

    initConfirmations() {
        document.addEventListener('click', (e) => {
            const element = e.target.closest('[data-confirm]');
            if (element) {
                const message = element.getAttribute('data-confirm');
                if (!confirm(message)) {
                    e.preventDefault();
                }
            }
        });
    }

    initFileUploads() {
        const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                this.handleFilePreview(e.target);
            });
        });
    }

    handleFilePreview(input) {
        const files = input.files;
        const previewContainer = document.getElementById(input.getAttribute('data-preview'));
        
        if (!previewContainer) return;

        previewContainer.innerHTML = '';

        Array.from(files).forEach(file => {
            const preview = document.createElement('div');
            preview.className = 'file-preview';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'max-w-32 max-h-32 object-cover rounded';
                preview.appendChild(img);
            } else {
                preview.innerHTML = `
                    <div class="flex items-center p-2 border rounded">
                        <span class="text-sm">${file.name}</span>
                        <span class="text-xs text-gray-500 ml-2">${this.formatFileSize(file.size)}</span>
                    </div>
                `;
            }

            previewContainer.appendChild(preview);
        });
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    initializeModules() {
        // Initialiser les composants Alpine.js personnalisés
        this.initDropdowns();
        this.initTabs();
        this.initAccordions();
    }

    initDropdowns() {
        document.addEventListener('click', (e) => {
            // Fermer tous les dropdowns sauf celui cliqué
            const dropdowns = document.querySelectorAll('[data-dropdown]');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    const menu = dropdown.querySelector('[data-dropdown-menu]');
                    if (menu) {
                        menu.classList.add('hidden');
                    }
                }
            });

            // Ouvrir/fermer le dropdown cliqué
            const toggle = e.target.closest('[data-dropdown-toggle]');
            if (toggle) {
                e.preventDefault();
                const dropdown = toggle.closest('[data-dropdown]');
                const menu = dropdown.querySelector('[data-dropdown-menu]');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
            }
        });
    }

    initTabs() {
        const tabContainers = document.querySelectorAll('[data-tabs]');
        
        tabContainers.forEach(container => {
            const tabs = container.querySelectorAll('[data-tab]');
            const panels = container.querySelectorAll('[data-tab-panel]');

            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetPanel = tab.getAttribute('data-tab');

                    // Désactiver tous les tabs et panels
                    tabs.forEach(t => t.classList.remove('active'));
                    panels.forEach(p => p.classList.add('hidden'));

                    // Activer le tab et panel sélectionnés
                    tab.classList.add('active');
                    const panel = container.querySelector(`[data-tab-panel="${targetPanel}"]`);
                    if (panel) {
                        panel.classList.remove('hidden');
                    }
                });
            });
        });
    }

    initAccordions() {
        const accordions = document.querySelectorAll('[data-accordion]');
        
        accordions.forEach(accordion => {
            const triggers = accordion.querySelectorAll('[data-accordion-trigger]');
            
            triggers.forEach(trigger => {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    const content = trigger.nextElementSibling;
                    const isOpen = !content.classList.contains('hidden');

                    // Fermer tous les autres éléments si accordion simple
                    if (accordion.getAttribute('data-accordion') === 'single') {
                        const allContents = accordion.querySelectorAll('[data-accordion-content]');
                        allContents.forEach(c => c.classList.add('hidden'));
                        
                        const allTriggers = accordion.querySelectorAll('[data-accordion-trigger]');
                        allTriggers.forEach(t => t.setAttribute('aria-expanded', 'false'));
                    }

                    // Toggle l'élément courant
                    if (isOpen) {
                        content.classList.add('hidden');
                        trigger.setAttribute('aria-expanded', 'false');
                    } else {
                        content.classList.remove('hidden');
                        trigger.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
    }

    setupAccessibility() {
        // Améliorer la navigation au clavier
        this.setupKeyboardNavigation();
        
        // Gérer le focus visible
        this.setupFocusManagement();
        
        // Annoncer les changements aux lecteurs d'écran
        this.setupAriaLiveRegions();
    }

    setupKeyboardNavigation() {
        // Navigation dans les menus
        const menus = document.querySelectorAll('[role="menu"]');
        menus.forEach(menu => {
            const items = menu.querySelectorAll('[role="menuitem"]');
            
            menu.addEventListener('keydown', (e) => {
                const currentIndex = Array.from(items).indexOf(document.activeElement);
                
                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        const nextIndex = (currentIndex + 1) % items.length;
                        items[nextIndex].focus();
                        break;
                        
                    case 'ArrowUp':
                        e.preventDefault();
                        const prevIndex = (currentIndex - 1 + items.length) % items.length;
                        items[prevIndex].focus();
                        break;
                        
                    case 'Home':
                        e.preventDefault();
                        items[0].focus();
                        break;
                        
                    case 'End':
                        e.preventDefault();
                        items[items.length - 1].focus();
                        break;
                }
            });
        });
    }

    setupFocusManagement() {
        // Gérer le focus pour les éléments dynamiques
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === Node.ELEMENT_NODE) {
                            const focusable = node.querySelector('[autofocus]');
                            if (focusable) {
                                focusable.focus();
                            }
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    setupAriaLiveRegions() {
        // Créer une région live pour les annonces
        if (!document.getElementById('aria-live-region')) {
            const liveRegion = document.createElement('div');
            liveRegion.id = 'aria-live-region';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            document.body.appendChild(liveRegion);
        }
    }

    announce(message) {
        const liveRegion = document.getElementById('aria-live-region');
        if (liveRegion) {
            liveRegion.textContent = message;
        }
    }

    // Méthodes utilitaires
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

    // API helper
    async request(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        const config = { ...defaultOptions, ...options };

        try {
            const response = await fetch(url, config);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('Request failed:', error);
            this.showNotification('Une erreur est survenue', 'error');
            throw error;
        }
    }
}

// Initialiser l'application
document.addEventListener('DOMContentLoaded', () => {
    window.mairieCMS = new MairieCMS();
});

// Fonctions globales utiles
window.confirmDelete = function(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
    return confirm(message);
};

window.showLoading = function(element) {
    if (element) {
        element.classList.add('loading');
        element.disabled = true;
    }
};

window.hideLoading = function(element) {
    if (element) {
        element.classList.remove('loading');
        element.disabled = false;
    }
};

// Export pour utilisation en modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MairieCMS;
}