/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        primary: "#ff00ff",
        secondary: "#00ff00",
      },
      spacing: {
        custom: "-1rem",
      },
    },
  },
  plugins: [],
};
