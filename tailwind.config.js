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
                primary: '#e11d48',
                primaryHover: '#be123c',
                bgSurface: 'var(--bg-surface)',
                bgSurfaceSecondary: 'var(--bg-surface-secondary)',
                textBase: 'var(--text-dark)',
                textMuted: 'var(--text-muted)',
                borderBase: 'var(--border-color)',
            }
        },
    },

    plugins: [forms],
};
