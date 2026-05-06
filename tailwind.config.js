import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
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
                
                // Palette médicale
                brand: {
                    50:  '#eef6ff',
                    100: '#d9eaff',
                    200: '#bcdcff',
                    300: '#8ec7ff',
                    400: '#59a8ff',
                    500: '#3a8bfd',
                    600: '#2470f0',
                    700: '#1e5cd9',
                    800: '#1e4cae',
                    900: '#1d4289',
                    950: '#162a55',
                },
                health: {
                    50:  '#effefb',
                    100: '#c8fbf2',
                    200: '#92f5e6',
                    300: '#54e8d4',
                    400: '#26d0bc',
                    500: '#0fb3a3',
                    600: '#0a8f85',
                    700: '#0d716c',
                    800: '#115a57',
                    900: '#124a48',
                },
            },
            boxShadow: {
                soft: '0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.06)',
                medium: '0 4px 16px rgba(0, 0, 0, 0.06), 0 2px 6px rgba(0, 0, 0, 0.08)',
                hover: '0 8px 24px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.10)',
            },
            animation: {
                'slide-in-right': 'slideInRight 0.3s ease-out',
                'fade-in': 'fadeIn 0.3s ease-out',
            },
            keyframes: {
                slideInRight: {
                    '0%': { transform: 'translateX(100%)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
        },
    },

    plugins: [forms],
};