module.exports = {
  content: [
    "./**/*.{html,js,php}",
    "!./node_modules/**"
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