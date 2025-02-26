/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./resources/**/*.jsx",
    ],
    theme: {
      extend: {
        colors: {
          primary: {
            50: '#f0f9ff',
            100: '#e0f2fe',
            200: '#bae6fd',
            300: '#7dd3fc',
            400: '#38bdf8',
            500: '#0ea5e9',
            600: '#0284c7',
            700: '#0369a1',
            800: '#075985',
            900: '#0c4a6e',
            950: '#082f49',
          },
          secondary: {
            50: '#f0fdf4',
            100: '#dcfce7',
            200: '#bbf7d0',
            300: '#86efac',
            400: '#4ade80',
            500: '#22c55e',
            600: '#16a34a',
            700: '#15803d',
            800: '#166534',
            900: '#14532d',
            950: '#052e16',
          },
          accent: {
            50: '#fff7ed',
            100: '#ffedd5',
            200: '#fed7aa',
            300: '#fdba74',
            400: '#fb923c',
            500: '#f97316',
            600: '#ea580c',
            700: '#c2410c',
            800: '#9a3412',
            900: '#7c2d12',
            950: '#431407',
          },
          // Colors for different habitat types
          forest: '#2d6a4f',
          ocean: '#1e40af',
          mountain: '#7f1d1d',
          sky: '#0369a1',
          cosmic: '#4c1d95',
          enchanted: '#9d174d',
        },
        fontFamily: {
          sans: ['Inter var', 'sans-serif'],
          display: ['Poppins', 'sans-serif'],
        },
        boxShadow: {
          habitat: '0 4px 20px -2px rgba(0, 0, 0, 0.2)',
          creature: '0 10px 15px -3px rgba(0, 0, 0, 0.2)',
        },
        animation: {
          'float': 'float 6s ease-in-out infinite',
          'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        },
        keyframes: {
          float: {
            '0%, 100%': { transform: 'translateY(0)' },
            '50%': { transform: 'translateY(-10px)' },
          }
        },
        backgroundImage: {
          'forest-pattern': "url('/images/habitats/forest-pattern.svg')",
          'ocean-pattern': "url('/images/habitats/ocean-pattern.svg')",
          'mountain-pattern': "url('/images/habitats/mountain-pattern.svg')",
          'sky-pattern': "url('/images/habitats/sky-pattern.svg')",
          'cosmic-pattern': "url('/images/habitats/cosmic-pattern.svg')",
          'enchanted-pattern': "url('/images/habitats/enchanted-pattern.svg')",
        },
      },
    },
    plugins: [],
  }