module.exports = {
  content: [
    './src/**/*.{html,js,php}',
    './*.{html,js,php}',
    './pages/**/*.{html,js,php}',
    './admin/**/*.{html,js,php}',
    './includes/**/*.{html,js,php}',
    './components/**/*.{html,js,php}'
  ],
  theme: {
    extend: {
      colors: {
        champagne: {
          DEFAULT: '#c9a96e',
          light: '#e8d5a8',
          dark: '#a88b4a'
        },
        sidebar: {
          DEFAULT: '#0f172a',
          hover: '#1e293b'
        }
      }
    },
  },
  plugins: [],
}