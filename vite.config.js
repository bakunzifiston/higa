import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/welcome.css',
                'resources/css/auth-login.css',
                'resources/css/dashboard.css',
                'resources/css/modules.css',
                'resources/js/app.js',
                'resources/js/modules.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        // Avoid native CSS minification crashes in this environment.
        minify: false,
        cssMinify: false,
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
