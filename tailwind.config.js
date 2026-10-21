/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./**/*.php', './assets/js/**/*.js'],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: { DEFAULT: '#1976d2', light: '#64b5f6', ink: '#003366', pale: '#e6f0fa' },
        canvas: '#ffffff'
      },
      fontFamily: { sans: ['Poppins', 'sans-serif'] },
      keyframes: {
        'hero-enter': {
          '0%': { opacity: '0', transform: 'translateY(14px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' }
        },
        morph: {
          '0%, 100%': { borderRadius: '51% 49% 48% 52% / 49% 49% 51% 51%' },
          '35%': { borderRadius: '60% 40% 57% 43% / 40% 54% 46% 60%' },
          '65%': { borderRadius: '67% 33% 68% 32% / 27% 70% 30% 73%' }
        },
        typing: { '0%, 100%': { borderColor: 'transparent' }, '50%': { borderColor: 'currentColor' } }
      },
      animation: {
        'hero-enter': 'hero-enter .7s cubic-bezier(.22,1,.36,1) both',
        morph: 'morph 5s linear infinite',
        typing: 'typing .8s steps(1) infinite'
      }
    }
  },
  plugins: []
};
