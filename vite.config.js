import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // ✅ Tambahkan file ini agar ikut dibundle
                'resources/js/pasien/detail.js',
                'resources/js/pasien/index.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
