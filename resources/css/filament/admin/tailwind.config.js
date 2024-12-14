import preset from "../../../../vendor/filament/filament/tailwind.config.preset";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#7883e7",
                    50: "#eff4fe",
                    100: "#e3eafc",
                    200: "#ccd9f9",
                    300: "#acbff5",
                    400: "#8b9cee",
                    500: "#7883e7",
                    600: "#5355d8",
                    700: "#4445be",
                    800: "#393b9a",
                    900: "#35387a",
                    950: "#1f2047",
                },
            },
        },
    },
    plugins: [forms, typography],
};
