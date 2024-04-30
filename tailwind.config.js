/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                nude: "#EB7D7D",
                deepblue: "#1D65CE",
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"'],
            },
        },
    },
    plugins: [],
};
