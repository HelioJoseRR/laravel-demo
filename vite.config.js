import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/styles.css',
                'resources/css/profile.css',
                'resources/css/index.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
