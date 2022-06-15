module.exports = {
    content: [
      // prettier-ignore
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./resources/**/*.blade.php",
    ],
    darkMode: "class",
    theme: {
      extend: {
        fontFamily: {
          sans: ["Poppins", "sans-serif"],
        },
      },
    },
    plugins: [
      require("tailwindcss"),
      require("autoprefixer"),
      require("postcss-import"),
      require("@tailwindcss/forms"),
      require("@tailwindcss/line-clamp"),
      require("@tailwindcss/typography"),
      require("@tailwindcss/aspect-ratio"),
      require("@tailwindcss/custom-forms"),
    ],
  };
  