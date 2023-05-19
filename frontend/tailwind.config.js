/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      tableLayout: ["hover", "focus"],
      colors: {
        delete: {
          DEFAULT: "#E51668",
          50: "#F8BAD3",
          100: "#F7A8C7",
          200: "#F382AF",
          300: "#EF5D97",
          400: "#EC387F",
          500: "#E51668",
          600: "#B21151",
          700: "#7F0C3A",
          800: "#4B0722",
          900: "#18020B",
          950: "#000000",
        },
      },
    },
  },
  plugins: [],
};
