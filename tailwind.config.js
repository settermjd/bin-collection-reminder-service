/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.twig"
  ],
  theme: {
    extend: {
      backgroundImage: {
        'bin-pattern': "url('/images/backgrounds/bin-background.png')",
        'bin-pattern-200': "url('/images/backgrounds/bin-background-200.png')",
        'bin-pattern-100': "url('/images/backgrounds/bin-background-100.png')",
        'bin-pattern-100-50o': "url('/images/backgrounds/bin-background-100-50.png')",
        'bin-pattern-100-25o': "url('/images/backgrounds/bin-background-100-25.png')"
      }
    },
  },
  plugins: [],
}

