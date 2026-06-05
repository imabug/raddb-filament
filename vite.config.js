import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/dashboard/theme.css', 'resources/css/filament/admin/theme.css', 'resources/css/filament/raddb/theme.css', 'resources/css/filament/shielding/theme.css'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    input: [
        'resources/css/filament/admin/theme.css',
        'resources/css/filament/dashboard/theme.css',
        'resources/css/filament/raddb/theme.css',
        'resources/css/filament/shielding/theme.css',
    ]
});
