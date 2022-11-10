/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,php}",
  "./node_modules/flowbite/**/*.js"] ,
  theme: {
    extend: {},
  },
  plugins: [
    requite('flowbite/plugin')
  ],
}
