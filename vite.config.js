import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['css/main.css', 'js/main.js'],
            refresh: true,
        }),
        vue(),
    ],
});
