/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.php", "./pages/*.php", "./page-builder/*.html"],
  theme: {
    extend: {
      colors : {
        'shadow-image' : '#f8f8f8'
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography')
  ],
}