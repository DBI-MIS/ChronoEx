import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },


    plugins: [forms, require('daisyui'),],
    darkMode: 'class',
    // variants: { extend: { display: ['dark'], } },

    daisyui: {
        themes: [
            "light",
            "dark",
            "cupcake",
            "sunset",
        ],
        darkTheme: "sunset",
        lightTheme: "cupcake",
        // base: true, 
        // styled: true, 
        // utils: true, 
        // themeRoot: ":root",
    },
};
