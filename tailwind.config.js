import preset from "./vendor/filament/filament/tailwind.config.preset";
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
                    DEFAULT: "#57b400",
                    50: "#305a0d",
                    100: "#376b09",
                    200: "#428803",
                    300: "#57b400",
                    400: "#93fa21",
                    500: "#7ff802",
                    600: "#57b400",
                    700: "#d2ff93",
                    800: "#e9ffc6",
                    900: "#f5ffe4",
                },
            },
        },
    },
    plugins: [forms, typography],
};
