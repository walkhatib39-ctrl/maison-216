import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';
import flowbiteTypography from 'flowbite-typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#faf9f7',
                    100: '#f3f0eb',
                    200: '#e6dfd4',
                    300: '#d4c8b5',
                    400: '#c4b08a',
                    500: '#b69352', // Logo gold
                    600: '#a37d41',
                    700: '#8a6635',
                    800: '#70532d',
                    900: '#5a4326',
                },
                dark: {
                    50: '#f7f7f6',
                    100: '#e3e3e2',
                    200: '#c6c6c4',
                    300: '#a4a4a1',
                    400: '#818179',
                    500: '#666660',
                    600: '#525248',
                    700: '#434339',
                    800: '#383830',
                    900: '#22201d', // Logo dark
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'fade-in-up': 'fadeInUp 0.6s ease-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'slide-left': 'slideLeft 0.5s ease-out',
                'slide-right': 'slideRight 0.5s ease-out',
                'scale-in': 'scaleIn 0.2s ease-out',
                'float': 'float 3s ease-in-out infinite',
                'pulse-slow': 'pulse 3s ease-in-out infinite',
                'bounce-subtle': 'bounceSubtle 2s ease-in-out infinite',
                'shimmer': 'shimmer 2s linear infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                slideLeft: {
                    '0%': { transform: 'translateX(20px)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                slideRight: {
                    '0%': { transform: 'translateX(-20px)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                scaleIn: {
                    '0%': { transform: 'scale(0.95)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                bounceSubtle: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-5px)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },
        },
    },

    plugins: [forms, flowbite, flowbiteTypography],
};
