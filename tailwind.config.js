/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./templates/**/*.{html,twig}",
    "./src/**/*.{css,js}",
    "./assets/**/*.{css,js}"
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        // Couleurs principales de la commune - RGAA compliant
        commune: {
          primary: {
            50: '#eff6ff',
            100: '#dbeafe', 
            200: '#bfdbfe',
            300: '#93c5fd',
            400: '#60a5fa',
            500: '#3b82f6',
            600: '#2563eb',
            700: '#1d4ed8',
            800: '#1e40af', // Bleu institutionnel
            900: '#1e3a8a'
          },
          secondary: {
            50: '#ecfdf5',
            100: '#d1fae5',
            200: '#a7f3d0',
            300: '#6ee7b7',
            400: '#34d399',
            500: '#10b981',
            600: '#059669', // Vert environnement
            700: '#047857',
            800: '#065f46',
            900: '#064e3b'
          },
          accent: {
            50: '#fef2f2',
            100: '#fee2e2',
            200: '#fecaca',
            300: '#fca5a5',
            400: '#f87171',
            500: '#ef4444',
            600: '#dc2626', // Rouge urgence/alerte
            700: '#b91c1c',
            800: '#991b1b',
            900: '#7f1d1d'
          },
          warning: {
            50: '#fffbeb',
            100: '#fef3c7',
            200: '#fde68a',
            300: '#fcd34d',
            400: '#fbbf24',
            500: '#f59e0b',
            600: '#d97706',
            700: '#b45309',
            800: '#92400e',
            900: '#78350f'
          },
          success: {
            50: '#f0fdf4',
            100: '#dcfce7',
            200: '#bbf7d0',
            300: '#86efac',
            400: '#4ade80',
            500: '#22c55e',
            600: '#16a34a',
            700: '#15803d',
            800: '#166534',
            900: '#14532d'
          },
          // Palette gouvernementale française
          marianne: {
            blue: '#000091',
            red: '#e1000f',
            silver: '#ddd'
          }
        }
      },
      fontFamily: {
        'sans': ['Marianne', 'system-ui', 'sans-serif'],
        'serif': ['Spectral', 'Georgia', 'serif'],
        'mono': ['JetBrains Mono', 'Monaco', 'monospace']
      },
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1' }],
        '6xl': ['3.75rem', { lineHeight: '1' }],
        '7xl': ['4.5rem', { lineHeight: '1' }],
        '8xl': ['6rem', { lineHeight: '1' }],
        '9xl': ['8rem', { lineHeight: '1' }]
      },
      screens: {
        'xs': '475px',
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px'
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem'
      },
      maxWidth: {
        'xs': '20rem',
        'sm': '24rem',
        'md': '28rem',
        'lg': '32rem',
        'xl': '36rem',
        '2xl': '42rem',
        '3xl': '48rem',
        '4xl': '56rem',
        '5xl': '64rem',
        '6xl': '72rem',
        '7xl': '80rem',
        'prose': '65ch'
      },
      boxShadow: {
        'card': '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
        'card-hover': '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
        'modal': '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
        'header': '0 1px 2px 0 rgb(0 0 0 / 0.05)'
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'scale-in': 'scaleIn 0.2s ease-out',
        'pulse-soft': 'pulseSoft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite'
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' }
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' }
        },
        slideDown: {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' }
        },
        scaleIn: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' }
        },
        pulseSoft: {
          '0%, 100%': { opacity: '1' },
          '50%': { opacity: '0.7' }
        }
      },
      zIndex: {
        'dropdown': '1000',
        'sticky': '1010',
        'fixed': '1020',
        'modal-backdrop': '1030',
        'modal': '1040',
        'popover': '1050',
        'tooltip': '1060'
      },
      // Grille spécialisée pour les cartes
      gridTemplateColumns: {
        'auto-fit-300': 'repeat(auto-fit, minmax(300px, 1fr))',
        'auto-fit-280': 'repeat(auto-fit, minmax(280px, 1fr))',
        'auto-fit-250': 'repeat(auto-fit, minmax(250px, 1fr))'
      },
      // Aspects ratios pour les médias
      aspectRatio: {
        'video': '16 / 9',
        'card': '4 / 3',
        'portrait': '3 / 4'
      }
    }
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/container-queries'),
    
    // Plugin personnalisé pour les composants commune
    function({ addComponents, theme }) {
      addComponents({
        // Classes utilitaires pour l'accessibilité
        '.sr-only': {
          position: 'absolute',
          width: '1px',
          height: '1px',
          padding: '0',
          margin: '-1px',
          overflow: 'hidden',
          clip: 'rect(0, 0, 0, 0)',
          whiteSpace: 'nowrap',
          border: '0'
        },
        '.not-sr-only': {
          position: 'static',
          width: 'auto',
          height: 'auto',
          padding: '0',
          margin: '0',
          overflow: 'visible',
          clip: 'auto',
          whiteSpace: 'normal'
        },
        
        // Focus visible amélioré
        '.focus-visible:focus': {
          outline: `2px solid ${theme('colors.commune.primary.600')}`,
          outlineOffset: '2px'
        },
        
        // Conteneur principal
        '.container-commune': {
          width: '100%',
          maxWidth: '1280px',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: theme('spacing.4'),
          paddingRight: theme('spacing.4'),
          '@screen sm': {
            paddingLeft: theme('spacing.6'),
            paddingRight: theme('spacing.6')
          },
          '@screen lg': {
            paddingLeft: theme('spacing.8'),
            paddingRight: theme('spacing.8')
          }
        },
        
        // Boutons standardisés
        '.btn': {
          display: 'inline-flex',
          alignItems: 'center',
          justifyContent: 'center',
          paddingTop: theme('spacing.2'),
          paddingBottom: theme('spacing.2'),
          paddingLeft: theme('spacing.4'),
          paddingRight: theme('spacing.4'),
          fontSize: theme('fontSize.sm'),
          fontWeight: theme('fontWeight.semibold'),
          borderRadius: theme('borderRadius.md'),
          border: '1px solid transparent',
          textDecoration: 'none',
          cursor: 'pointer',
          transition: 'all 0.15s ease-in-out',
          
          '&:focus': {
            outline: `2px solid ${theme('colors.commune.primary.600')}`,
            outlineOffset: '2px'
          },
          
          '&:disabled': {
            opacity: '0.5',
            cursor: 'not-allowed'
          }
        },
        
        '.btn-primary': {
          backgroundColor: theme('colors.commune.primary.600'),
          color: theme('colors.white'),
          
          '&:hover': {
            backgroundColor: theme('colors.commune.primary.700')
          }
        },
        
        '.btn-secondary': {
          backgroundColor: theme('colors.commune.secondary.600'),
          color: theme('colors.white'),
          
          '&:hover': {
            backgroundColor: theme('colors.commune.secondary.700')
          }
        },
        
        '.btn-outline': {
          backgroundColor: 'transparent',
          color: theme('colors.commune.primary.600'),
          borderColor: theme('colors.commune.primary.600'),
          
          '&:hover': {
            backgroundColor: theme('colors.commune.primary.600'),
            color: theme('colors.white')
          }
        }
      })
    }
  ]
}
            50: '#f9fafb',
            100: '#f3f4f6',
            200: '#e5e7eb',
            300: '#d1d5db',
            400: '#9ca3af',
            500: '#6b7280',
            600: '#4b5563',
            700: '#374151',
            800: '#1f2937',
            900: '#111827'
          }
        }
      },
      fontFamily: {
        'sans': ['system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
        'serif': ['Marianne', 'Georgia', 'Cambria', 'Times New Roman', 'serif'],
        'mono': ['SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace']
      },
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],     // 12px
        'sm': ['0.875rem', { lineHeight: '1.25rem' }], // 14px
        'base': ['1rem', { lineHeight: '1.5rem' }],    // 16px
        'lg': ['1.125rem', { lineHeight: '1.75rem' }], // 18px
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],  // 20px
        '2xl': ['1.5rem', { lineHeight: '2rem' }],     // 24px
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }], // 30px
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],   // 36px
        '5xl': ['3rem', { lineHeight: '1' }],           // 48px
        '6xl': ['3.75rem', { lineHeight: '1' }],        // 60px
      },
      spacing: {
        '18': '4.5rem',   // 72px
        '88': '22rem',    // 352px
        '128': '32rem',   // 512px
      },
      maxWidth: {
        '8xl': '88rem',   // 1408px
        '9xl': '96rem',   // 1536px
      },
      zIndex: {
        '-1': '-1',
        '60': '60',
        '70': '70',
        '80': '80',
        '90': '90',
        '100': '100',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'bounce-gentle': 'bounceGentle 2s infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        bounceGentle: {
          '0%, 20%, 50%, 80%, 100%': { transform: 'translateY(0)' },
          '40%': { transform: 'translateY(-4px)' },
          '60%': { transform: 'translateY(-2px)' },
        },
      },
      boxShadow: {
        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
        'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 20px -5px rgba(0, 0, 0, 0.04)',
        'strong': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
      },
      screens: {
        'xs': '475px',
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
        '3xl': '1920px',
        // Breakpoints pour l'accessibilité
        'motion-safe': { 'raw': '(prefers-reduced-motion: no-preference)' },
        'motion-reduce': { 'raw': '(prefers-reduced-motion: reduce)' },
        'high-contrast': { 'raw': '(prefers-contrast: high)' },
        'print': { 'raw': 'print' },
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    
    // Plugin personnalisé pour les utilitaires d'accessibilité
    function({ addUtilities, addComponents, theme }) {
      // Utilitaires d'accessibilité
      addUtilities({
        '.sr-only': {
          position: 'absolute',
          width: '1px',
          height: '1px',
          padding: '0',
          margin: '-1px',
          overflow: 'hidden',
          clip: 'rect(0, 0, 0, 0)',
          whiteSpace: 'nowrap',
          border: '0',
        },
        '.sr-only-focusable:focus': {
          position: 'static',
          width: 'auto',
          height: 'auto',
          padding: 'inherit',
          margin: 'inherit',
          overflow: 'visible',
          clip: 'auto',
          whiteSpace: 'normal',
        },
        '.focus-visible': {
          '&:focus': {
            outline: `2px solid ${theme('colors.commune.accent.600')}`,
            outlineOffset: '2px',
          },
        },
        '.skip-link': {
          position: 'absolute',
          top: '-40px',
          left: '6px',
          backgroundColor: theme('colors.commune.gray.900'),
          color: theme('colors.white'),
          padding: `${theme('spacing.2')} ${theme('spacing.4')}`,
          textDecoration: 'none',
          borderRadius: theme('borderRadius.sm'),
          zIndex: theme('zIndex.50'),
          fontWeight: theme('fontWeight.semibold'),
          '&:focus': {
            top: '6px',
          },
        },
      });

      // Composants personnalisés
      addComponents({
        '.btn': {
          display: 'inline-flex',
          alignItems: 'center',
          justifyContent: 'center',
          borderRadius: theme('borderRadius.md'),
          fontWeight: theme('fontWeight.medium'),
          textDecoration: 'none',
          transition: 'all 0.15s ease-in-out',
          cursor: 'pointer',
          border: '1px solid transparent',
          '&:focus': {
            outline: `2px solid ${theme('colors.commune.accent.600')}`,
            outlineOffset: '2px',
          },
        },
        '.btn-primary': {
          backgroundColor: theme('colors.commune.primary.800'),
          color: theme('colors.white'),
          '&:hover': {
            backgroundColor: theme('colors.commune.primary.900'),
          },
          '&:active': {
            backgroundColor: theme('colors.commune.primary.700'),
          },
        },
        '.btn-secondary': {
          backgroundColor: theme('colors.commune.secondary.600'),
          color: theme('colors.white'),
          '&:hover': {
            backgroundColor: theme('colors.commune.secondary.700'),
          },
        },
        '.btn-outline': {
          borderColor: theme('colors.commune.primary.800'),
          color: theme('colors.commune.primary.800'),
          '&:hover': {
            backgroundColor: theme('colors.commune.primary.800'),
            color: theme('colors.white'),
          },
        },
        '.card': {
          backgroundColor: theme('colors.white'),
          borderRadius: theme('borderRadius.lg'),
          boxShadow: theme('boxShadow.soft'),
          overflow: 'hidden',
        },
        '.alert': {
          display: 'flex',
          alignItems: 'flex-start',
          gap: theme('spacing.4'),
          padding: theme('spacing.4'),
          marginBottom: theme('spacing.4'),
          borderRadius: theme('borderRadius.lg'),
          borderLeft: '4px solid',
        },
        '.alert-info': {
          backgroundColor: '#eff6ff',
          borderColor: theme('colors.commune.primary.500'),
          color: theme('colors.commune.primary.800'),
        },
        '.alert-success': {
          backgroundColor: '#f0fdf4',
          borderColor: theme('colors.commune.secondary.500'),
          color: theme('colors.commune.secondary.800'),
        },
        '.alert-warning': {
          backgroundColor: '#fffbeb',
          borderColor: '#f59e0b',
          color: '#92400e',
        },
        '.alert-error': {
          backgroundColor: '#fef2f2',
          borderColor: theme('colors.commune.accent.500'),
          color: theme('colors.commune.accent.800'),
        },
      });
    },
  ],
  // Mode sombre (optionnel pour une future évolution)
  darkMode: 'class',
  
  // Configuration pour la production
  ...(process.env.NODE_ENV === 'production' && {
    purge: {
      enabled: true,
      content: [
        "./templates/**/*.{html,twig}",
        "./assets/js/**/*.js",
        "./src/**/*.{css,js}",
        "../commune_setup/templates/**/*.twig"
      ],
      safelist: [
        // Classes dynamiques à préserver
        /^alert-/,
        /^btn-/,
        /^commune-/,
        'is-open',
        'is-active',
        'has-focus',
        'sr-only',
        'sr-only-focusable',
      ],
    },
  }),
}