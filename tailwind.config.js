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
            colors: {
                npontu: {
                    green: {
                        50:  '#EAF5EE',
                        100: '#C9E6D2',
                        200: '#A4D6B5',
                        500: '#2F8F4D',
                        600: '#1F7A3A',
                        700: '#155C2A',
                        800: '#0F4421',
                        900: '#0A2F17',
                    },
                    yellow: {
                        50:  '#FFFAE6',
                        100: '#FFF1B3',
                        200: '#FFE680',
                        400: '#FFD24A',
                        500: '#F5C518',
                        600: '#D6A800',
                        700: '#A37F00',
                        800: '#7A5C00',
                    },
                },
            },
        },
    },

    plugins: [forms],
};
