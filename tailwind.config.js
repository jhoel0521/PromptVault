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
                primary: '#e11d48',
                primaryHover: '#be123c',
                bgSurface: 'var(--bg-surface)',
                bgSurfaceSecondary: 'var(--bg-surface-secondary)',
                textBase: 'var(--text-dark)',
                textMuted: 'var(--text-muted)',
                borderBase: 'var(--border-color)',
            },
            animation: {
                'float': 'float 10s infinite',
                'gridMove': 'gridMove 20s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                gridMove: {
                    '0%': { transform: 'perspective(500px) rotateX(60deg) translateY(-100px) translateZ(-200px)' },
                    '100%': { transform: 'perspective(500px) rotateX(60deg) translateY(0px) translateZ(-200px)' },
                },
            },
        },
    },

    plugins: [forms],
};
